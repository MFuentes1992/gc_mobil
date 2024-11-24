<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
    class Vigilante extends Connection {
        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        }
        public function getActivationCode(string $code) {
            try {
                $query = sprintf("SELECT 
                    cv.id,
                    cv.id_caseta,
                    c.id_recinto,
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

        public function getCasetaInformation(string $activationCode) {
            try {
                $query = sprintf("SELECT 
                c.numero_celular,
                c.id_recinto,
                c.numero_telefono,
                c.extension_telefono,
                r.nombre,
                r.logo,
                CONCAT(r.calle, ' ', r.numero_ext, ', ', r.colonia, ', ', r.ciudad, ', ', r.codigo_postal, ', ', r.estado) as direccion
                FROM info_caseta_vigilancia as c
                LEFT JOIN recintos as r
                ON c.id_recinto = r.id
                LEFT JOIN codigos_vigilancia as cv
                ON c.id = cv.id_caseta
                WHERE cv.codigo_activacion = '%s' AND c.estatus_registro = 1 AND r.estatus_registro = 1", $activationCode);
                $res = $this->execQuery($query);
                return $res;
            } catch (\Throwable $th) {
                echo $th;
            }
        }
    }

?>