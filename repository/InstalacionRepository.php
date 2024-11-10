<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/model/response/InstalacionesUserResponse.php";
    Class InstalacionRepository extends Connection {
        private $table = 'instalaciones';
        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        }

        public function getInstalacionesByRecinto(int $recintoId) {
            try {
                $query = sprintf("SELECT 
                i.id as idInstalacion,
                i.seccion,
                i.numero as numInt,
                usersInfo.id as idUsuario,
                usersInfo.name as owner
                FROM %s as i
                INNER JOIN 
                    (
                        SELECT
                        users.id,
                        users.id_profile,
                        SUBSTRING_INDEX(SUBSTRING_INDEX(users.id_instalacion, ',', numbers.n), ',', -1) idInstalacion,
                        users.name,
                        users.email,
                        users.status
                        FROM
                        (SELECT 1 n UNION ALL SELECT 2
                        UNION ALL SELECT 3 UNION ALL SELECT 4) numbers INNER JOIN users
                        ON CHAR_LENGTH(users.id_instalacion)
                            -CHAR_LENGTH(REPLACE(users.id_instalacion, ',', ''))>=numbers.n-1
                        ORDER BY
                        id, n
                        ) usersInfo
                ON i.id = usersInfo.idInstalacion
                WHERE i.id_recinto = %d and usersInfo.status = 1 AND i.estatus_registro = 1 ", $this->table, $recintoId);
                $raw = $this->execQuery($query);
                $response = array();
                if ($raw->num_rows > 0) {
                    while ($row = $raw->fetch_assoc()) {
                        $instalacion = new InstalacionesUserResponse($row['idInstalacion'], $row['seccion'], $row['numInt'], $row['idUsuario'], $row['owner']);
                        array_push($response, $instalacion);
                    }
                    return $response;
                } else {
                    return null;
                }
            } catch (\Throwable $th) {
                echo $th;
            }
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