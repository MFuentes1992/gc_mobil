<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
    class Visit extends Connection {
        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        }        
        public function createVisita(int $idUsuario, int $idTipoVisita, int $idTipoIngreso, int $idInstalacion, string $fechaIngreso, string $fechaSalida,
        int $multipleEntrada, int $notificaciones, string $nombreVisita, int $estatusRegistro, string $vehicleModel, string $vehiclePlates, string $vehicleColor) {
        try {  
            $uniqueID = uniqid('', true);              
            $query = sprintf("INSERT INTO `visitas` 
                (`id_usuario`, `id_tipo_visita`, `id_tipo_ingreso`, `id_instalacion`, `fecha_ingreso`, `fecha_salida`, 
                `multiple_entrada`, `notificaciones`, `uniqueID`, `nombre_visita`, `fecha_registro`, `fecha_actualizacion` ,`estatus_registro`,
                `modelo_vehiculo`, `color_vehiculo`, `placa_vehiculo`) 
                VALUES (%d, %d, %d, %d, '%s', '%s', %d, %d, '%s', '%s', '%s', '%s', %d, '%s', '%s', '%s')", 
                $idUsuario, $idTipoVisita, $idTipoIngreso, $idInstalacion, $fechaIngreso, $fechaSalida, $multipleEntrada,
                $notificaciones, $uniqueID, $nombreVisita, date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), $estatusRegistro,
                $vehicleModel, $vehicleColor, $vehiclePlates);            
            $res = $this->execQuery($query);
                if($res) {
                    return $uniqueID;
                } else {
                    return false;
                }                  
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

    }

?>