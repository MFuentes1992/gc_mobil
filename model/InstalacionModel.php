<?php 
    Class Instalacion {
        private $id;
        private $idRecinto;
        private $seccion;
        private $numero;
        private $referenciaConcepto;
        private $referenciaCentavos;
        private $referenciaBancaria;
        private $fechaRegistro;
        private $fechaActualizacion;
        private $estatusRegistro;

        public function __construct($id, $idRecinto, $seccion, $numero, $referenciaConcepto, $referenciaCentavos, $referenciaBancaria, $fechaRegistro, $fechaActualizacion, $estatusRegistro) {
            $this->id = $id;
            $this->idRecinto = $idRecinto;
            $this->seccion = $seccion;
            $this->numero = $numero;
            $this->referenciaConcepto = $referenciaConcepto;
            $this->referenciaCentavos = $referenciaCentavos;
            $this->referenciaBancaria = $referenciaBancaria;
            $this->fechaRegistro = $fechaRegistro;
            $this->fechaActualizacion = $fechaActualizacion;
            $this->estatusRegistro = $estatusRegistro;
        }

        public function getId() {
            return $this->id;
        }

        public function getIdRecinto() {
            return $this->idRecinto;
        }

        public function getSeccion() {
            return $this->seccion;
        }

        public function getNumero() {
            return $this->numero;
        }

        public function getReferenciaConcepto() {
            return $this->referenciaConcepto;
        }

        public function getReferenciaCentavos() {
            return $this->referenciaCentavos;
        }

        public function getReferenciaBancaria() {
            return $this->referenciaBancaria;
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

        public function setIdRecinto($idRecinto) {
            $this->idRecinto = $idRecinto;
        }

        public function setSeccion($seccion) {
            $this->seccion = $seccion;
        }

        public function setNumero($numero) {
            $this->numero = $numero;
        }

        public function setReferenciaConcepto($referenciaConcepto) {
            $this->referenciaConcepto = $referenciaConcepto;
        }

        public function setReferenciaCentavos($referenciaCentavos) {
            $this->referenciaCentavos = $referenciaCentavos;
        }

        public function setReferenciaBancaria($referenciaBancaria) {
            $this->referenciaBancaria = $referenciaBancaria;
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

        public function __toString()
        {
            return "Instalacion: [id: $this->id, idRecinto: $this->idRecinto, seccion: $this->seccion, numero: $this->numero, referenciaConcepto: $this->referenciaConcepto, referenciaCentavos: $this->referenciaCentavos, referenciaBancaria: $this->referenciaBancaria, fechaRegistro: $this->fechaRegistro, fechaActualizacion: $this->fechaActualizacion, estatusRegistro: $this->estatusRegistro]";
        }
    }

?>