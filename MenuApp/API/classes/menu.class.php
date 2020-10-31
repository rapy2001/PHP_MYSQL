<?php

    class menu
    {
        private $serverName = 'localhost';
        private $userName = 'root';
        private $password = '';
        private $dbName = 'small_projects';
        private $connection;
        private $established = false;

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

        public function insertItem($name,$price,$description,$imageUrl,$categoryId)
        {
            if($this->established)
            {
                $query = "INSERT INTO menu_items VALUES(0,'$name',$price,'$description','$imageUrl',$categoryId);";
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

        public function getItems($categoryId)
        {
            if($this->established)
            {
                $query  = '';
                if($categoryId == -1)
                {
                    $query = "SELECT * FROM menu_items";
                }
                else
                {
                    $query = "SELECT * FROM menu_items WHERE category_id = $categoryId";
                }
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return 0;
                }
                else
                {
                    $items = [];
                    while($row = $result->fetch_assoc())
                    {
                        $items[] = $row;
                    }
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
            $this->connection->close();
        }
    }
?>