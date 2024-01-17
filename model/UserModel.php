<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/db/Connection.php";
    class UserModel extends Connection {
        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            parent::__construct($dbUrl, $dbUser, $dbPass, $dbName);
        }
        public function getUserByEmail(string $email) {
            try {                
                $query = sprintf("SELECT * FROM users WHERE email = '%s' AND status = 1", $email);
                return $this->execQuery($query);                   
            } catch (\Throwable $th) {
                echo $th;
            }            
        }
    }
?>