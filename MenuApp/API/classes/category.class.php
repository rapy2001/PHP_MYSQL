<?php
    class category
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

        public function getCategories()
        {
            if($this->established)
            {
                $query = "SELECT * FROM categories";
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return -2;
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
        
        public function addCategory($category)
        {
            if($this->established)
            {
                $query = "INSERT INTO categories VALUES(0,'$category');";
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

        public function deleteCategory($categoryId)
        {
            if($this->established)
            {
                $query = "DELETE FROM categories WHERE category_id = $categoryId";
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

        public function __destruct()
        {
            $this->connection->close();
        }
    }

?>