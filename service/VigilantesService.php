<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/model/VigilantesModel.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/constants/constants.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php"; 

    Class VigilanteService {
        private $model;
        function __construct() {
            session_start();
            $session = new SessionManager();
            $connValues = $session->getSession("userConn");
            $this->model = new Vigilante($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);        
        }

        public function getInfoCaseta(string $activationCode) {
            $res = $this->model->getCasetaInformation($activationCode);
            return $res;
        }
    }
?>