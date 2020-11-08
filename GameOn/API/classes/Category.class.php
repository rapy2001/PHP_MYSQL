<?php
    class Category
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

        public function getCategories()
        {
            if($this->established)
            {
                $query = 'SELECT * FROM categories';
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return 0;
                }
                else
                {
                    $categories = [];
                    while($row = $result->fetch_assoc())
                        $categories[] = $row;
                    return $categories;
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
        
        public function checkCategoryStatus($categoryName)
        {
            if($this->established)
            {
                $query = "SELECT category_name FROM categories WHERE category_name LIKE '$categoryName';";
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return 0;
                } 
                else
                {
                    if($result->num_rows > 0)
                    {
                        return 2;
                    }
                    else
                    {
                        return 1;
                    }
                }
            }
            else
            {
                return -1;
            }
        }

        public function addCategory($categoryName)
        {
            if($this->established)
            {
                $query = "INSERT INTO categories VALUES(0,'$categoryName');";
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

        public function getCategory($categoryId)
        {
            if($this->established)
            {
                $query = "SELECT * FROM categories WHERE category_id = $categoryId";
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return 0;
                }
                else
                {
                    $category = $result->fetch_assoc();
                    return $category;
                }
            }
            else
            {
                return -1;
            }
        }

        public function updateCategory($categoryName,$categoryId)
        {
            if($this->established)
            {
                $query = "UPDATE categories SET category_name = '$categoryName' WHERE category_id = $categoryId";
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
            if($this->established)
            {
                $this->connection->close();
            }

        }
    }
?>