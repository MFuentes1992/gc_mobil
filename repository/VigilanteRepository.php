<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/model/response/LogsGetAllResponse.php";

    Class VigilanteRepository extends Connection {

        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        }

        public function getAllRegisteredLogsByCasetaId(int $casetaId) {
            try {
                $query = sprintf("SELECT 
                    v.id as id_visita, 
                    b.id as id_bitacora, 
                    i.id as id_instalacion, 
                    i.seccion, i.numero, 
                    v.nombre_visita, 
                    b.fecha_lectura 
                    FROM bitacora_visita b 
                    INNER JOIN visitas v 
                    ON b.id_visita = v.id 
                    INNER JOIN instalaciones i 
                    ON v.id_instalacion = i.id 
                    INNER JOIN info_caseta_vigilancia cv
                    ON b.id_caseta = cv.id
                    WHERE b.id_caseta = %d AND cv.estatus_registro = 1", $casetaId);
                $resQuery = $this->execQuery($query);
                $logs = array();
                if($resQuery && $resQuery->num_rows > 0) {
                    while($row = $resQuery->fetch_array()) {
                        $log = new LogsGetAllResponse($row["id_visita"], $row["id_bitacora"], $row["id_instalacion"], $row["seccion"], $row["numero"], $row["nombre_visita"], $row["fecha_lectura"]);
                        array_push($logs, $log);
                    }
                }
                return $logs;
            } catch (\Throwable $th) {
                //throw $th;
                echo $th;
            }
        }

        public function getAllRegisteredLogsQueryBuilder(int $casetaId, int $tipoVisita, string $fechaInicio, string $fechaFin, int $tipoIngreso) {
            try {
                $query = "
                    SELECT 
                    v.id as id_visita, 
                    b.id as id_bitacora, 
                    i.id as id_instalacion, 
                    i.seccion, i.numero, 
                    v.nombre_visita, 
                    b.fecha_lectura 
                    FROM bitacora_visita b 
                    INNER JOIN visitas v 
                    ON b.id_visita = v.id 
                    INNER JOIN instalaciones i 
                    ON v.id_instalacion = i.id 
                    INNER JOIN info_caseta_vigilancia cv
                    ON b.id_caseta = cv.id
                    WHERE b.id_caseta = ".$casetaId;

                    $query = $tipoVisita != 0 ? $query . " AND " . "v.id_tipo_visita = ".$tipoVisita  : $query;
                    $query = $fechaInicio != "" ? $query . " AND " . "b.fecha_lectura >= '".$fechaInicio."'" : $query;
                    $query = $fechaFin != "" ? $query . " AND " . "b.fecha_lectura <= '".$fechaFin."'" : $query;
                    $query = $tipoIngreso != 0 ? $query . " AND " . "v.id_tipo_ingreso = ".$tipoIngreso : $query;
                    $query = $query . " AND cv.estatus_registro = 1";                     
  
                $resQuery = $this->execQuery($query);
                $logs = array();
                if($resQuery && $resQuery->num_rows > 0) {
                    while($row = $resQuery->fetch_array()) {
                        $log = new LogsGetAllResponse($row["id_visita"], $row["id_bitacora"], $row["id_instalacion"], $row["seccion"], $row["numero"], $row["nombre_visita"], $row["fecha_lectura"]);
                        array_push($logs, $log);
                    }
                }
                return $logs;
            } catch (\Throwable $th) {
                //throw $th;
                echo $th;
            }

        }

    }

?>