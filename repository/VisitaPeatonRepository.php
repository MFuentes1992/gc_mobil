<?php 

require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaPeatonModel.php";
Class VisitaPeatonRepository extends Connection {
    private $table = "visitas_peatones";
    
    function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
        parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
    } 

    public function getVisitaPeatonById($id) {
        $query = "SELECT * FROM $this->table WHERE id = $id";
        $result = $this->execQuery($query);                     
        if(!$result) {
            return null;
        }
        $visitaPeatonRow = $result->fetch_assoc();
        $visitaPeaton = new VisitasPeaton($visitaPeatonRow['id'], $visitaPeatonRow['id_visita'], $visitaPeatonRow['nombre'], $visitaPeatonRow['fecha_registro'], $visitaPeatonRow['fecha_actualizacion'],$visitaPeatonRow['estatus_registro']);            
        return $visitaPeaton;
    }
}
?>