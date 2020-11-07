<?php

    class Platform
    {
        private $serverName = 'localhost';
        private $userName = 'root';
        private $password = '';
        private $dbName = 'game_on';
        private $established = false;
        private $connection;

        public function __construct()
        {
            $this->connection = new mysqli($this->serverName,$this->userName,$this->password,$this->dbName);
            if($this->connection->connect_error)
            {
                $this->established = false;
            }
            else
            {
                $this->established = true;
            }
        }

        public function getPlatforms()
        {
            if($this->established)
            {
                $query = "SELECT * FROM platforms";
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return 0;
                }
                else
                {
                    $categories = [];
                    while($row = $result->fetch_assoc())
                    {
                        $categories[] = $row;
                    }
                    return $categories;
                }
            }
            else
            {
                return -1;
            }
        }
        
        public function __destruct()
        {
            if($this->established)
            {
                $this->connection->close();
            }
        }
    }
?>