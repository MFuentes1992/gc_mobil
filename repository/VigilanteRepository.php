<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/model/response/LogsGetAllResponse.php";

    Class VigilanteRepository extends Connection {

        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        }

        public function getLogsByVisitaId(int $visitaId) {
            try {
                $query = sprintf("SELECT bv.tipo_registro, bv.fecha_lectura FROM bitacora_visita bv WHERE bv.id_visita = %d", $visitaId);
                $resQuery = $this->execQuery($query);
                $logs = array();
                if($resQuery && $resQuery->num_rows > 0) {
                    while($row = $resQuery->fetch_array()) {
                        
                        array_push($logs, array(
                            "tipo_registro" => $row["tipo_registro"],
                            "fecha_lectura" => $row["fecha_lectura"]
                        ));
                    }
                }
                return $logs;
            } catch (\Throwable $th) {            
                echo $th;
            }
        }

        public function getAllRegisteredLogsByCasetaId(int $casetaId) {
            try {
                $query = sprintf("SELECT DISTINCT
                    v.id as id_visita,
                    b.id as id_bitacora,
                    i.id as id_instalacion,
                    v.id_tipo_visita,
                    v.id_tipo_ingreso,
                    lst_v.tipo_visita,
                    lst_i.tipo_ingreso,
                    i.seccion, i.numero,
                    v.nombre_visita,
                    b.fecha_lectura,
                    b.tipo_registro
                    FROM bitacora_visita b
                    INNER JOIN visitas v
                    ON b.id_visita = v.id
                    INNER JOIN instalaciones i
                    ON v.id_instalacion = i.id
                    INNER JOIN lst_tipo_visita lst_v
                    ON v.id_tipo_visita = lst_v.id
                    INNER JOIN lst_tipo_ingreso_visita lst_i
                    ON v.id_tipo_ingreso = lst_i.id
                    INNER JOIN info_caseta_vigilancia cv
                    ON b.id_caseta = cv.id
                    WHERE b.id_caseta = %d AND cv.estatus_registro = 1 AND b.tipo_registro = 'entrada' GROUP BY (v.id)", $casetaId);
                $resQuery = $this->execQuery($query);
                $logs = array();
                if($resQuery && $resQuery->num_rows > 0) {
                    while($row = $resQuery->fetch_array()) {
                        $log = new LogsGetAllResponse($row["id_visita"], $row["id_bitacora"], $row["id_instalacion"], $row["seccion"], $row["numero"], $row["nombre_visita"], $row["fecha_lectura"], $row["id_tipo_visita"], $row["id_tipo_ingreso"], $row["tipo_visita"], $row["tipo_ingreso"]);
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
                    v.id_tipo_visita,
                    v.id_tipo_ingreso,
                    lst_v.tipo_visita,
                    lst_i.tipo_ingreso,
                    i.seccion, i.numero, 
                    v.nombre_visita, 
                    b.fecha_lectura 
                    FROM bitacora_visita b 
                    INNER JOIN visitas v 
                    ON b.id_visita = v.id 
                    INNER JOIN instalaciones i 
                    ON v.id_instalacion = i.id 
                    INNER JOIN lst_tipo_visita lst_v
                    ON v.id_tipo_visita = lst_v.id
                    INNER JOIN lst_tipo_ingreso_visita lst_i
                    ON v.id_tipo_ingreso = lst_i.id
                    INNER JOIN info_caseta_vigilancia cv
                    ON b.id_caseta = cv.id
                    WHERE b.id_caseta = ".$casetaId;

                    $query = $tipoVisita != 0 ? $query . " AND " . "v.id_tipo_visita = ".$tipoVisita  : $query;
                    $query = $fechaInicio != "" ? $query . " AND " . "b.fecha_lectura >= '".$fechaInicio."'" : $query;
                    $query = $fechaFin != "" ? $query . " AND " . "b.fecha_lectura <= '".$fechaFin."'" : $query;
                    $query = $tipoIngreso != 0 ? $query . " AND " . "v.id_tipo_ingreso = ".$tipoIngreso : $query;
                    $query = $query . " AND cv.estatus_registro = 1 AND b.tipo_registro = 'entrada' GROUP BY (v.id)";                     
  
                $resQuery = $this->execQuery($query);
                $logs = array();
                if($resQuery && $resQuery->num_rows > 0) {
                    while($row = $resQuery->fetch_array()) {
                        $log = new LogsGetAllResponse($row["id_visita"], $row["id_bitacora"], $row["id_instalacion"], $row["seccion"], $row["numero"], $row["nombre_visita"], $row["fecha_lectura"], $row["id_tipo_visita"], $row["id_tipo_ingreso"], $row["tipo_visita"], $row["tipo_ingreso"]);
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