<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";

    class Recibos extends Connection {
        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        }

        function getRecibosByInstalacionResidente(int $residenteId, int $instalacionId, int $recintoId) {
            try {
                $query = sprintf("SELECT * FROM recibos WHERE id_residente = %d AND id_instalacion = %d AND id_recinto = %d", $residenteId, $instalacionId, $recintoId);
                return $this->execQuery($query);
            } catch (\Throwable $th) {
                echo $th;
            }
        }

        function getRecibosByInstalacionResidenteLast(int $residenteId, int $instalacionId, int $recintoId) {
            try {
                $query = sprintf("SELECT * FROM recibos WHERE id_residente = %d AND id_instalacion = %d AND id_recinto = %d order by fecha_elaboracion DESC limit 1", $residenteId, $instalacionId, $recintoId);
                return $this->execQuery($query);
            } catch (\Throwable $th) {
                echo $th;
            }
        }
    }

?>