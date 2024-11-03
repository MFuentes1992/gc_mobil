<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
    Class VehicleRepository extends Connection {
        private $table = "visitas_vehiculos";
        
        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        } 

        public function getVehicleById($id) {
            $query = "SELECT * FROM $this->table WHERE id = $id";
            $result = $this->execQuery($query);             
            $vehicleRow = $result->fetch_assoc();
            if($vehicleRow == null) {
                return null;
            }
            $vehicle = new Vehicle($vehicleRow['id'], $vehicleRow['id_visita'], $vehicleRow['conductor'], $vehicleRow['marca'], $vehicleRow['modelo'], $vehicleRow['anio'], $vehicleRow['placas'], $vehicleRow['color'], $vehicleRow['fecha_registro'], $vehicleRow['fecha_actualizacion'],$vehicleRow['estatus_registro']);            
            return $vehicle;
        }
    }
?>