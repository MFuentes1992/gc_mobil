<?php 
    Class LogsGetAllResponse {
        private $idVisita;
        private $idBitacora;
        private $idInstalacion;
        private $seccion;
        private $numero;
        private $nombreVisita;
        private $fechaLectura;

        public function __construct($idVisita, $idBitacora, $idInstalacion, $seccion, $numero, $nombreVisita, $fechaLectura) {
            $this->idVisita = $idVisita;
            $this->idBitacora = $idBitacora;
            $this->idInstalacion = $idInstalacion;
            $this->seccion = $seccion;
            $this->numero = $numero;
            $this->nombreVisita = $nombreVisita;
            $this->fechaLectura = $fechaLectura;
        }

        public function getIdVisita() {
            return $this->idVisita;
        }

        public function setIdVisita($idVisita) {
            $this->idVisita = $idVisita;
        }

        public function getIdBitacora() {
            return $this->idBitacora;
        }

        public function setIdBitacora($idBitacora) {
            $this->idBitacora = $idBitacora;
        }

        public function getIdInstalacion() {
            return $this->idInstalacion;
        }

        public function setIdInstalacion($idInstalacion) {
            $this->idInstalacion = $idInstalacion;
        }

        public function getSeccion() {
            return $this->seccion;
        }

        public function setSeccion($seccion) {
            $this->seccion = $seccion;
        }

        public function getNumero() {
            return $this->numero;
        }

        public function setNumero($numero) {
            $this->numero = $numero;
        }

        public function getNombreVisita() {
            return $this->nombreVisita;
        }

        public function setNombreVisita($nombreVisita) {
            $this->nombreVisita = $nombreVisita;
        }

        public function getFechaLectura() {
            return $this->fechaLectura;
        }

        public function setFechaLectura($fechaLectura) {
            $this->fechaLectura = $fechaLectura;
        }

        public function __toString() {
            return "LogsGetAll [idVisita=" . $this->idVisita . ", idBitacora=" . $this->idBitacora . ", idInstalacion=" . $this->idInstalacion . ", seccion=" . $this->seccion . ", numero=" . $this->numero . ", nombreVisita=" . $this->nombreVisita . ", fechaLectura=" . $this->fechaLectura . "]";
        }
    }

?>