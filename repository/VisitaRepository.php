<?php 
        require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
        require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaObjectModel.php";

        Class VisitaRepository extends Connection {
            private $table = "visitas";

            function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
                parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
            } 

            public function getVisitaByQr(string  $qr) {
                try {
                    $query = sprintf("SELECT * FROM %s WHERE uniqueID = '%s' AND estatus_registro = 1", $this->table, $qr);
                    $resQuery = $this->execQuery($query);
                    $visita = new VisitaObjectModel();
                    if($resQuery && $resQuery->num_rows > 0) {
                        $row = $resQuery->fetch_array();
                        $visita->setId($row["id"]);
                        $visita->setIdUsuario($row["id_usuario"]);
                        $visita->setIdTipoVisita($row["id_tipo_visita"]);
                        $visita->setIdTipoIngreso($row["id_tipo_ingreso"]);
                        $visita->setIdInstalacion($row["id_instalacion"]);
                        $visita->setFechaIngreso($row["fecha_ingreso"]);
                        $visita->setFechaSalida($row["fecha_salida"]);
                        $visita->setMultipleEntrada($row["multiple_entrada"]);
                        $visita->setNotificaciones($row["notificaciones"]);
                        $visita->setAppGenerado($row["app_generado"]);
                        $visita->setVigenciaQR($row["vigencia_qr"]);
                        $visita->setUniqueID($row["uniqueID"]);
                        $visita->setNombreVisita($row["nombre_visita"]);
                        $visita->setFechaRegistro($row["fecha_registro"]);
                        $visita->setFechaActualizacion($row["fecha_actualizacion"]);
                        $visita->setEstatusRegistro($row["estatus_registro"]);
                    }
                    return $visita;
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }

?>