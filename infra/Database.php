<?php
    class Database{
        private $server; 
        private $user;
        private $password;
        private $port;
        private $dbName; 
        private $dbType;
        private $connection;

        function __construct(){
            $this->loadConfig();
        }

        private function loadConfig(){
            include_once "config.ini.php";
            $this->server = $config["server"];
            $this->dbName = $config["dbname"];
            $this->user = $config["user"];
            $this->password = $config["password"];
            $this->dbType = $config["dbtype"];
            $this->port = $config["port"];  

        }

        public function connect(){
            $options = [
                PDO::ATTR_EMULATE_PREPARES   => false, 
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
            ];
             
            if(empty($this->port)){
                $this->connection = new PDO($this->dbType.":host=".$this->server.";dbname=".$this->dbName, $this->user, $this->password, $options);
            }
            else{
                $this->connection = new PDO($this->dbType.":host=".$this->server.";dbname=".$this->dbName.";port=".$this->port, $this->user, $this->password, $options);
            }
            return $this->connection;
        }

        public function close(){
            $this->connection = null;
        }
    }