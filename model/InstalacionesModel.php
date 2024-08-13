<?php 
require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
class InstalacionesModel extends Connection {
    function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
        parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
    }
    public function getAllInstalaciones(string $instalaciones) {
        try {                 
            $query = vsprintf("SELECT
            i.id as id,
            i.seccion as manzana,
            i.numero as num_int,
            r.nombre as residencial,
            r.calle as calle,
            r.numero_ext as num_ext,
            r.colonia as colonia,
            r.ciudad as ciudad,
            r.estado as estado,
            r.codigo_postal as cp,
            r.logo
            FROM instalaciones as i LEFT JOIN recintos as r
            ON r.id = i.id_recinto
            WHERE i.id in ( %s ) AND
            i.estatus_registro = 1", array($instalaciones));
            $cleanQuery = str_replace('"', '', $query);                 
            return $this->execQuery($cleanQuery);                   
        } catch (\Throwable $th) {
            echo $th;
        }            
    }

    public function getInstalacionesReferenciaPago(int $instalacionId) {
        try {
            $query = sprintf("SELECT i.referencia_concepto, i.referencia_centavos, i.referencia_bancaria FROM instalaciones as i WHERE id = %d", $instalacionId);
            return $this->execQuery($query); 
        } catch (\Throwable $th) {
            echo $th;
        }
    }
}
?>