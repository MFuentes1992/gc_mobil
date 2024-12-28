<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/model/VigilantesModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/repository/VigilanteRepository.php";


    Class VigilanteService {
        private $model;
        private $vigilanteRepository;

        function __construct() {            
            $session = new SessionManager();
            $connValues = $session->getSession("userConn");
            $this->model = new Vigilante($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);        
            $this->vigilanteRepository = new VigilanteRepository($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
        }

        public function getInfoCaseta(string $activationCode) {
            $res = $this->model->getCasetaInformation($activationCode);
            return $res;
        }

        public function getLogsByVisitaId(string $visitaId) {
            $res = $this->vigilanteRepository->getLogsByVisitaId($visitaId);
            $arrayRes = array();
            foreach($res as $log) {
                array_push($arrayRes,array(
                    "tipo_registro" => $log["tipo_registro"],
                    "fecha_lectura" => $log["fecha_lectura"],
                ));
            }
            return $arrayRes;
        }

        public function getLogsByCasetaId(int $casetaId, int $tipoVisita, string $fechaInicio, string $fechaFin, int $tipoIngreso) {
            $res = null;
            if($tipoVisita == 0 && $fechaInicio == "" &&  $fechaFin == "" && $tipoIngreso == 0) {
                $res = $this->vigilanteRepository->getAllRegisteredLogsByCasetaId($casetaId); 
            } else {
                $res = $this->vigilanteRepository->getAllRegisteredLogsQueryBuilder($casetaId, $tipoVisita, $fechaInicio, $fechaFin, $tipoIngreso);
            }
            // $res = $this->vigilanteRepository->getAllRegisteredLogsByCasetaId($casetaId); 
            $arrayRes = array();
            foreach($res as $log) {
                $log->setFechaLectura(date("Y-m-d H:i:s", strtotime($log->getFechaLectura())));
                array_push($arrayRes,array(
                    "id_visita" => $log->getIdVisita(),
                    "id_bitacora" => $log->getIdBitacora(),
                    "id_instalacion" => $log->getIdInstalacion(),
                    "id_tipo_visita" => $log->getIdTipoVisita(),
                    "id_tipo_ingreso" => $log->getIdTipoIngreso(),
                    "tipo_visita" => $log->getTipoVisita(),
                    "tipo_ingreso" => $log->getTipoIngreso(),
                    "seccion" => $log->getSeccion(),
                    "numero" => $log->getNumero(),
                    "nombre_visita" => $log->getNombreVisita(),
                    "fecha_lectura" => $log->getFechaLectura()
                ));
            }
            return $arrayRes;
        }
    }
?>