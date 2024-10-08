<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/model/BitacoraModel.php";

    Class BitacoraRepository extends Connection {
        private $table = "bitacora_visita";
        
        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        } 
        
        public function InsertInto(int $id_visita, int $id_caseta, $tipo) {
            try {
                $query = sprintf("INSERT INTO 
                    %s 
                    (`id_visita`, `id_caseta`, `fecha_lectura`, `tipo_registro`) 
                    VALUES (%d, %d, '%s', '%s')", 
                    $this->table, $id_visita, $id_caseta, date("Y-m-d H:i:s"), $tipo);
                    $queryRes = $this->execQuery($query);
                    if($queryRes) {
                      return $this->selectLastEntry();
                    }
                return null;
            } catch (\Throwable $th) {
                echo $th;
            }
        }

        public function selectFromWithId(int $id) {
            try {
                $query = sprintf("SELECT * FROM %s WHERE id = %d ORDER BY id DESC LIMIT 1", $this->table, $id);
                $resQuery = $this->execQuery($query);
                $bitacora = new Bitacora();
                if($resQuery && $resQuery->num_rows > 0) {
                    $row = $resQuery->fetch_array();
                    $bitacora->setBitacoraId($row["id"]);
                    $bitacora->setVisitaId($row["id_visita"]);
                    $bitacora->setCasetaId($row["id_caseta"]);
                    $bitacora->setFechaLectura($row["fecha_lectura"]);
                    $bitacora->setTipoRegistro($row["tipo_registro"]);
                }
                return $bitacora;
            } catch (\Throwable $th) {
                echo $th;
            }
        }

        public function selectFromWithVisitaId(int $idVisita){
            try {
                $query = sprintf("SELECT * FROM %s WHERE id_visita = %d ORDER BY id DESC LIMIT 1", $this->table, $idVisita);
                $resQuery = $this->execQuery($query);
                $bitacora = new Bitacora();
                if($resQuery && $resQuery->num_rows > 0) {
                    $row = $resQuery->fetch_array();
                    $bitacora->setBitacoraId($row["id"]);
                    $bitacora->setVisitaId($row["id_visita"]);
                    $bitacora->setCasetaId($row["id_caseta"]);
                    $bitacora->setFechaLectura($row["fecha_lectura"]);
                    $bitacora->setTipoRegistro($row["tipo_registro"]);
                }
                return $bitacora;
            } catch (\Throwable $th) {
                echo $th;
            }
        }

        public function getTotalEntriesWhereIdVisita(int $idVisita) {
            try {
                $query = sprintf("SELECT COUNT(*) FROM %s WHERE id_visita = %d", $this->table, $idVisita);
                $resQuery = $this->execQuery($query);
                if($resQuery && $resQuery->num_rows > 0) {
                    $row = $resQuery->fetch_array();
                    return $row[0];
                }
                return 0;
            } catch (\Throwable $th) {
                echo $th;
            }
        }

        public function selectLastEntry() {
            try {
                $query = sprintf("SELECT * FROM %s ORDER BY id DESC LIMIT 1", $this->table);
                $resQuery = $this->execQuery($query);
                $bitacora = new Bitacora();
                if($resQuery && $resQuery->num_rows > 0) {
                    $row = $resQuery->fetch_array();
                    $bitacora->setBitacoraId($row["id"]);
                    $bitacora->setVisitaId($row["id_visita"]);
                    $bitacora->setCasetaId($row["id_caseta"]);
                    $bitacora->setFechaLectura($row["fecha_lectura"]);
                    $bitacora->setTipoRegistro($row["tipo_registro"]);
                }
                return $bitacora;
            } catch (\Throwable $th) {
                echo $th;
            }
        }
    }
?>