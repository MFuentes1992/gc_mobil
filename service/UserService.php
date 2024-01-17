<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/model/UserModel.php";
    
    class UserService {
        protected $userModel = null;

        function __construct($dbUrl, $dbUser, $dbPass, $dbName) {
            $this->userModel = new UserModel($dbUrl, $dbUser, $dbPass, $dbName);
        }
        function getConnObject() {
            return $this->userModel;
        }
        function closeConnection() {
            $this->userModel->closeConnection();
        }
        function getUserByEmail(string $email) {
           return $this->userModel->getUserByEmail($email);
        }
    }
    

?>