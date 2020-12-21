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
        public function __destruct()
        {
            if($this->isConnected)
            {
                $this->connection->close();
            }
        }
    }
?>