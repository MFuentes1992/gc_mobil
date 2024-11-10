<?php 
    Class VisitaResponse {
        private $visitaId;
        private $idTipoVisita;
        private $idTipoIngreso;
        private $idUsuario;
        private $fechaIngreso;
        private $fechaSalida;
        private $multiple;
        private $notificaciones;
        private $appGenerado;
        private $vigenciaQR;
        private $uniqueId;
        private $autor;
        private $emailAutor;
        private $residencialSeccion;
        private $residencialNumInterior;
        private $residencialNumExterior;
        private $residencialCalle;
        private $residencialColonia;
        private $residencialCiudad;
        private $residencialEstado;
        private $residencialCP;
        private $residencialNombre;
        private $nombre;
        private $estatusVisita;
        private $vehicles;
        private $pedestrians;

        public function __construct($visitaId, $idTipoVisita, $idTipoIngreso, $idUsuario, $fechaIngreso, $fechaSalida, $multiple, $notificaciones, $appGenerado, $vigenciaQR, $uniqueId, $autor, $emailAutor, $residencialSeccion, $residencialNumInterior, $residencialNumExterior, $residencialCalle, $residencialColonia, $residencialCiudad, $residencialEstado, $residencialCP, $residencialNombre, $nombre, $vehicles, $pedestrians, $estatusVisita) {
            $this->visitaId = $visitaId;
            $this->idTipoVisita = $idTipoVisita;
            $this->idTipoIngreso = $idTipoIngreso;
            $this->idUsuario = $idUsuario;
            $this->fechaIngreso = $fechaIngreso;
            $this->fechaSalida = $fechaSalida;
            $this->multiple = $multiple;
            $this->notificaciones = $notificaciones;
            $this->appGenerado = $appGenerado;
            $this->vigenciaQR = $vigenciaQR;
            $this->uniqueId = $uniqueId;
            $this->autor = $autor;
            $this->emailAutor = $emailAutor;
            $this->residencialSeccion = $residencialSeccion;
            $this->residencialNumInterior = $residencialNumInterior;
            $this->residencialNumExterior = $residencialNumExterior;
            $this->residencialCalle = $residencialCalle;
            $this->residencialColonia = $residencialColonia;
            $this->$residencialCiudad   = $residencialCiudad ;
            $this->residencialEstado = $residencialEstado;
            $this->residencialCP = $residencialCP;
            $this->residencialNombre = $residencialNombre;
            $this->nombre = $nombre;
            $this->vehicles = $vehicles;
            $this->pedestrians = $pedestrians;
            $this->estatusVisita = $estatusVisita;
        }

        public function getVisitaId() {
            return $this->visitaId;
        }

        public function getIdTipoVisita() {
            return $this->idTipoVisita;
        }

        public function getIdTipoIngreso() {
            return $this->idTipoIngreso;
        }

        public function getIdUsuario() {
            return $this->idUsuario;
        }

        public function getFechaIngreso() {
            return $this->fechaIngreso;
        }

        public function getFechaSalida() {
            return $this->fechaSalida;
        }

        public function getMultiple() {
            return $this->multiple;
        }

        public function getNotificaciones() {
            return $this->notificaciones;
        }

        public function getAppGenerado() {
            return $this->appGenerado;
        }

        public function getVigenciaQR() {
            return $this->vigenciaQR;
        }

        public function getUniqueId() {
            return $this->uniqueId;
        }

        public function getAutor() {
            return $this->autor;
        }

        public function getEmailAutor() {
            return $this->emailAutor;
        }

        public function getResindecialSeccion() {
            return $this->residencialSeccion;
        }

        public function getResidencialNumInterior() {
            return $this->residencialNumInterior;
        }

        public function getResidencialNumExterior() {
            return $this->residencialNumExterior;
        }

        public function getResidencialCalle() {
            return $this->residencialCalle;
        }

        public function getResidencialColonia() {
            return $this->residencialColonia;
        }

        public function getResidencialCiudad() {
            return $this->residencialCiudad;
        }

        public function getResidencialEstado() {
            return $this->residencialEstado;
        }

        public function getResidencialCP() {
            return $this->residencialCP;
        }

        public function getResidencialNombre() {
            return $this->residencialNombre;
        }

        public function getNombre() {
            return $this->nombre;
        }

        public function getVehicles() {
            return $this->vehicles;
        }

        public function getPedestrians() {
            return $this->pedestrians;
        }

        public function getEstatusVisita() {
            return $this->estatusVisita;
        }

        public function setVisitaId($visitaId) {
            $this->visitaId = $visitaId;
        }

        public function setIdTipoVisita($idTipoVisita) {
            $this->idTipoVisita = $idTipoVisita;
        }

        public function setIdTipoIngreso($idTipoIngreso) {
            $this->idTipoIngreso = $idTipoIngreso;
        }

        public function setIdUsuario($idUsuario) {
            $this->idUsuario = $idUsuario;
        }

        public function setFechaIngreso($fechaIngreso) {
            $this->fechaIngreso = $fechaIngreso;
        }

        public function setFechaSalida($fechaSalida) {
            $this->fechaSalida = $fechaSalida;
        }

        public function setMultiple($multiple) {
            $this->multiple = $multiple;
        }

        public function setNotificaciones($notificaciones) {
            $this->notificaciones = $notificaciones;
        }

        public function setAppGenerado($appGenerado) {
            $this->appGenerado = $appGenerado;
        }

        public function setVigenciaQR($vigenciaQR) {
            $this->vigenciaQR = $vigenciaQR;
        }

        public function setUniqueId($uniqueId) {
            $this->uniqueId = $uniqueId;
        }

        public function setAutor($autor) {
            $this->autor = $autor;
        }

        public function setEmailAutor($emailAutor) {
            $this->emailAutor = $emailAutor;
        }

        public function setResindecialSeccion($resindecialSeccion) {
            $this->residencialSeccion = $resindecialSeccion;
        }

        public function setResidencialNumInterior($residencialNumInterior) {
            $this->residencialNumInterior = $residencialNumInterior;
        }

        public function setResidencialNumExterior($residencialNumExterior) {
            $this->residencialNumExterior = $residencialNumExterior;
        }

        public function setResidencialCalle($residencialCalle) {
            $this->residencialCalle = $residencialCalle;
        }

        public function setResidencialColonia($residencialColonia) {
            $this->residencialColonia = $residencialColonia;
        }

        public function setResidencialCiudad($residencialCiudad) {
            $this-$residencialCiudad   = $residencialCiudad ;
        }

        public function setResidencialEstado($residencialEstado) {
            $this->residencialEstado = $residencialEstado;
        }

        public function setResidencialCP($residencialCP) {
            $this->residencialCP = $residencialCP;
        }

        public function setResidencialNombre($residencialNombre) {
            $this->residencialNombre = $residencialNombre;
        }

        public function setNombre($nombre) {
            $this->nombre = $nombre;
        }

        public function setVehicles($vehicles) {
            $this->vehicles = $vehicles;
        }

        public function setPedestrians($pedestrians) {
            $this->pedestrians = $pedestrians;
        }

        public function setEstatusVisita($estatusVisita) {
            $this->estatusVisita = $estatusVisita;
        }

        public function toString() {
            return "VisitaResponse [visitaId=" . $this->visitaId . ", idTipoVisita=" . $this->idTipoVisita . ", idTipoIngreso=" . $this->idTipoIngreso . ", idUsuario=" . $this->idUsuario . ", fechaIngreso=" . $this->fechaIngreso . ", fechaSalida=" . $this->fechaSalida . ", multiple=" . $this->multiple . ", notificaciones=" . $this->notificaciones . ", appGenerado=" . $this->appGenerado . ", vigenciaQR=" . $this->vigenciaQR . ", uniqueId=" . $this->uniqueId . ", autor=" . $this->autor . ", emailAutor=" . $this->emailAutor . ", resindecialSeccion=" . $this->residencialSeccion . ", residencialNumInterior=" . $this->residencialNumInterior . ", residencialNumExterior=" . $this->residencialNumExterior . ", residencialCalle=" . $this->residencialCalle . ", residencialColonia=" . $this->residencialColonia . ",residencialCiudad=" . $this->residencialCiudad   . ", residencialEstado=" . $this->residencialEstado . ", residencialCP=" . $this->residencialCP . ", residencialNombre=" . $this->residencialNombre . ", nombre=" . $this->nombre . ", vehicles=" . $this->vehicles . ", pedestrians=" . $this->pedestrians . " , estatusVisita=" . $this->estatusVisita . "]";   
        }

    }

?>