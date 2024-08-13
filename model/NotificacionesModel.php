<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
    class Notificaciones extends Connection {
        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        }
        function getDevicesByRecinto(int $recintoId) {
            try {
                $query = sprintf("SELECT * FROM recintos_devices WHERE id_recinto = %d", $recintoId);
                return $this->execQuery($query); 
            } catch (\Throwable $th) {
                echo $th;
            }
        }  

        function getDeviceByDeviceId(string $deviceId) {
            try {
                $query = sprintf("SELECT * FROM recintos_devices WHERE device_id = '%s'", $deviceId);
                return $this->execQuery($query);
            } catch (\Throwable $th) {
                echo $th;
            }
        }

        function registerDevice(int $recintoId, string $deviceId) {
            try {
                $query = sprintf("INSERT INTO recintos_devices (id_recinto, device_id) VALUES (%d, '%s')", $recintoId, $deviceId);
                return $this->execQuery($query);
            } catch (\Throwable $th) {
                echo $th;
            }
        }

        function getAvisosByRecinto(int $recintoId) {
            try {
                $query = sprintf("SELECT * FROM avisos WHERE id_recinto = %d order by fecha_envio DESC", $recintoId);
                return $this->execQuery($query);
            } catch (\Throwable $th) {
                echo $th;
            }
        }

        function getAvisosByDate(int $recintoId, string $date) {
            try {
                $query = sprintf("SELECT * FROM avisos WHERE id_recinto = %d AND fecha_envio >= '%s'", $recintoId, $date);
                echo $query;
                return $this->execQuery($query);
            } catch (\Throwable $th) {
                echo $th;
            }
        }

        function getAvisosAttachments(int $avisoId) {
            try {
                $query = sprintf("SELECT * FROM avisos_archivos WHERE id_aviso = %d", $avisoId);
                return $this->execQuery($query);
            } catch (\Throwable $th) {
                echo $th;
            }
        }

        function getEstadosCuenta(int $residenteId, int $instalacionId) {
            try {
                $query = sprintf("SELECT * FROM estados_cuenta WHERE id_residente = %d AND id_instalacion = %d", $residenteId, $instalacionId);
                return $this->execQuery($query);
            } catch (\Throwable $th) {
                echo $th;
            }
        }

    }
?>