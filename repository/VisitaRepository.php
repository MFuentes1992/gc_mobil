<?php 
        require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
        require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaObjectModel.php";
        require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaPeatonModel.php";
        require_once $_SERVER['DOCUMENT_ROOT']."/model/response/VisitaResponse.php";
        require_once $_SERVER['DOCUMENT_ROOT']."/model/VehicleModel.php";

        Class VisitaRepository extends Connection {
            private $table = "visitas";

            function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
                parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
            } 

            public function getVisitaByQr(string  $qr) {
                try {
                    $query = sprintf("SELECT * FROM %s WHERE uniqueID = '%s' AND estatus_registro = 1", $this->table, $qr);
                    $resQuery = $this->execQuery($query);
                    $visita = new VisitaObjectModel();
                    if($resQuery && $resQuery->num_rows > 0) {
                        $row = $resQuery->fetch_array();
                        $visita->setId($row["id"]);
                        $visita->setIdUsuario($row["id_usuario"]);
                        $visita->setIdTipoVisita($row["id_tipo_visita"]);
                        $visita->setIdTipoIngreso($row["id_tipo_ingreso"]);
                        $visita->setIdInstalacion($row["id_instalacion"]);
                        $visita->setFechaIngreso($row["fecha_ingreso"]);
                        $visita->setFechaSalida($row["fecha_salida"]);
                        $visita->setMultipleEntrada($row["multiple_entrada"]);
                        $visita->setNotificaciones($row["notificaciones"]);
                        $visita->setAppGenerado($row["app_generado"]);
                        $visita->setVigenciaQR($row["vigencia_qr"]);
                        $visita->setUniqueID($row["uniqueID"]);
                        $visita->setNombreVisita($row["nombre_visita"]);
                        $visita->setFechaRegistro($row["fecha_registro"]);
                        $visita->setFechaActualizacion($row["fecha_actualizacion"]);
                        $visita->setEstatusRegistro($row["estatus_registro"]);
                    }
                    return $visita;
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }

            public function getVisitaResidencialByQR(string $qr) {
                try {                
                    $query = sprintf("SELECT 
                    v.id as visitaId,
                    tv.id as idTipoVisita,
                    ti.id as idTipoIngreso,
                    u.id as idUsuario,
                    v.fecha_ingreso as fechaIngreso,
                    v.fecha_salida as fechaSalida,
                    v.multiple_entrada as multiple,
                    v.notificaciones as notificaciones,
                    v.app_generado as appGenerado,
                    v.vigencia_qr as vigenciaQR,
                    v.uniqueID as uniqueId,
                    u.name as autor,                    
                    u.email as emailAutor,
                    i.seccion as residencialSeccion,
                    i.numero as residencialNumInterior,
                    r.numero_ext as residencialNumExterior,
                    r.calle as residencialCalle,
                    r.colonia as residencialColonia,
                    r.ciudad as residencialCiudad,
                    r.estado as residencialEstado,
                    r.codigo_postal as residencialCP,
                    r.nombre as residencialNombre,
                    v.nombre_visita as nombre,
                    v.estatus_registro as estatusRegistro
                FROM visitas as v RIGHT JOIN users as u
                ON v.id_usuario =  u.id
                JOIN lst_tipo_ingreso_visita as ti 
                ON v.id_tipo_ingreso = ti.id    
                JOIN lst_tipo_visita as tv  
                ON v.id_tipo_visita = tv.id
                JOIN instalaciones as i
                ON i.id = v.id_instalacion
                JOIN recintos as r
                ON r.id = i.id_recinto
                WHERE v.uniqueID = '%s'", $qr);                        
                    $res = $this->execQuery($query);
                    if($res && $res->num_rows > 0) {
                        $row = $res->fetch_array();
                        $visitaResponse = new VisitaResponse(
                            $row["visitaId"],
                            $row["idTipoVisita"],
                            $row["idTipoIngreso"],
                            $row["idUsuario"],
                            $row["fechaIngreso"],
                            $row["fechaSalida"],
                            $row["multiple"],
                            $row["notificaciones"],
                            $row["appGenerado"],
                            $row["vigenciaQR"],
                            $row["uniqueId"],
                            $row["autor"],
                            $row["emailAutor"],
                            $row["residencialSeccion"],
                            $row["residencialNumInterior"],
                            $row["residencialNumExterior"],
                            $row["residencialCalle"],
                            $row["residencialColonia"],
                            $row["residencialCiudad"],
                            $row["residencialEstado"],
                            $row["residencialCP"],
                            $row["residencialNombre"],
                            $row["nombre"],
                            array(),
                            array(),
                            $row["estatusRegistro"]
                        ); 
                        
                        $vehicles = $this->getVehiclesByVisit($row["visitaId"]);
                        $pedestrians = $this->getPedestriansByVisit($row["visitaId"]);
                        $vehiclesArray = array();
                        $pedestriansArray = array();
                        if($vehicles && $vehicles->num_rows > 0) {
                            while($row = $vehicles->fetch_array()) {
                                $vehicle = new Vehicle(
                                    $row["id"],
                                    $row["id_visita"],
                                    $row["conductor"],
                                    $row["marca"],
                                    $row["modelo"],
                                    $row["anio"],
                                    $row["placas"],
                                    $row["color"],
                                    $row["fecha_registro"],
                                    $row["fecha_actualizacion"],
                                    $row["estatus_registro"]
                                );
                                array_push($vehiclesArray, $vehicle);
                            }
                        }
                        if($pedestrians && $pedestrians->num_rows > 0) {
                            while($row = $pedestrians->fetch_array()) {
                                $pedestrian = new VisitasPeaton(
                                    $row["id"],
                                    $row["id_visita"],
                                    $row["nombre"],
                                    $row["fecha_registro"],
                                    $row["fecha_actualizacion"],
                                    $row["estatus_registro"]
                                );
                                array_push($pedestriansArray, $pedestrian);
                            }
                        }
                        $visitaResponse->setVehicles($vehiclesArray);
                        $visitaResponse->setPedestrians($pedestriansArray);
                        return $visitaResponse;
                    } else {
                        return false;
                    }
                } catch (\Throwable $th) {
                    echo $th;
                }
            }

            public function registerPedestrian(VisitasPeaton $visitaPeaton) {
                $table = "visitas_peatones";
                try {
                    $query = sprintf("INSERT INTO 
                        %s (id_visita, nombre, fecha_registro, fecha_actualizacion, estatus_registro) 
                    VALUES (%d, '%s', NOW(), NOW(), 1)", $table, $visitaPeaton->getIdVisita(), $visitaPeaton->getNombre());
                    $resQuery = $this->execQuery($query);
                    return $resQuery;
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
            public function createVisita(VisitaObjectModel $visita) {
            try {  
                            
                $query = sprintf("INSERT INTO `visitas` 
                    (`id_usuario`, `id_tipo_visita`, `id_tipo_ingreso`, `id_instalacion`, `fecha_ingreso`, `fecha_salida`, 
                    `multiple_entrada`, `notificaciones`, `app_generado`, `vigencia_qr`, `uniqueID`, `nombre_visita`, `fecha_registro`, `fecha_actualizacion` ,`estatus_registro`) 
                    VALUES (%d, %d, %d, %d, '%s', '%s', %d, %d, %d, %d,'%s', '%s', '%s', '%s', %d)", 
                    $visita->getIdUsuario(), $visita->getIdTipoVisita(), $visita->getIdTipoIngreso(), $visita->getIdInstalacion(), $visita->getFechaIngreso(), $visita->getFechaSalida(), $visita->getMultipleEntrada(),
                    $visita->getNotificaciones(), $visita->getAppGenerado(), $visita->getVigenciaQR(), $visita->getUniqueID(), $visita->getNombreVisita(), date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), $visita->getEstatusRegistro());            
                    $res = $this->execQuery($query);
                    if($res) {
                        $lastId = $this->getConnection()->insert_id;                                                          
                        foreach($visita->getVehicles() as $vehicle) {                             
                            $vehicleDriver = $vehicle->getConductor();                       
                            $vehicleBrand = $vehicle->getMarca();
                            $vehicleModel = $vehicle->getModelo();
                            $vehicleYear = $vehicle->getAnio();
                            $vehiclePlates = $vehicle->getPlacas();
                            $vehicleColor = $vehicle->getColor();                            
                            if($vehicleModel != "" && $vehiclePlates != "" 
                            && $vehicleColor != "" && $vehicleYear != "" 
                            && $vehicleBrand != "") {                                                                     
                                $this->createVehiculoVisita($lastId, $vehicleDriver, $vehicleBrand, $vehicleModel, $vehicleYear, $vehiclePlates, $vehicleColor, 1);                        
                            }
                        }
                        foreach($visita->getPedestrians() as $pedestrian) {
                            $this->createPedestrian($lastId, $pedestrian->getNombre(), $pedestrian->getEstatusRegistro());
                        }
                        return $visita->getUniqueID();
                    } else {
                        return false;
                    }                  
            } catch (\Throwable $th) {
                echo $th;
            }            
        }
    
            public function updateVisita(VisitaObjectModel $visita) {
                try {
                    $query = sprintf("UPDATE `visitas` 
                        SET `id_tipo_visita` = %d, 
                        `id_tipo_ingreso` = %d, 
                        `fecha_ingreso` = '%s', 
                        `fecha_salida` = '%s', 
                        `multiple_entrada` = %d, 
                        `notificaciones` = %d, 
                        `nombre_visita` = '%s', 
                        `fecha_actualizacion` = '%s', 
                        `estatus_registro` = %d WHERE `id` = %d", 
                        $visita->getIdTipoVisita(), 
                        $visita->getIdTipoIngreso(), 
                        $visita->getFechaIngreso(), 
                        $visita->getFechaSalida(), 
                        $visita->getMultipleEntrada(), 
                        $visita->getNotificaciones(),
                        $visita->getNombreVisita(),
                        date("Y-m-d H:i:s"), 
                        $visita->getEstatusRegistro(), 
                        $visita->getId()
                    );
                    $res = $this->execQuery($query);                
                    if($res) {                                                                                   
                        foreach($visita->getVehicles() as $vehicle) {
                            $vehicleId = $vehicle->getId();
                            if(isset($vehicleId) && $vehicleId > 0) {
                                $vehicleDriver = $vehicle->getConductor();
                                $vehicleBrand = $vehicle->getMarca();
                                $vehicleModel = $vehicle->getModelo();
                                $vehicleYear = $vehicle->getAnio();
                                $vehiclePlates = $vehicle->getPlacas();
                                $vehicleColor = $vehicle->getColor();
                                if($vehicleModel != "" && $vehiclePlates != "" 
                                && $vehicleColor != "" && $vehicleYear != "" 
                                && $vehicleBrand != "") {                                                                     
                                    $this->updateVehicle($vehicleId, $vehicleDriver, $vehicleBrand, $vehicleModel, $vehicleYear, $vehiclePlates, $vehicleColor, 1);                        
                                }
                            } else {
                                $vehicleDriver = $vehicle->getConductor();
                                $vehicleBrand = $vehicle->getMarca();
                                $vehicleModel = $vehicle->getModelo();
                                $vehicleYear = $vehicle->getAnio();
                                $vehiclePlates = $vehicle->getPlacas();
                                $vehicleColor = $vehicle->getColor();
                                if($vehicleModel != "" && $vehiclePlates != "" 
                                && $vehicleColor != "" && $vehicleYear != "" 
                                && $vehicleBrand != "") {                                                                     
                                    $this->createVehiculoVisita($visita->getId(), $vehicleDriver, $vehicleBrand, $vehicleModel, $vehicleYear, $vehiclePlates, $vehicleColor, 1);                        
                                }
                            }
                        }  

                        foreach($visita->getPedestrians() as $pedestrian) {
                            $pedestrianId = $pedestrian->getId();
                            if(isset($pedestrianId) && $pedestrianId > 0) {
                                $pedestrianName = $pedestrian->getNombre();
                                $this->updatePedestrian($pedestrianId, $pedestrianName, 1);
                            } else {
                                $pedestrianName = $pedestrian->getNombre();
                                $this->createPedestrian($visita->getId(), $pedestrianName, 1);
                            }
                        }
                    }
                    return $res;
                } catch (\Throwable $th) {
                    echo $th;
                }
            }
    
            public function createMultipleVehicles(int $idVisita, string $vehicles) {
                try {
                    $data = json_decode($vehicles, true);                                        
                    foreach($data as $vehicle) {
                        $vehicleBrand = $vehicle["brand"];
                        $vehicleModel = $vehicle["model"];
                        $vehicleYear = $vehicle["year"];
                        $vehiclePlates = $vehicle["plates"];
                        $vehicleColor = $vehicle["color"];
                        if($vehicleModel != "" && $vehiclePlates != "" 
                        && $vehicleColor != "" && $vehicleYear != "" 
                        && $vehicleBrand != "") {                                                                     
                            $this->createVehiculoVisita($idVisita, "", $vehicleBrand, $vehicleModel, $vehicleYear, $vehiclePlates, $vehicleColor, 1);                        
                        }
                    }
                    return true;
                } catch (\Throwable $th) {
                    echo $th;
                }
            }
    
            public function createVehiculoVisita(int $idVisita, string $driver, string $marca, string $modelo, string $anio, string $placas, string $color, int $estatusRegistro){
                try {
                    $query = sprintf("INSERT INTO `visitas_vehiculos` (`id_visita`, `conductor`, `marca`, `modelo`, `anio`, `placas`, `color`, `fecha_registro`, `fecha_actualizacion`, `estatus_registro`) 
                    VALUES (%d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %d)", 
                    $idVisita, $driver, $marca, $modelo, $anio, $placas, $color, date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), $estatusRegistro);                
                    return $this->execQuery($query);
                } catch (\Throwable $th) {
                    echo $th;
                }
            }

            //create pedestrian function
            public function createPedestrian(int $idVisita, string $nombre, int $estatusRegistro) {
                try {
                    $query = sprintf("INSERT INTO `visitas_peatones` (`id_visita`, `nombre`, `fecha_registro`, `fecha_actualizacion`, `estatus_registro`) 
                    VALUES (%d, '%s', '%s', '%s', %d)", 
                    $idVisita, $nombre, date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), $estatusRegistro);                
                    return $this->execQuery($query);
                } catch (\Throwable $th) {
                    echo $th;
                }
            }
    
            public function updateVehicle(int $idVehicle, string $conductor, string $marca, string $modelo, string $anio, string $placas, string $color, int $estatusRegistro) {
                try {
                    $query = sprintf("UPDATE `visitas_vehiculos` SET `conductor` = '%s', `marca` = '%s', `modelo` = '%s', `anio` = '%s', `placas` = '%s', `color` = '%s', `fecha_actualizacion` = '%s', `estatus_registro` = %d WHERE `id` = %d", $conductor, $marca, $modelo, $anio, $placas, $color, date("Y-m-d H:i:s"), $estatusRegistro, $idVehicle);
                    return $this->execQuery($query);
                } catch (\Throwable $th) {
                    echo $th;
                }
            }
    
            public function updatePedestrian(int $idPedestrian, string $nombre, int $estatusRegistro) {
                try {
                    $query = sprintf("UPDATE `visitas_peatones` SET `nombre` = '%s', `fecha_actualizacion` = '%s', `estatus_registro` = %d WHERE `id` = %d", 
                    $nombre, date("Y-m-d H:i:s"), $estatusRegistro, $idPedestrian);
                    return $this->execQuery($query);
                } catch (\Throwable $th) {
                    echo $th;
                }
            }

            public function deleteVehicle(int $idVehicle) {
                try {
                    $query = sprintf("DELETE FROM `visitas_vehiculos` WHERE `id` = %d", $idVehicle);
                    return $this->execQuery($query);
                } catch (\Throwable $th) {
                    echo $th;
                }
            }

            public function deletePedestrian(int $idPedestrian) {
                try {
                    $query = sprintf("UPDATE `visitas_peatones` `estatus_registro` = 0 WHERE `id` = %d", $idPedestrian);
                    return $this->execQuery($query);
                } catch (\Throwable $th) {
                    echo $th;
                }
            }

            public function getVisitaById(int $idVisita) {
                try {
                    $query = sprintf("SELECT * FROM `visitas` WHERE `id` = %d", $idVisita);
                    return $this->execQuery($query);
                } catch (\Throwable $th) {
                    echo $th;
                }
            }

            public function getVehiclesByVisit(int $idVisita) {
                try {
                    $query = sprintf("SELECT * FROM `visitas_vehiculos` WHERE `id_visita` = %d AND `estatus_registro` = 1", $idVisita);
                    return $this->execQuery($query);
                } catch (\Throwable $th) {
                    echo $th;
                }
            }

            public function getPedestriansByVisit(int $idVisita) {
                try {
                    $query = sprintf("SELECT * FROM `visitas_peatones` WHERE `id_visita` = %d AND `estatus_registro` = 1", $idVisita);
                    return $this->execQuery($query);
                } catch (\Throwable $th) {
                    echo $th;
                }
            }
        }

?>