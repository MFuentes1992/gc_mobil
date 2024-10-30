<?php 
    Class VisitasPeaton {
        private $id;
        private $idVisita;
        private $nombre;
        private $fechaRegistro;
        private $fechaActualizacion;
        private $estatusRegistro;

        public function __construct($id, $idVisita, $nombre, $fechaRegistro, $fechaActualizacion, $estatusRegistro) {
            $this->id = $id;
            $this->idVisita = $idVisita;
            $this->nombre = $nombre;
            $this->fechaRegistro = $fechaRegistro;
            $this->fechaActualizacion = $fechaActualizacion;
            $this->estatusRegistro = $estatusRegistro;
        }

        public function getId() {
            return $this->id;
        }

        public function getIdVisita() {
            return $this->idVisita;
        }

        public function getNombre() {
            return $this->nombre;
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

        public function setIdVisita($idVisita) {
            $this->idVisita = $idVisita;
        }

        public function setNombre($nombre) {
            $this->nombre = $nombre;
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
            return "id: ".$this->id.", idVisita: ".$this->idVisita.", nombre: ".$this->nombre.", fechaRegistro: ".$this->fechaRegistro.", fechaActualizacion: ".$this->fechaActualizacion.", estatusRegistro: ".$this->estatusRegistro;
        }
    }
?>