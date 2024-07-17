<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
    class UserModel extends Connection {
        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        }
        public function getUserByEmail(string $email) {
            try {                
                $query = sprintf("SELECT u.id, u.name, u.id_profile, u.email, u.id_instalacion, u.password FROM users as u WHERE u.email = '%s' AND status = 1", $email);                
                return $this->execQuery($query);                   
            } catch (\Throwable $th) {
                echo $th;
            }            
        }

        public function getProfiles(string $email) {
            try {
                $query = sprintf("SELECT u.id_profile FROM users as u WHERE u.email = '%s' AND status = 1", $email);
                return $this->execQuery($query);
            } catch (\Throwable $th) {
                echo $th;
            }
        }
    }
?>