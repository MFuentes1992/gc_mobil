<?php 
        require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
        require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaObjectModel.php";
        require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaPeatonModel.php";

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
                    `multiple_entrada`, `notificaciones`, `uniqueID`, `nombre_visita`, `fecha_registro`, `fecha_actualizacion` ,`estatus_registro`) 
                    VALUES (%d, %d, %d, %d, '%s', '%s', %d, %d, '%s', '%s', '%s', '%s', %d)", 
                    $visita->getIdUsuario(), $visita->getIdTipoVisita(), $visita->getIdTipoIngreso(), $visita->getIdInstalacion(), $visita->getFechaIngreso(), $visita->getFechaSalida(), $visita->getMultipleEntrada(),
                    $visita->getNotificaciones(), $visita->getUniqueID(), $visita->getNombreVisita(), date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), $visita->getEstatusRegistro());            
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
                        return $visita->getUniqueID();
                    } else {
                        return false;
                    }                  
            } catch (\Throwable $th) {
                echo $th;
            }            
        }
    
            public function updateVisita(int $idVisita, int $idTipoVisita, int $idTipoIngreso, string $fechaIngreso, string $fechaSalida, int $multipleEntrada, int $notificaciones, string $nombreVisita, int $estatusRegistro, string $vehicles) {
                try {
                    $query = sprintf("UPDATE `visitas` SET `id_tipo_visita` = %d, `id_tipo_ingreso` = %d, `fecha_ingreso` = '%s', `fecha_salida` = '%s', `multiple_entrada` = %d, `notificaciones` = %d, `nombre_visita` = '%s', `fecha_actualizacion` = '%s', `estatus_registro` = %d WHERE `id` = %d", $idTipoVisita, $idTipoIngreso, $fechaIngreso, $fechaSalida, $multipleEntrada, $notificaciones, $nombreVisita, date("Y-m-d H:i:s"), $estatusRegistro, $idVisita);
                    $res = $this->execQuery($query);                
                    if($res) {                    
                        $data = json_decode($vehicles, true);                                        
                        foreach($data as $vehicle) {
                            $vehicleId = $vehicle["vehicle_id"];
                            if(isset($vehicleId)) {
                                $vehicleBrand = $vehicle["brand"];
                                $vehicleModel = $vehicle["model"];
                                $vehicleYear = $vehicle["year"];
                                $vehiclePlates = $vehicle["plates"];
                                $vehicleColor = $vehicle["color"];
                                if($vehicleModel != "" && $vehiclePlates != "" 
                                && $vehicleColor != "" && $vehicleYear != "" 
                                && $vehicleBrand != "") {                                                                     
                                    $this->updateVehicle($vehicleId, $vehicleBrand, $vehicleModel, $vehicleYear, $vehiclePlates, $vehicleColor, 1);                        
                                }
                            } else {
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
    
            public function updateVehicle(int $idVehicle, string $marca, string $modelo, string $anio, string $placas, string $color, int $estatusRegistro) {
                try {
                    $query = sprintf("UPDATE `visitas_vehiculos` SET `marca` = '%s', `modelo` = '%s', `anio` = '%s', `placas` = '%s', `color` = '%s', `fecha_actualizacion` = '%s', `estatus_registro` = %d WHERE `id` = %d", $marca, $modelo, $anio, $placas, $color, date("Y-m-d H:i:s"), $estatusRegistro, $idVehicle);
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
        }

?>