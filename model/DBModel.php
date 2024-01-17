<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
    class DBModel extends Connection {
        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        }
        public function getClientDB(string $code) {
            try {                
                $query = sprintf("SELECT * FROM empresas_administradoras WHERE codigo = '%s' AND estatus = 1", $code);
                return $this->execQuery($query);                   
            } catch (\Throwable $th) {
                echo $th;
            }            
        }
    }
?>