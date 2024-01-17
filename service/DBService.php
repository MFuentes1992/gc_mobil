<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/model/DBModel.php";
    
    class DBService {
        protected $dbModel = null;
        protected $clientCode = "";

        function __construct($dbUrl, $dbUser, $dbPass, $dbName, $clientCode = '') {
            $this->dbModel = new DBModel($dbUrl, $dbUser, $dbPass, $dbName);
            $this->clientCode = $clientCode;
        }
        function connectToAdmin() {            
            return $this->dbModel->getClientDB($this->clientCode);
        }
        function getDBObject() {
            return $this->dbModel;
        }
        function closeConnection() {
            $this->dbModel->closeConnection();
        }
    }
    

?>