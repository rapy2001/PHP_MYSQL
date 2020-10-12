<?php

    class User extends dbh
    {
        public function setNewUser($username,$password,$imageUrl)
        {
            $password = sha1($password);
            $connection = $this->connection();
            $sql = "SELECT user_id FROM users WHERE username = ?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$username]);
            if($stmt->rowCount()>0)
                return 0;
            else
            {
                $sql = "INSERT INTO users values(0,?,?,?)";
                $stmt = $connection->prepare($sql);
                $stmt->execute([$username,$password,$imageUrl]);
                return 1;
            }
        }
    }
?>