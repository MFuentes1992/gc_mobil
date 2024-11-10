<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/repository/InstalacionRepository.php";
    Class InstalacionesService {
        private $instalacionRepository;
        function __construct() {
            $session = new SessionManager();
            $connValues = $session->getSession("userConn");
            $this->instalacionRepository = new InstalacionRepository($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
        }

        public function getInstalacionesByRecinto(int $recintoId) {
            $instalaciones = $this->instalacionRepository->getInstalacionesByRecinto($recintoId);
            $response = array();
            if($instalaciones) {
                foreach($instalaciones as $instalacion) {
                    $instalacionResponse = array(
                        "idInstalacion" => $instalacion->getIdInstalacion(),
                        "seccion" => $instalacion->getSeccion(),
                        "numInt" => $instalacion->getNumInt(),
                        "idUsuario" => $instalacion->getIdUsuario(),
                        "owner" => $instalacion->getOwner()
                    );
                    array_push($response, $instalacionResponse);
                }
                return $response;
            } else {
                return null;
            }
        }

        public function getAllInstalaciones(string $instalaciones) {
            return $this->instalacionRepository->getAllInstalaciones($instalaciones);
        }
    }
?>