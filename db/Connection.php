<?php
    class Connection {
        protected $sqlConn = null;
        protected $server = "";
        protected $user = "";
        protected $password = "";
        protected $db = "";
        
        function __construct($server, $user, $password, $db) {
            $this->server = $server;
            $this->user = $user;
            $this->password = $password;
            $this->db = $db;
            // -- Initialize connection.
            $this->connect();
        }
        function connect() {
            try {
            $this->sqlConn = new mysqli($this->server, $this->user, $this->password, $this->db);
            if($this->sqlConn->connect_errno) {
                printf("Falló la conexión: %s\n", $this->sqlConn->connect_error);
                exit();
            }
            } catch (\Throwable $th) {
                echo $th;
                $this->sqlConn = null;
            }
        } 

        function getConnection() {
            return $this->sqlConn;
        }
        
        function closeConnection(){
            $this->sqlConn->close();
        }

        function execQuery(string $queryStr) {
            try {
                return $this->sqlConn->query($queryStr); 
            } catch (\Throwable $th) {
                echo $th;
            }
        }
    }
?>
