<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/model/BitacoraModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaObjectModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/repository/BitacoraRepository.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/repository/VisitaRepository.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php";
    
    Class VisitaService {
        private $bitacoraRepository;
        private $visitaRepository;
        private $visitaModel;

        function __construct() {
            $session = new SessionManager();
            $connValues = $session->getSession("userConn");
            $this->bitacoraRepository = new BitacoraRepository($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
            $this->visitaRepository = new VisitaRepository($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);

            $this->visitaModel = new Visit($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
        }

        public function createVisita(int $idUsuario, int $idTipoVisita, int $idTipoIngreso, int $idInstalacion, string $fechaIngreso, 
        string $fechaSalida, int $multipleEntrada, int $notificaciones, string $nombreVisita, 
        int $estatusRegistro, string $vehicles, string $pedestrians) {
            $visitaObjectModel = new VisitaObjectModel();
            $vehicleArr = json_decode($vehicles, true);
            $pedestriansArr = json_decode($pedestrians, true);
            $vehicles = array();
            $pedestrians = array();
            foreach($vehicleArr as $vehicle) {
                $vehicleModel = new Vehicle(0, 0, $vehicle["driver"], $vehicle["brand"], $vehicle["model"], $vehicle["year"], $vehicle["plates"], $vehicle["color"],"", "", 1);
                array_push($vehicles, $vehicleModel);
            }
            foreach($pedestriansArr as $pedestrian) {
                $pedestrianModel = new VisitasPeaton(0, 0, $pedestrian["nombre"], "", "", 1);
                array_push($pedestrians, $pedestrianModel);
            }
            $visitaObjectModel->init(
                0,
                $idUsuario,
                $idTipoVisita,
                $idTipoIngreso,
                $idInstalacion,
                $fechaIngreso,
                $fechaSalida,
                $multipleEntrada,
                $notificaciones,
                1,
                1,
                uniqid('', true),
                $nombreVisita,
                "",
                "",
                $estatusRegistro,
                $vehicles,
                $pedestrians
            );
            $res = $this->visitaRepository->createVisita($visitaObjectModel);
            return $res;

        }

        public function updateVisita(int $idVisita, int $idTipoVisita, int $idTipoIngreso, string $fechaIngreso, 
        string $fechaSalida, int $multipleEntrada, int $notificaciones, string $nombreVisita, 
        int $estatusRegistro, string $vehicles, string $pedestrians) {
            $currentVisita = $this->getVisitaInfoById($idVisita);
            $vehicleArr = json_decode($vehicles, true);
            $pedestriansArr = json_decode($pedestrians, true);
            $vehicles = array();
            $pedestrians = array();
            foreach($vehicleArr as $vehicle) {
                $vehicleModel = new Vehicle($vehicle["id"], $idVisita, $vehicle["driver"], $vehicle["brand"], $vehicle["model"], $vehicle["year"], $vehicle["plates"], $vehicle["color"],"", "", 1);
                array_push($vehicles, $vehicleModel);
            }
            foreach($pedestriansArr as $pedestrian) {
                $pedestrianModel = new VisitasPeaton($pedestrian["id"], $idVisita, $pedestrian["nombre"], "", "", 1);
                array_push($pedestrians, $pedestrianModel);
            }
            $currentVisita->setVehicles($vehicles);
            $currentVisita->setPedestrians($pedestrians);
            $currentVisita->setNombreVisita($nombreVisita);
            $currentVisita->setIdTipoIngreso($idTipoIngreso);
            $currentVisita->setIdTipoVisita($idTipoVisita);
            $currentVisita->setFechaIngreso($fechaIngreso);
            $currentVisita->setFechaSalida($fechaSalida);
            $currentVisita->setMultipleEntrada($multipleEntrada);
            $currentVisita->setNotificaciones($notificaciones);
            $currentVisita->setEstatusRegistro($estatusRegistro);

            $res = $this->visitaRepository->updateVisita($currentVisita);
            return $res;
        }

        public function registerQREntry(string $qr, int $casetaId) {
            $visitaObjectModel = $this->visitaRepository->getVisitaByQr($qr);
            $existingEntry = $this->bitacoraRepository->selectFromWithVisitaId($visitaObjectModel->getId());
            $totalBitacoraEntries = $this->bitacoraRepository->getTotalEntriesWhereIdVisita($visitaObjectModel->getId());

            if(strcmp($existingEntry->getTipoRegistro(), "salida") == 0 && $totalBitacoraEntries >= 2 && $visitaObjectModel->getMultipleEntrada() == 0) {
                return -1;
            }


            if((strcmp($existingEntry->getTipoRegistro(), "salida") == 0 || $existingEntry->getVisitaId() == 0)) {
                $res = $this->bitacoraRepository->InsertInto($visitaObjectModel->getId(), $casetaId, "entrada");
                return $res ? 1 : 0;
            } else {
                return 0;
            }
            return 0;
        }

        public function getVisitaInfoById(int $idVisita) {
            $res = $this->visitaRepository->getVisitaById($idVisita);
            $resVehicles = $this->visitaRepository->getVehiclesByVisit($idVisita);
            $resPedestrians = $this->visitaRepository->getPedestriansByVisit($idVisita);
            $visita = new VisitaObjectModel();
            if($res && $res->num_rows > 0 
            && $resVehicles && $resVehicles->num_rows > 0
            && $resPedestrians && $resPedestrians->num_rows > 0) {
                $rowVisita = $res->fetch_array();
                $resVehiclesArr = array();
                $resPedestriansArr = array();
                while($rowV = $resVehicles->fetch_array()) {
                    array_push($resVehiclesArr, array(
                        "vehicle_id" => $rowV["id"],
                        "marca" => $rowV["marca"],
                        "modelo" => $rowV["modelo"],
                        "anio" => $rowV["anio"],
                        "placas" => $rowV["placas"],
                        "color" => $rowV["color"]                                                      
                    ));
                }

                while($rowP = $resPedestrians->fetch_array()) {
                    array_push($resPedestriansArr, array(
                        "pedestrian_id" => $rowP["id"],
                        "nombre" => $rowP["nombre"]
                    ));
                }

                $visita->init(
                    $rowVisita["id"],
                    $rowVisita["id_usuario"],
                    $rowVisita["id_tipo_visita"],
                    $rowVisita["id_tipo_ingreso"],
                    $rowVisita["id_instalacion"],
                    $rowVisita["fecha_ingreso"],
                    $rowVisita["fecha_salida"],
                    $rowVisita["multiple_entrada"],
                    $rowVisita["notificaciones"],
                    $rowVisita["app_generado"],
                    $rowVisita["vigencia_qr"],
                    $rowVisita["uniqueID"],
                    $rowVisita["nombre_visita"],
                    $rowVisita["fecha_registro"],
                    $rowVisita["fecha_actualizacion"],
                    $rowVisita["estatus_registro"],
                    $resVehiclesArr,
                    $resPedestriansArr
                );
                return $visita;
            }
                
        }

        public function registerQRExit(string $qr, int $casetaId) {
            $visitaObjectModel = $this->visitaRepository->getVisitaByQr($qr);
            $existingEntry = $this->bitacoraRepository->selectFromWithVisitaId($visitaObjectModel->getId());
            $totalBitacoraEntries = $this->bitacoraRepository->getTotalEntriesWhereIdVisita($visitaObjectModel->getId());

            if(strcmp($existingEntry->getTipoRegistro(), "entrada") == 0 && $totalBitacoraEntries >= 2 && $visitaObjectModel->getMultipleEntrada() == 0) {
                return -1;
            }

            if(strcmp($existingEntry->getTipoRegistro(), "entrada") == 0 || $existingEntry->getVisitaId() == 0) {
                $res = $this->bitacoraRepository->InsertInto($visitaObjectModel->getId(), $casetaId, "salida");
                return $res ? 1 : 0;
            } else {
                return 0;
            }
            return 0;
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