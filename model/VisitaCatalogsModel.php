<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
    class VisitaCatalogs extends Connection {
        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        }
        public function getAllTipoVisita() {
            try {                
                $query = sprintf("SELECT * FROM lst_tipo_visita");
                return $this->execQuery($query);                   
            } catch (\Throwable $th) {
                echo $th;
            }   
        }
        public function getAllTipoIngreso() {
            try {                
                $query = sprintf("SELECT * FROM lst_tipo_ingreso_visita");
                return $this->execQuery($query);                   
            } catch (\Throwable $th) {
                echo $th;
            }   
        }
    }
?>