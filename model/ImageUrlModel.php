<?php 
    class ImageUrlModel {
        private $tipoEvidencia;
        private $idVehiculoPedestrian;
        private $url;

        public function __construct($tipoEvidencia, $idVehiculoPedestrian, $url){
            $this->tipoEvidencia = $tipoEvidencia;
            $this->idVehiculoPedestrian = $idVehiculoPedestrian;
            $this->url = $url;
        }

        public function getTipoEvidencia(){
            return $this->tipoEvidencia;
        }

        public function getIdVehiculoPedestrian(){
            return $this->idVehiculoPedestrian;
        }

        public function getUrl(){
            return $this->url;
        }

        public function setTipoEvidencia($tipoEvidencia){
            $this->tipoEvidencia = $tipoEvidencia;
        }

        public function setIdVehiculoPedestrian($idVehiculoPedestrian){
            $this->idVehiculoPedestrian = $idVehiculoPedestrian;
        }

        public function setUrl($url){
            $this->url = $url;
        }

        public function toString(){
            return "Tipo de evidencia: " . $this->tipoEvidencia . " Id del vehiculo o peaton: " . $this->idVehiculoPedestrian . " URL: " . $this->url;
        }

    }
    

?>