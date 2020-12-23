<?php

    class Product
    {
        private $host = 'localhost';
        private $username = 'root';
        private $password = '';
        private $dbName = 'cart_demo';
        private $connection = null;
        private $isConnected = false;
        private $pdoConnection = null;

        public function __construct()
        {
            $this->connection = new mysqli($this->host,$this->username,$this->password,$this->dbName);
            if($this->connection->connect_error)
            {
                $this->isConnected = false;
            }
            else
            {
                $this->isConnected = true;
            }
            $this->pdoConnection = new PDO("mysql:host=$this->host;dbname=$this->dbName",$this->username,$this->password);
            $this->pdoConnection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }

        public function insertProduct($name,$price,$quantity,$image)
        {
            try
            {
                $query = "INSERT INTO products VALUES (0,:name,:quantity,:image,:price)";
                $stmt = $this->pdoConnection->prepare($query);
                $stmt->execute(array(":name" => $name, ":price" => $price, ":quantity" => $quantity, ":image" => $image));
                $ary = array("flg" => 1);
                return $ary;
            }
            catch(Exception $e)
            {
                $ary = array("flg" => -1, 'err' => $e->getMessage());
                return $ary;
            }
        }

        public function getProducts()
        {
            if($this->isConnected)
            {
                $query = 'SELECT * FROM products';
                $results = $this->connection->query($query);
                if($this->connection->error)
                {
                    return array("flg" => -1);
                }
                else
                {
                    $ary = [];
                    while($row = $results->fetch_assoc())
                    {
                        $ary[] = $row;
                    }
                    return array("flg" => 1, "data" => $ary);
                }
            }
            else
            {
                return array("flg" => -1);
            }
        }

        public function getProduct($productId)
        {
            try
            {
                $query = 'SELECT * FROM products WHERE product_id = :productId';
                $stmt = $this->pdoConnection->prepare($query);
                $stmt->execute(array(":productId" => $productId));
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                return array("flg" => 1, "product" => $product);
            }
            catch(Exception $e)
            {
                return array("flg" => -1, "err" => $e->getMessage());
            }
        }

        public function alterQuantity($productId,$flg)
        {
            try
            {
                $results = $this->getProduct($productId);
                if($results['flg'] == -1)
                {
                    return array("flg" => -1, "err" => $results['err']);
                }
                else
                {
                    $quantity = (int) $results['product']['quantity'];
                    if($flg === 1)
                    {
                        $quantity -= 1;
                    }
                    else
                    {
                        $quantity += 1;
                    }
                    try
                    {
                        $query = 'UPDATE products SET quantity = :quantity WHERE product_id = :productId';
                        $stmt = $this->pdoConnection->prepare($query);
                        $stmt->execute(array(":quantity" => $quantity, ":productId" => $productId));
                        return array("flg" => 1);
                    }
                    catch(Exception $e)
                    {
                        return array("flg" => -1, "err" => $e->getMessage());
                    }
                }
            }
            catch(Exception $e)
            {
                return array("flg" => -1, "err" => $e->getMessage());
            }
        }

        
        public function __destruct()
        {
            if($this->isConnected)
            {
                $this->connection->close();
            }
        }
    }
?>