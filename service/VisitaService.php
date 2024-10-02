<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/model/BitacoraModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/repository/BitacoraRepository.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php";
    
    Class VisitaService {
        private $bitacoraRepository;
        private $visitaModel;
        function __construct() {
            $session = new SessionManager();
            $connValues = $session->getSession("userConn");
            $this->bitacoraRepository = new BitacoraRepository($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);        
            $this->visitaModel = new Visit($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
        }

        public function registerQREntry(int $visitaId, int $casetaId) {
            $existingEntry = $this->bitacoraRepository->selectFromWithVisitaId($visitaId);
            if(strcmp($existingEntry->getTipoRegistro(), "salida") == 0 || $existingEntry->getVisitaId() == 0) {
                $res = $this->bitacoraRepository->InsertInto($visitaId, $casetaId, "entrada");
                return $res;
            } else {
                return false;
            }
            return false;
        }

        public function registerQRExit(int $visitaId, int $casetaId) {
            $existingEntry = $this->bitacoraRepository->selectFromWithVisitaId($visitaId);
            if(strcmp($existingEntry->getTipoRegistro(), "entrada") == 0 || $existingEntry->getVisitaId() == 0) {
                $res = $this->bitacoraRepository->InsertInto($visitaId, $casetaId, "salida");
                return $res;
            } else {
                return false;
            }
        }

        public function getVisitByQR(string $qr) {
            $res = $this->visitaModel->readQR($qr);

            if($res && $res->num_rows > 0) {                
                $resArr = array();
                while($row = $res->fetch_array()) {
                    $rawVehicles = $this->visitaModel->getVehiclesByVisit($row["uniqueID"]);
                    $resVehicles = array();
                    while($rowV = $rawVehicles->fetch_array()) {
                        array_push($resVehicles, array(
                            "vehicle_id" => $rowV["vehicle_id"],
                            "marca" => $rowV["marca"],
                            "modelo" => $rowV["modelo"],
                            "anio" => $rowV["anio"],
                            "placas" => $rowV["placas"],
                            "color" => $rowV["color"]                                                      
                        ));
                    }
                    array_push($resArr, array(
                        "visita_id" => $row["visita_id"],
                        "nombre" => $row["nombre"],
                        "desde" => $row["desde"],
                        "hasta" => $row["hasta"],
                        "multiple_entrada" => $row["multiple_entrada"],
                        "notificaciones" => $row["notificaciones"],
                        "uniqueID" => $row["uniqueID"],
                        "estatus_registro" => $row["estatus_registro"],
                        "tipo_ingreso" => $row["tipo_ingreso"],
                        "id_tipo_ingreso" => $row["tipo_ingreso"],
                        "id_tipo_visita" => $row["tipo_visita"],
                        "nameAutor" => $row["nameAutor"],
                        "emailAutor" => $row["emailAutor"],
                        "seccion" => $row["seccion"],
                        "num_int" => $row["num_int"],
                        "residencial" => $row["residencial"],
                        "calle" => $row["calle"],
                        "colonia" => $row["colonia"],
                        "num_ext" => $row["num_ext"],
                        "ciudad" => $row["ciudad"],
                        "estado" => $row["estado"],
                        "cp" => $row["cp"],
                        "vehicles" => $resVehicles
                    ));
                }
                return $resArr;
            }
        }
    }
?>