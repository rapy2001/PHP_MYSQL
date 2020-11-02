<?php
    class Item
    {
        private $serverName = 'localhost';
        private $userName = 'root';
        private $password = '';
        private $dbName = 'small_projects';
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

        
        public function insert($text)
        {
            if($this->established)
            {
                $query = "INSERT INTO list_items VALUES(0,'$text',0);";
                if($this->connection->query($query))
                {
                    return 1;
                }
                else
                {
                    return 0;
                }
            }
            else
            {
                return -1;
            }
            
        }

        public function getAllItems()
        {
            if($this->established)
            {
                $query = "SELECT * FROM list_items";
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return 0;
                }
                else
                {
                    $items = [];
                    while($row = $result->fetch_assoc())
                        $items[] = $row;
                    return $items;
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