<?php 
    Class Bitacora {
        private $id;
        private $visitaId;
        private $casetaId;
        private $fechaLectura;
        private $tipoRegistro;

        public function setBitacoraId(int $id) {
            $this->id = $id;
        }

        public function getBitacoraId() {
            return $this->id;
        }

        public function setVisitaId(int $visitaId) {
            $this->visitaId = $visitaId;
        }

        public function getVisitaId() {
            return $this->visitaId;
        }

        public function setCasetaId(int $casetaId) {
            $this->casetaId = $casetaId;
        }

        public function getCasetaId() {
            return $this->casetaId;
        }

        public function setFechaLectura(string $fechaLectura) {
            $this->fechaLectura = $fechaLectura;
        }

        public function getFechaLectura() {
            return $this->fechaLectura;
        }

        public function setTipoRegistro(string $tipoRegistro) {
            $this->tipoRegistro = $tipoRegistro;
        }

        public function getTipoRegistro() {
            return $this->tipoRegistro;
        }

        public function __construct() {
            $this->id = 0;
            $this->visitaId = 0;
            $this->casetaId = 0;
            $this->fechaLectura = "";
            $this->tipoRegistro = "";
        }

        public function toString() {
            return sprintf("Bitacora: {id: %d, visitaId: %d, casetaId: %d, fechaLectura: %s, tipoRegistro: %s}", $this->id, $this->visitaId, $this->casetaId, $this->fechaLectura, $this->tipoRegistro);
        }
    }
?>