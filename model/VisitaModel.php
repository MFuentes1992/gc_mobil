<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
    class Visit extends Connection {
        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        }        
        public function createVisita(int $idUsuario, int $idTipoVisita, int $idTipoIngreso, int $idInstalacion, string $fechaIngreso, string $fechaSalida,
        int $multipleEntrada, int $notificaciones, string $nombreVisita, int $estatusRegistro, string $vehicles) {
        try {  
            $uniqueID = uniqid('', true);              
            $query = sprintf("INSERT INTO `visitas` 
                (`id_usuario`, `id_tipo_visita`, `id_tipo_ingreso`, `id_instalacion`, `fecha_ingreso`, `fecha_salida`, 
                `multiple_entrada`, `notificaciones`, `uniqueID`, `nombre_visita`, `fecha_registro`, `fecha_actualizacion` ,`estatus_registro`) 
                VALUES (%d, %d, %d, %d, '%s', '%s', %d, %d, '%s', '%s', '%s', '%s', %d)", 
                $idUsuario, $idTipoVisita, $idTipoIngreso, $idInstalacion, $fechaIngreso, $fechaSalida, $multipleEntrada,
                $notificaciones, $uniqueID, $nombreVisita, date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), $estatusRegistro);            
            $res = $this->execQuery($query);
                if($res) {
                    $lastId = $this->getConnection()->insert_id;                    
                    $data = json_decode($vehicles, true);                                      ;                                      
                    foreach($data as $vehicle) {                        
                        $vehicleBrand = $vehicle["brand"];
                        $vehicleModel = $vehicle["model"];
                        $vehicleYear = $vehicle["year"];
                        $vehiclePlates = $vehicle["plates"];
                        $vehicleColor = $vehicle["color"];
                        if($vehicleModel != "" && $vehiclePlates != "" 
                        && $vehicleColor != "" && $vehicleYear != "" 
                        && $vehicleBrand != "") {                                                                     
                            $this->createVehiculoVisita($lastId, $vehicleBrand, $vehicleModel, $vehicleYear, $vehiclePlates, $vehicleColor, 1);                        
                        }
                    }
                    return $uniqueID;
                } else {
                    return false;
                }                  
        } catch (\Throwable $th) {
            echo $th;
        }            
    }

        public function createVehiculoVisita(int $idVisita, string $marca, string $modelo, string $anio, string $placas, string $color, int $estatusRegistro){
            try {
                $query = sprintf("INSERT INTO `visitas_vehiculos` (`id_visita`, `marca`, `modelo`, `anio`, `placas`, `color`, `fecha_registro`, `fecha_actualizacion`, `estatus_registro`) 
                VALUES (%d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', %d)", 
                $idVisita, $marca, $modelo, $anio, $placas, $color, date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), $estatusRegistro);                
                return $this->execQuery($query);
            } catch (\Throwable $th) {
                echo $th;
            }
        }

        public function getAllvisitByOwner(string $email) {
            try {                
                $query = sprintf("SELECT 
                v.nombre_visita as nombre,
                v.fecha_ingreso as desde, 
                v.fecha_salida as hasta,
                 ti.tipo_ingreso as tipo, 
                v.multiple_entrada as acceso, 
                v.notificaciones as avisos, 
                u.email,
                tv.tipo_visita,
                v.uniqueID,
                v.estatus_registro as estado
            FROM visitas as v RIGHT JOIN users as u
            ON v.id_usuario =  u.id
            JOIN lst_tipo_ingreso_visita as ti 
            ON v.id_tipo_ingreso = ti.id
            JOIN lst_tipo_visita as tv
            ON v.id_tipo_visita = tv.id
            WHERE u.email = '%s' AND v.estatus_registro = 1", $email);
                return $this->execQuery($query);                   
            } catch (\Throwable $th) {
                echo $th;
            }   
        }

        public function getAllVisitsByInstalacion(int $idInstalacion, string $email) {
            try {                
                $query = sprintf("SELECT
                v.nombre_visita as nombre,
                v.fecha_ingreso as desde,
                v.fecha_salida as hasta,
                ti.tipo_ingreso as tipo,
                v.multiple_entrada as multiple_entrada,
                v.notificaciones as notificaciones,
                u.email as emailAutor,
                tv.tipo_visita,
                v.uniqueID,
                i.seccion as seccion,
                i.numero as num_int,
                r.nombre as residencial,
                r.calle as calle,
                r.numero_ext as num_ext,
                r.colonia as colonia,
                r.ciudad as ciudad,
                r.estado as estado,
                r.codigo_postal as cp,
            v.estatus_registro as estado
        FROM visitas as v RIGHT JOIN users as u
        ON v.id_usuario =  u.id
        JOIN lst_tipo_ingreso_visita as ti 
        ON v.id_tipo_ingreso = ti.id    
        JOIN lst_tipo_visita as tv  
        ON v.id_tipo_visita = tv.id
        JOIN instalaciones as i
        ON i.id = %d
        JOIN recintos as r
        ON r.id = i.id_recinto
        WHERE v.id_instalacion = %d and u.email = '%s' AND v.estatus_registro = 1", $idInstalacion, $idInstalacion, $email);             
                return $this->execQuery($query);                   
            } catch (\Throwable $th) {
                echo $th;
            }   
        }

        public function getAllVisitsByInstalacionType(int $idInstalacion, string $tipoVisita, string $email) {
            try {                
                $query = sprintf("SELECT
                v.nombre_visita as nombre,
                v.fecha_ingreso as desde,
                v.fecha_salida as hasta,
                ti.tipo_ingreso as tipo,
                v.multiple_entrada as multiple_entrada,
                v.notificaciones as notificaciones,
                u.email as emailAutor,
                tv.tipo_visita,
                v.uniqueID,
                i.seccion as seccion,
                i.numero as num_int,
                r.nombre as residencial,
                r.calle as calle,
                r.numero_ext as num_ext,
                r.colonia as colonia,
                r.ciudad as ciudad,
                r.estado as estado,
                r.codigo_postal as cp,
            v.estatus_registro as estado
        FROM visitas as v RIGHT JOIN users as u
        ON v.id_usuario =  u.id
        JOIN lst_tipo_ingreso_visita as ti 
        ON v.id_tipo_ingreso = ti.id    
        JOIN lst_tipo_visita as tv  
        ON v.id_tipo_visita = tv.id
        JOIN instalaciones as i
        ON i.id = %d
        JOIN recintos as r
        ON r.id = i.id_recinto
        WHERE v.id_instalacion = %d and u.email = '%s' AND v.estatus_registro = 1 AND tv.id in (%s)", $idInstalacion, $idInstalacion, $email, $tipoVisita);        
                return $this->execQuery($query);                   
            } catch (\Throwable $th) {
                echo $th;
            }  
        }


        public function readQR(string $qr) {
            try {                
                $query = sprintf("SELECT 
                v.id as visita_id,
                v.nombre_visita as nombre,
                v.fecha_ingreso as desde,
                v.fecha_salida as hasta,
                ti.id as tipo_ingreso,
                ti.tipo_ingreso as tipoIngresoText,
                v.multiple_entrada as multiple_entrada,
                v.notificaciones as notificaciones,
                u.name as nameAutor,
                u.email as emailAutor,
                tv.id as tipo_visita,
                tv.tipo_visita as tipoVisitaText,
                v.uniqueID,
                i.seccion as seccion,
                i.numero as num_int,
                r.nombre as residencial,
                r.calle as calle,
                r.numero_ext as num_ext,
                r.colonia as colonia,
                r.ciudad as ciudad,
                r.estado as estado,
                r.codigo_postal as cp,
            v.estatus_registro as estado 
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
            WHERE v.uniqueID = '%s' AND v.estatus_registro = 1", $qr);                        
                return $this->execQuery($query);                   
            } catch (\Throwable $th) {
                echo $th;
            }
        }

        public function getVehiclesByVisit(string $qr) {
            try {                
                $query = sprintf("SELECT 
                vv.marca as marca,
                vv.modelo as modelo,
                vv.anio as anio,
                vv.placas as placas,
                vv.color as color
            FROM visitas_vehiculos as vv
            JOIN visitas as v
            ON vv.id_visita = v.id
            WHERE v.uniqueID = '%s'", $qr);                        
                return $this->execQuery($query);                   
            } catch (\Throwable $th) {
                echo $th;
            }
        }
    }
?>