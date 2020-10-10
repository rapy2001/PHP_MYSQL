<?php
    // require_once("dbh.class.php");
    class UserModel extends dbh
    {
        private $username;
        private $password;
        private $imageUrl;
        
        protected function addUser($username,$password,$imageUrl)
        {
            $connection = $this->connection();
            $sql = "SELECT username from users where username=?";
            $result = $connection->prepare($sql);
            $result->execute([$username]);
            $ary  = $result->fetchAll();
            if(count($ary)>0)
            {
                return 0;
            }
            else
            {
                $hash = sha1($password);
                if(empty($imageUrl))
                {
                    $query = "INSERT INTO users(password,username) values(?,?)";
                    $result = $connection->prepare($query);
                    $result->execute([$hash,$username]);
                    return 1;
                }
                else
                {
                    $query = "INSERT INTO users values(0,?,?,?)";
                    $result = $connection->prepare($query);
                    $result->execute([$username,$imageUrl,$hash]);
                    return 1;
                }
                
            }
        }
        protected function getUser($username)
        {
            $connection = $this->connection();
            $query = "SELECT * FROM users where username=?";
            $result = $connection->prepare($query);
            $result->execute([$username]);
            $user = $result->fetchAll();
            if(count($user)>0)
            {
                $user = $user[0];
                return $user;
            }
            else
            {
                $user = '';
                return $user;
            }
        }
    }