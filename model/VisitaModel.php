<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
    class Visit extends Connection {
        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        }
        public function createVisita(int $idUsuario, int $idTipoVisita, int $idTipoIngreso, string $fechaIngreso, string $fechaSalida,
            int $multipleEntrada, int $notificaciones, string $nombreVisita, int $estatusRegistro) {
            try {                
                $query = sprintf("INSERT INTO `visitas` 
                    (`id_usuario`, `id_tipo_visita`, `id_tipo_ingreso`, `fecha_ingreso`, `fecha_salida`, 
                    `multiple_entrada`, `notificaciones`, `uniqueID`, `nombre_visita`, `fecha_registro`, `fecha_actualizacion` ,`estatus_registro`) 
                    VALUES (%d, %d, %d, '%s', '%s', %d, %d, '%s', '%s', '%s', '%s', %d)", 
                    $idUsuario, $idTipoVisita, $idTipoIngreso, $fechaIngreso, $fechaSalida, $multipleEntrada,
                    $notificaciones, uniqid('', true), $nombreVisita, date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), $estatusRegistro);
                return $this->execQuery($query);                   
            } catch (\Throwable $th) {
                echo $th;
            }            
        }
    }

?>