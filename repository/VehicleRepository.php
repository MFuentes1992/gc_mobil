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
            if(!$result) {
                return null;
            }           
            $vehicleRow = $result->fetch_assoc();
            $vehicle = new Vehicle($vehicleRow['id'], $vehicleRow['id_visita'], $vehicleRow['conductor'], $vehicleRow['marca'], $vehicleRow['modelo'], $vehicleRow['anio'], $vehicleRow['placas'], $vehicleRow['color'], $vehicleRow['fecha_registro'], $vehicleRow['fecha_actualizacion'],$vehicleRow['estatus_registro']);            
            return $vehicle;
        }

        public function deleteVehicle($id) {
            $query = "UPDATE $this->table SET `estatus_registro` = 0 WHERE id = $id";
            $result = $this->execQuery($query);
            return $result;
        }
    }
?>