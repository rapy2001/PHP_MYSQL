<?php
    class User
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

        public function checkUser($username)
        {
            if($this->established)
            {
                $query = "SELECT * FROM users WHERE username LIKE '$username';";
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

        public function insertUser($username,$password)
        {
            if($this->established)
            {
                $password = sha1($password);
                $query = "INSERT INTO users(username,password) VALUES ('$username','$password');";
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

        public function getUserUsingUsername($username)
        {
            if($this->established)
            {
                $query = "SELECT * FROM users WHERE username = '$username'";
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return 0;
                }
                else
                {
                    $user = $result->fetch_assoc();
                    return $user;
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