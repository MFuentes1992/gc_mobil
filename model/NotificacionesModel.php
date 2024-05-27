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
    }
?>