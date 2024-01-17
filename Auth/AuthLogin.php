<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/sessionManager/SessionManager.php";
    class AuthLogin {
        protected $session = null;
        function  __construct() {
            $this->session = new SessionManager();
        }
        function login(string $email, string $password) {
            if($this->session->sessionExists("userConn")) {
                $connValues = $this->session->getSession("userConn");
                $conn = new UserService($connValues["dbUrl"], $connValues["user"], $connValues["password"], $connValues["dbName"]);
                $raw = $conn->getUserByEmail($email);                
                $user = $raw->fetch_array();
                if(password_verify($password, $user['password'])) {
                    return $user;
                } else {
                    return null;
                }
            }
        }
    }
?>