<?php
    class Cart
    {
        private $host = 'localhost';
        private $user = 'root';
        private $password = '';
        private $dbName = 'cart_demo';
        private $connection = null;
        private $isConnected = false;
        private $pdoConnection = null;

        public function __construct()
        {
            $this->connection = new mysqli($this->host,$this->user,$this->password,$this->dbName);
            if($this->connection->connect_error)
            {
                $this->isConnected = false;
            }
            else
            {
                $this->isConnected = true;
            }
            $this->pdoConnection = new PDO("mysql:host=$this->host;dbname=$this->dbName",$this->user,$this->password);
            $this->pdoConnection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }

        public function insertItem($userId,$productId)
        {
            try
            {   
                $query = 'INSERT INTO cart VALUES (:userId,:productId)';
                $stmt = $this->pdoConnection->prepare($query);
                $stmt->execute(array(":userId" => $userId,":productId" => $productId));
                return array("flg" => 1);
            }
            catch(Exception $e)
            {
                return $ary = array("flg" => -1, "err" => $e->getMessage());
            }
        }

        public function getCartItems($userId)
        {
            try
            {
                $query = 'SELECT DISTINCT product_id FROM cart WHERE user_id = :userId';
                // $query = 'SELECT products.product_id,products.name,products.price,products.quantity,products.image FROM products INNER JOIN cart ON products.product_id = cart.product_id WHERE cart.user_id = :userId';
                $stmt = $this->pdoConnection->prepare($query);
                $stmt->execute(array(":userId" => $userId));
                $ary = [];
                while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    $ary[] = $row;
                }
                return array("flg" => 1, "products" => $ary);
            }
            catch(Exception $e)
            {
                return array("flg" => -1, "err" => $e->getMessage());
            }
        }

        public function count($userId,$productId)
        {
            try
            {
                $query = 'SELECT count(product_id) as total FROM cart WHERE user_id = :userId AND product_id = :productId';
                $stmt = $this->pdoConnection->prepare($query);
                $stmt->execute(array(":userId" => $userId, ":productId" => $productId));
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return array("flg" => 1, "count" => $data['total']);
            }
            catch(Exception $e)
            {
                return array("flg" => -1, "err" => $e->getMessage());
            }
        }

        public function getStatus($userId,$productId)
        {
            try
            {
                $query = 'SELECT * FROM cart WHERE user_id = :userId AND product_id = :productId';
                $stmt = $this->pdoConnection->prepare($query);
                $stmt->execute(array(":userId" => $userId, ":productId" => $productId));
                $ary = [];
                while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    $ary = $row;
                }
                if(count($ary) > 0)
                {
                    return array("flg" => 1);
                }
                else
                {
                    return array("flg" => 0);
                }
            }
            catch(Exception $e)
            {
                return array("flg" => -1, "err" => $e->getMessage());
            }
        }

        public function removeItemFromCart($userId,$productId)
        {
            try
            {
                $query = 'DELETE FROM cart WHERE user_id = :userId AND product_id = :productId';
                $stmt = $this->pdoConnection->prepare($query);
                $stmt->execute(array(":userId" => $userId, ":productId" => $productId));
                return array("flg" => 1);
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