<?php 
    Class Vehicle {
        private $id;
        private $idVisita;
        private $conductor;
        private $marca;
        private $modelo;
        private $anio;
        private $placas;
        private $color;
        private $fechaRegistro;
        private $fechaActualizacion;
        private $estatusRegistro;

        public function __construct($id, $idVisita, $conductor, $marca, $modelo, $anio, $placas, $color, $fechaRegistro, $fechaActualizacion, $estatusRegistro) {
            $this->id = $id;
            $this->idVisita = $idVisita;
            $this->conductor = $conductor;
            $this->marca = $marca;
            $this->modelo = $modelo;
            $this->anio = $anio;
            $this->placas = $placas;
            $this->color = $color;
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

        public function getConductor() {
            return $this->conductor;
        }

        public function getMarca() {
            return $this->marca;
        }

        public function getModelo() {
            return $this->modelo;
        }

        public function getAnio() {
            return $this->anio;
        }

        public function getPlacas() {
            return $this->placas;
        }

        public function getColor() {
            return $this->color;
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

        public function setConductor($conductor) {
            $this->conductor = $conductor;
        }

        public function setMarca($marca) {
            $this->marca = $marca;
        }

        public function setModelo($modelo) {
            $this->modelo = $modelo;
        }

        public function setAnio($anio) {
            $this->anio = $anio;
        }

        public function setPlacas($placas) {
            $this->placas = $placas;
        }

        public function setColor($color) {
            $this->color = $color;
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
            return "id: ".$this->id.", idVisita: ".$this->idVisita.", conductor: ".$this->conductor.", marca: ".$this->marca.", modelo: ".$this->modelo.", anio: ".$this->anio.", placas: ".$this->placas.", color: ".$this->color.", fechaRegistro: ".$this->fechaRegistro.", fechaActualizacion: ".$this->fechaActualizacion.", estatusRegistro: ".$this->estatusRegistro;
        }
    }

?>