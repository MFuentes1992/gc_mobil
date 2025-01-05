<?php 
    Class Attachment {
        private $id;
        private $tipoEvidencia;
        private $idVehiculo;
        private $idPeaton;
        private $archivo;
        private $fechaRegistro;
        private $fechaActualizacion;
        private $estatusRegistro;

        public function __construct($id, $tipoEvidencia, $idVehiculo, $idPeaton, $archivo, $fechaRegistro, $fechaActualizacion, $estatusRegistro) {
            $this->id = $id;
            $this->tipoEvidencia = $tipoEvidencia;
            $this->idVehiculo = $idVehiculo;
            $this->idPeaton = $idPeaton;
            $this->archivo = $archivo;
            $this->fechaRegistro = $fechaRegistro;
            $this->fechaActualizacion = $fechaActualizacion;
            $this->estatusRegistro = $estatusRegistro;
        }

        public function getId() {
            return $this->id;
        }

        public function getTipoEvidencia() {
            return $this->tipoEvidencia;
        }

        public function getIdVehiculo() {
            return $this->idVehiculo;
        }

        public function getIdPeaton() {
            return $this->idPeaton;
        }

        public function getArchivo() {
            return $this->archivo;
        }

        public function getFechaRegistro() {
            return $this->fechaRegistro;
        }

        public function getFechaActualizacion() {
            return $this->fechaActualizacion;
        }

        public function getEstatusRegistro() {
            return $this->estatusRegistro;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setTipoEvidencia($tipoEvidencia) {
            $this->tipoEvidencia = $tipoEvidencia;
        }

        public function setIdVehiculo($idVehiculo) {
            $this->idVehiculo = $idVehiculo;
        }

        public function setIdPeaton($idPeaton) {
            $this->idPeaton = $idPeaton;
        }

        public function setArchivo($archivo) {
            $this->archivo = $archivo;
        }

        public function setFechaRegistro($fechaRegistro) {
            $this->fechaRegistro = $fechaRegistro;
        }

        public function setFechaActualizacion($fechaActualizacion) {
            $this->fechaActualizacion = $fechaActualizacion;
        }

        public function setEstatusRegistro($estatusRegistro) {
            $this->estatusRegistro = $estatusRegistro;
        }

        public function toString() {
            return "Attachment [id=" . $this->id . ", tipoEvidencia=" . $this->tipoEvidencia . ", idVehiculo=" . $this->idVehiculo . ", idPeaton=" . $this->idPeaton . ", archivo=" . $this->archivo . ", fechaRegistro=" . $this->fechaRegistro . ", fechaActualizacion=" . $this->fechaActualizacion . ", estatusRegistro=" . $this->estatusRegistro . "]";
        }
    }   
?>