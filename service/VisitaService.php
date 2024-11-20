<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/model/BitacoraModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/model/VisitaObjectModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/repository/BitacoraRepository.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/repository/VisitaRepository.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/repository/VisitaPeatonRepository.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/repository/VehicleRepository.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/model/VehicleModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php";
    
    Class VisitaService {
        private $bitacoraRepository;
        private $visitaRepository;
        private $vehicleRepository;
        private $visitaPeatonRepository;

        function __construct() {
            $session = new SessionManager();
            $connValues = $session->getSession("userConn");
            $this->bitacoraRepository = new BitacoraRepository($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
            $this->visitaRepository = new VisitaRepository($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
            $this->vehicleRepository = new VehicleRepository($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
            $this->visitaPeatonRepository = new VisitaPeatonRepository($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
        }

        public function createVisita(int $idUsuario, int $idTipoVisita, int $idTipoIngreso, int $idInstalacion, string $fechaIngreso, 
        string $fechaSalida, int $multipleEntrada, int $notificaciones, int $appGenerado, int $vigenciaQR, string $nombreVisita, 
        int $estatusRegistro, string $vehicles, string $pedestrians) {
            $visitaObjectModel = new VisitaObjectModel();
            $vehicleArr = json_decode($vehicles, true);
            $pedestriansArr = json_decode($pedestrians, true);
            $vehicles = array();
            $pedestrians = array();
            foreach($vehicleArr as $vehicle) {
                $vehicleModel = new Vehicle(0, 0, $vehicle["conductor"], $vehicle["marca"], $vehicle["modelo"], $vehicle["anio"], $vehicle["placas"], $vehicle["color"],"", "", 1);
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
                $appGenerado,
                $vigenciaQR,
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
                $existingVehicle = $this->vehicleRepository->getVehicleById($vehicle["id"]);                
                $vehicleModel = new Vehicle($existingVehicle == null ? 0 : $existingVehicle->getId(), $idVisita, $vehicle["conductor"], $vehicle["marca"], $vehicle["modelo"], $vehicle["anio"], $vehicle["placas"], $vehicle["color"],"", "", $vehicle["estatusRegistro"]);
                array_push($vehicles, $vehicleModel);
            }
            foreach($pedestriansArr as $pedestrian) {
                $existingPedestrian = $this->visitaPeatonRepository->getVisitaPeatonById($pedestrian["id"]);                
                $pedestrianModel = new VisitasPeaton($existingPedestrian == null ? 0 : $pedestrian["id"], $idVisita, $pedestrian["nombre"], "", "", $pedestrian["estatusRegistro"]);
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

        public function saveVehicle($idVisita, $vehicle) {
            $currentVisita = $this->getVisitaInfoById($idVisita);
            $vehicleArr = json_decode($vehicle, true);
            $vehicles = array();
            foreach($vehicleArr as $vehicle) {
                $vehicleModel = new Vehicle(isset($vehicle["id"]) ? $vehicle["id"]: 0, $idVisita, $vehicle["conductor"], $vehicle["marca"], $vehicle["modelo"], $vehicle["anio"], $vehicle["placas"], $vehicle["color"],"", "", 1);
                array_push($vehicles, $vehicleModel);
            }
            $currentVisita->setVehicles($vehicles);
            $res = $this->visitaRepository->updateVisita($currentVisita);
            return $res;
        }

        public function savePedestrian($idVisita, $pedestrian) {
            $currentVisita = $this->getVisitaInfoById($idVisita);
            $pedestrianArr = json_decode($pedestrian, true);
            $pedestrians = array();
            foreach($pedestrianArr as $pedestrian) {
                $pedestrianModel = new VisitasPeaton(isset($pedestrian["id"]) ? $pedestrian["id"]: 0, $idVisita, $pedestrian["nombre"], "", "", 1);
                array_push($pedestrians, $pedestrianModel);
            }
            $currentVisita->setPedestrians($pedestrians);
            $res = $this->visitaRepository->updateVisita($currentVisita);
            return $res;
        }

        public function deleteVehicle(int $idVehicle) {
            $res = $this->vehicleRepository->deleteVehicle($idVehicle);
            return $res;
        }

        public function deletePedestrian(int $idPedestrian) {
            $res = $this->visitaPeatonRepository->deleteVisitaPeaton($idPedestrian);
            return $res;
        }

        public function getVisitaInfoById(int $idVisita) {
            $res = $this->visitaRepository->getVisitaById($idVisita);
            $resVehicles = $this->visitaRepository->getVehiclesByVisit($idVisita);
            $resPedestrians = $this->visitaRepository->getPedestriansByVisit($idVisita);
            $visita = new VisitaObjectModel();
            if($res && $res->num_rows > 0 ) {
                $rowVisita = $res->fetch_array();
                $resVehiclesArr = array();
                $resPedestriansArr = array();
                if($resVehicles) {
                    while($rowV = $resVehicles->fetch_array()) {
                        $vehicle = new Vehicle($rowV["id"], $rowV["id_visita"], $rowV["conductor"], $rowV["marca"], $rowV["modelo"], $rowV["anio"], $rowV["placas"], $rowV["color"], $rowV["fecha_registro"], $rowV["fecha_actualizacion"], $rowV["estatus_registro"]);
                        array_push($resVehiclesArr, $vehicle);
                    }
                }

                if($resPedestrians) {
                    while($rowP = $resPedestrians->fetch_array()) {
                        $pedestrian = new VisitasPeaton($rowP["id"], $rowP["id_visita"], $rowP["nombre"], $rowP["fecha_registro"], $rowP["fecha_actualizacion"], $rowP["estatus_registro"]);
                        array_push($resPedestriansArr, $pedestrian);
                    }
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
            $visitaResponse = $this->visitaRepository->getVisitaResidencialByQR($qr);            
            $bitacoraRes = $this->bitacoraRepository->selectFromWithVisitaId($visitaResponse->getVisitaId());
            if($bitacoraRes) {
                if(strcmp($bitacoraRes->getTipoRegistro(), "entrada") == 0 && $visitaResponse->getVigenciaQR() == 1) {
                    $visitaResponse->setEstatusVisita("Registrada");
                } else {
                    $visitaResponse->setEstatusVisita(
                        $visitaResponse->getEstatusVisita() == 1 && $visitaResponse->getVigenciaQR() == 1 
                        ? "Activa" : "Inactiva");
                }
            }

            $vehiclesArr = array();
            foreach($visitaResponse->getVehicles() as $vehicle) {
                $vehicleArr = array(
                    "id" => $vehicle->getId(),
                    "idVisita" => $vehicle->getIdVisita(),
                    "conductor" => $vehicle->getConductor(),
                    "marca" => $vehicle->getMarca(), 
                    "modelo" => $vehicle->getModelo(),
                    "anio" => $vehicle->getAnio(),
                    "placas" => $vehicle->getPlacas(),
                    "color" => $vehicle->getColor(),
                    "fechaRegistro" => $vehicle->getFechaRegistro(),
                    "fechaActualizacion" => $vehicle->getFechaActualizacion(),
                    "estatusRegistro" => $vehicle->getEstatusRegistro()
                );
                array_push($vehiclesArr, $vehicleArr);
            }
            $pedestriansArr = array();
            foreach($visitaResponse->getPedestrians() as $pedestrian) {
                $pedestrianArr = array(
                    "id" => $pedestrian->getId(),
                    "idVisita" => $pedestrian->getIdVisita(),
                    "nombre" => $pedestrian->getNombre(),
                    "fechaRegistro" => $pedestrian->getFechaRegistro(),
                    "fechaActualizacion" => $pedestrian->getFechaActualizacion(),
                    "estatusRegistro" => $pedestrian->getEstatusRegistro()
                );
                array_push($pedestriansArr, $pedestrianArr);
            }
            $resArr = array(
                "visitaId" => $visitaResponse->getVisitaId(),
                "idTipoVisita" => $visitaResponse->getIdTipoVisita(),
                "idTipoIngreso" => $visitaResponse->getIdTipoIngreso(),
                "idUsuario" => $visitaResponse->getIdUsuario(),
                "fechaIngreso" => $visitaResponse->getFechaIngreso(),
                "fechaSalida" => $visitaResponse->getFechaSalida(),
                "multiple" => $visitaResponse->getMultiple(),
                "notificaciones" => $visitaResponse->getNotificaciones(),
                "appGenerado" => $visitaResponse->getAppGenerado(),
                "vigenciaQR" => $visitaResponse->getVigenciaQR(),
                "uniqueId" => $visitaResponse->getUniqueId(),
                "autor" => $visitaResponse->getAutor(),
                "emailAutor" => $visitaResponse->getEmailAutor(),
                "residencialSeccion" => $visitaResponse->getResindecialSeccion(),
                "residencialNumInterior" => $visitaResponse->getResidencialNumInterior(),
                "residencialNumExterior" => $visitaResponse->getResidencialNumExterior(),
                "residencialCalle" => $visitaResponse->getResidencialCalle(),
                "residencialColonia" => $visitaResponse->getResidencialColonia(),
                "residencialCiudad" => $visitaResponse->getResidencialCiudad(),
                "residencialEstado" => $visitaResponse->getResidencialEstado(),
                "residencialCP" => $visitaResponse->getResidencialCP(),
                "residencialNombre" => $visitaResponse->getResidencialNombre(),
                "nombre" => $visitaResponse->getNombre(),
                "estatusVisita" => $visitaResponse->getEstatusVisita(),
                "vehicles" => $vehiclesArr,
                "pedestrians" => $pedestriansArr
            );
            return $resArr;
        }
    }
?>