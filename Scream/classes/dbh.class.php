<?php
    class dbh
    {
        private $server = 'localhost';
        private $user = 'root';
        private $pass = '';
        private $dbName = 'scream';

        protected function connection()
        {
            $dsn = 'mysql:host='.$this->server.';dbname='.$this->dbName;
            $connection = new PDO($dsn,$this->user,$this->pass);
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
            $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            return $connection;
        }
    }
?>