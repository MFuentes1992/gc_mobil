<?php 

    Class InstalacionesUserResponse {
        private $idInstalacion;
        private $seccion;
        private $numInt;
        private $idUsuario;
        private $owner;

        public function __construct($idInstalacion, $seccion, $numInt, $idUsuario, $owner) {
            $this->idInstalacion = $idInstalacion;
            $this->seccion = $seccion;
            $this->numInt = $numInt;
            $this->idUsuario = $idUsuario;
            $this->owner = $owner;
        }

        public function getIdInstalacion() {
            return $this->idInstalacion;
        }

        public function getSeccion() {
            return $this->seccion;
        }

        public function getNumInt() {
            return $this->numInt;
        }

        public function getIdUsuario() {
            return $this->idUsuario;
        }

        public function getOwner() {
            return $this->owner;
        }

        public function setIdInstalacion($idInstalacion) {
            $this->idInstalacion = $idInstalacion;
        }

        public function setSeccion($seccion) {
            $this->seccion = $seccion;
        }

        public function setNumInt($numInt) {
            $this->numInt = $numInt;
        }

        public function setIdUsuario($idUsuario) {
            $this->idUsuario = $idUsuario;
        }

        public function setOwner($owner) {
            $this->owner = $owner;
        }

        public function toString() {
            return "idInstalacion: ".$this->idInstalacion." seccion: ".$this->seccion." numInt: ".$this->numInt." idUsuario: ".$this->idUsuario . " owner: ".$this->owner;
        }

    }
?>