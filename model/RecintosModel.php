<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
    class Recintos extends Connection {
        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        }
        function getRecintos() {
            try {
                $query = "SELECT * FROM recintos";
                return $this->execQuery($query); 
            } catch (\Throwable $th) {
                echo $th;
            }
        }  
        function getRecintoById(int $recintoId) {
            try {
                $query = sprintf("SELECT * FROM recintos WHERE id = %d", $recintoId);
                return $this->execQuery($query); 
            } catch (\Throwable $th) {
                echo $th;
            }
        }  

        function getRecintoIdByInstalacion(int $instalacionId) {
            try {
                $query = sprintf("SELECT id_recinto FROM instalaciones WHERE id = %d", $instalacionId);
                return $this->execQuery($query); 
            } catch (\Throwable $th) {
                echo $th;
            }

        }

        function getRecintoByNombre(string $nombre) {
            try {
                $query = sprintf("SELECT * FROM recintos WHERE nombre = '%s'", $nombre);
                return $this->execQuery($query); 
            } catch (\Throwable $th) {
                echo $th;
            }
        }  
        function getRecintoByDireccion(string $direccion) {
            try {
                $query = sprintf("SELECT * FROM recintos WHERE direccion = '%s'", $direccion);
                return $this->execQuery($query); 
            } catch (\Throwable $th) {
                echo $th;
            }
        }  
        function getRecintoByTelefono(string $telefono) {
            try {
                $query = sprintf("SELECT * FROM recintos WHERE telefono = '%s'", $telefono);
                return $this->execQuery($query); 
            } catch (\Throwable $th) {
                echo $th;
            }
        }  
        function getRecintoByCorreo(string $correo) {
            try {
                $query = sprintf("SELECT * FROM recintos WHERE correo = '%s'", $correo);
                return $this->execQuery($query); 
            } catch (\Throwable $th) {
                echo $th;
            }
        }  
        function getRecintoByLatitud(string $latitud) {
            try {
                $query = sprintf("SELECT * FROM recintos WHERE latitud = '%s'", $latitud);
                return $this->execQuery($query); 
            } catch (\Throwable $th) {
                echo $th;
            }
        }
    }
?>