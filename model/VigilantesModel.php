<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
    class Vigilante extends Connection {
        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        }
        public function getActivationCode(string $code) {
            try {
                // $query = sprintf("SELECT * FROM `codigos_vigilancia` WHERE `codigo_activacion` = '%s' AND `estatus_registro` = 1", $code);
                $query = sprintf("SELECT 
                    cv.id,
                    cv.id_caseta,
                    cv.codigo_activacion,
                    cv.estatus_registro,
                    cv.estatus_uso,
                    c.caseta,
                    c.numero_celular
                FROM codigos_vigilancia as cv LEFT JOIN info_caseta_vigilancia as c
                ON cv.id_caseta = c.id
                WHERE codigo_activacion = '%s' AND cv.estatus_registro = 1", $code);
                $res = $this->execQuery($query);
                return $res;
            } catch (\Throwable $th) {
                echo $th;
            }
        }

        public function updateActivationCode(string $code){
            try {
                $query = sprintf("UPDATE `codigos_vigilancia` SET `estatus_uso` = 1 WHERE `codigo_activacion` = '%s' AND `estatus_registro` = 1", $code);
                return $this->execQuery($query);
            } catch (\Throwable $th) {
                echo $th;
            }
        }
    }

?>