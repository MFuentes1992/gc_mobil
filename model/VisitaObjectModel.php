<?php 
    Class VisitaObjectModel {
        private $id;
        private $idUsuario;
        private $idTipoVisita;
        private $idTipoIngreso;
        private $idInstalacion;
        private $fechaIngreso;
        private $fechaSalida;
        private $multipleEntrada;
        private $notificaciones;
        private $appGenerado;
        private $vigenciaQR;
        private $uniqueID;
        private $nombreVisita;
        private $fechaRegistro;
        private $fechaActualizacion;
        private $estatusRegistro;

        public function setId(int $id) {
            $this->id = $id;
        }

        public function getId() {
            return $this->id;
        }

        public function setIdUsuario(int $idUsuario) {
            $this->idUsuario = $idUsuario;
        }

        public function getIdUsuario() {
            return $this->idUsuario;
        }

        public function setIdTipoVisita(int $idTipoVisita) {
            $this->idTipoVisita = $idTipoVisita;
        }

        public function getIdTipoVisita() {
            return $this->idTipoVisita;
        }

        public function setIdTipoIngreso(int $idTipoIngreso) {
            $this->idTipoIngreso = $idTipoIngreso;
        }

        public function getIdTipoIngreso() {
            return $this->idTipoIngreso;
        }

        public function setIdInstalacion(int $idInstalacion) {
            $this->idInstalacion = $idInstalacion;
        }

        public function getIdInstalacion() {
            return $this->idInstalacion;
        }

        public function setFechaIngreso(string $fechaIngreso) {
            $this->fechaIngreso = $fechaIngreso;
        }

        public function getFechaIngreso() {
            return $this->fechaIngreso;
        }

        public function setFechaSalida(string $fechaSalida) {
            $this->fechaSalida = $fechaSalida;
        }
        
        public function getFechaSalida() {
            return $this->fechaSalida;
        }

        public function setMultipleEntrada(int $multipleEntrada) {
            $this->multipleEntrada = $multipleEntrada;
        }

        public function getMultipleEntrada() {
            return $this->multipleEntrada;
        }

        public function setNotificaciones(int $notificaciones) {
            $this->notificaciones = $notificaciones;
        }

        public function getNotificaciones() {
            return $this->notificaciones;
        }

        public function setAppGenerado(int $appGenerado) {
            $this->appGenerado = $appGenerado;
        }

        public function getAppGenerado() {
            return $this->appGenerado;
        }

        public function setVigenciaQR(string $vigenciaQR) {
            $this->vigenciaQR = $vigenciaQR;
        }

        public function getVigenciaQR() {
            return $this->vigenciaQR;
        }

        public function setUniqueID(string $uniqueID) {
            $this->uniqueID = $uniqueID;
        }

        public function getUniqueID() {
            return $this->uniqueID;
        }

        public function setNombreVisita(string $nombreVisita) {
            $this->nombreVisita = $nombreVisita;
        }

        public function getNombreVisita() {
            return $this->nombreVisita;
        }

        public function setFechaRegistro(string $fechaRegistro) {
            $this->fechaRegistro = $fechaRegistro;
        }

        public function getFechaRegistro() {
            return $this->fechaRegistro;
        }

        public function setFechaActualizacion(string $fechaActualizacion) {
            $this->fechaActualizacion = $fechaActualizacion;
        }

        public function getFechaActualizacion() {
            return $this->fechaActualizacion;
        }

        public function setEstatusRegistro(int $estatusRegistro) {
            $this->estatusRegistro = $estatusRegistro;
        }

        public function getEstatusRegistro() {
            return $this->estatusRegistro;
        }

        public function __construct() {
            $this->id = 0;
            $this->idUsuario = 0;
            $this->idTipoVisita = 0;
            $this->idTipoIngreso = 0;
            $this->idInstalacion = 0;
            $this->fechaIngreso = "";
            $this->fechaSalida = "";
            $this->multipleEntrada = 0;
            $this->notificaciones = 0;
            $this->appGenerado = 0;
            $this->vigenciaQR = "";
            $this->uniqueID = "";
            $this->nombreVisita = "";
            $this->fechaRegistro = "";
            $this->fechaActualizacion = "";
            $this->estatusRegistro = 0;
        }

        public function toString() {
            return sprintf("Visita: {id: %d, idUsuario: %d, idTipoVisita: %d, idTipoIngreso: %d, idInstalacion: %d, fechaIngreso: %s, fechaSalida: %s, multipleEntrada: %d, notificaciones: %d, appGenerado: %d, vigenciaQR: %s, uniqueID: %s, nombreVisita: %s, fechaRegistro: %s, fechaActualizacion: %s, estatusRegistro: %d}", $this->id, $this->idUsuario, $this->idTipoVisita, $this->idTipoIngreso, $this->idInstalacion, $this->fechaIngreso, $this->fechaSalida, $this->multipleEntrada, $this->notificaciones, $this->appGenerado, $this->vigenciaQR, $this->uniqueID, $this->nombreVisita, $this->fechaRegistro, $this->fechaActualizacion, $this->estatusRegistro);
        }
    }
?>