<?php
    
    class User
    {
        private $host = 'localhost';
        private $username = 'root';
        private $password = '';
        private $dbName = 'hotel_app';
        private $pdoConnection = null;

        public function __construct()
        {
            $this->pdoConnection = new PDO("mysql:host=$this->host;dbname=$this->dbName",$this->username,$this->password);
            $this->pdoConnection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }

        public function addUser($username,$password,$imageUrl)
        {
            try
            {
                $query = 'INSERT INTO users VALUES (0,:username,:password,:imageUrl)';
                $stmt = $this->pdoConnection->prepare($query);
                $stmt->execute(array(':username' => $username, ':password' => $password, ':imageUrl' => $imageUrl));
                return array('flg' => 1);
            }
            catch(Exception $e)
            {
                return array("flg" => -1, 'err' => $e->getMessage());
            }
        }

        public function getUserByUsername($username)
        {
            try
            {
                $query = 'SELECT * FROM users WHERE username = :username';
                $stmt = $this->pdoConnection->prepare($query);
                $stmt->execute(array(':username' => $username));
                $results = [];
                while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                    $results[] = $row;
                return array('flg' => 1, 'user' => $results);
            }
            catch(Exception $e)
            {
                return array("flg" => -1, 'err' => $e->getMessage());
            }
        }
    }
?>