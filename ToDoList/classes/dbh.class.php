<?php
    class dbh
    {
        private $server = "localhost";
        private $user = "root";
        private $password = "";
        private $dbName = "ToDoList";

        protected function connection()
        {
            $dsn = "mysql:host=" .$this->server.";dbname=".$this->dbName;
            $connection = new PDO($dsn,$this->user,$this->password);
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
            return $connection;
        }
    }
    