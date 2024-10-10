<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/model/VigilantesModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/repository/VigilanteRepository.php";


    Class VigilanteService {
        private $model;
        private $vigilanteRepository;

        function __construct() {
            session_start();
            $session = new SessionManager();
            $connValues = $session->getSession("userConn");
            $this->model = new Vigilante($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);        
            $this->vigilanteRepository = new VigilanteRepository($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
        }

        public function getInfoCaseta(string $activationCode) {
            $res = $this->model->getCasetaInformation($activationCode);
            return $res;
        }

        public function getLogsByCasetaId(int $casetaId) {
            $res = $this->vigilanteRepository->getAllRegisteredLogsByCasetaId($casetaId);            
            $arrayRes = array();
            foreach($res as $log) {
                $log->setFechaLectura(date("Y-m-d H:i:s", strtotime($log->getFechaLectura())));
                array_push($arrayRes,array(
                    "id_visita" => $log->getIdVisita(),
                    "id_bitacora" => $log->getIdBitacora(),
                    "id_instalacion" => $log->getIdInstalacion(),
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