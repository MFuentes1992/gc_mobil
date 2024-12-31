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

    public function getPeatonesByVisitaUniqueId(string $uniqueId) {
        $query = sprintf("SELECT 
            vp.id,
            vp.id_visita,
            vp.nombre
        FROM visitas_peatones as vp
        INNER JOIN visitas as v
        ON v.id = vp.id_visita WHERE v.uniqueID = '%s' LIMIT 1", $uniqueId);
        $result = $this->execQuery($query);  
        if(!$result) {
            return null;
        }           
        $peatonRow = $result->fetch_assoc();
        $peaton = new VisitasPeaton($peatonRow['id'], $peatonRow['id_visita'], $peatonRow['nombre'], $peatonRow['fecha_registro'], $peatonRow['fecha_actualizacion'],$peatonRow['estatus_registro']);
        return $peaton;
    }

    public function deleteVisitaPeaton($id) {
        $query = "UPDATE $this->table SET `estatus_registro` = 0 WHERE id = $id";
        $result = $this->execQuery($query);
        return $result;
    }
}
?>