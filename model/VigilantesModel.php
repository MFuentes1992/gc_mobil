<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
    class Vigilante extends Connection {
        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        }
        public function getActivationCode(string $code) {
            try {
                $query = sprintf("SELECT * FROM `codigos_vigilancia` WHERE `codigo_activacion` = '%s'", $code);
                $res = $this->execQuery($query);
                return $res;
            } catch (\Throwable $th) {
                echo $th;
            }
        }

        public function updateActivationCode(string $code){
            try {
                $query = sprintf("UPDATE `codigos_vigilancia` SET `estatus_uso` = 1 WHERE `codigo_activacion` = '%s'", $code);
                return $this->execQuery($query);
            } catch (\Throwable $th) {
                echo $th;
            }
        }
    }

?>