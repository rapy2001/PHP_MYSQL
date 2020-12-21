<?php

    class User
    {
        private $host = 'localhost';
        private $username = 'root';
        private $password = '';
        private $dbName = 'cart_demo';
        private $connection = null;
        private $isConnected = false;
        private $pdoConnection;
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

        public function createUser($username,$password,$image)
        {
            try
            {
                if(empty($image))
                {
                    $image = 'https://cdn.dribbble.com/users/1355613/screenshots/14671270/media/d79062cd036d84eb32b34e4a4b393a97.jpg?compress=1&resize=1000x750';
                }
                $password = sha1($password);
                $query = 'INSERT INTO users VALUES (0,:username,:password,:image)';
                $stmt = $this->pdoConnection->prepare($query);
                $stmt->execute(array(":username" => $username,":password" => $password, ":image" => $image));
                return array("flg" => 1);
            }
            catch(Exception $e)
            {
                return array("flg" => -1,"err" => $e->getMessage());
            }
        }

        public function getUserByUsername($username)
        {
            try
            {
                $query = 'SELECT * FROM users WHERE username = :username';
                $stmt = $this->pdoConnection->prepare($query);
                $stmt->execute(array(":username" => $username));
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return array("flg" => 1, 'data' => $data);
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