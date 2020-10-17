<?php

    class User extends dbh
    {
        public function setNewUser($username,$password,$imageUrl,$city)
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
                if(empty($imageUrl))
                {
                    $sql = "INSERT INTO users(username,password,city) values(?,?,?)";
                    $stmt = $connection->prepare($sql);
                    $stmt->execute([$username,$password,$city]);
                }   
                else if(empty($city))
                {
                    $sql = "INSERT INTO users(username,password,imageUrl) values(?,?,?)";
                    $stmt = $connection->prepare($sql);
                    $stmt->execute([$username,$password,$imageUrl]);
                }
                else
                {
                    $sql = "INSERT INTO users values(0,?,?,?,?)";
                    $stmt = $connection->prepare($sql);
                    $stmt->execute([$username,$password,$imageUrl,$city]);
                } 
                return 1;
            }
        }

        public function getUser($username)
        {
            $connection = $this->connection();
            $sql = "SELECT * from users WHERE username = ?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$username]);
            if($stmt->rowCount() > 0)
            {
                $user = $stmt->fetch();
                return $user;
            }
            else
            {
                return 0;
            }
        }

        public function getUserWithId($userId)
        {
            $connection = $this->connection();
            $sql = "SELECT * from users WHERE user_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$userId]);
            if($stmt->rowCount() > 0)
            {
                $user = $stmt->fetch();
                return $user;
            }
            else
            {
                return 0;
            }
        }

        public function getAllUsers()
        {
            $connection = $this->connection();
            $sql = "SELECT * FROM users";
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll();
            return $users;
        }
        
        public function checkFriendshipStatus($user_id,$friend_id)
        {
            $connection = $this->connection();
            $sql = "SELECT * FROM friends WHERE friend_id = ? AND user_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$friend_id,$user_id]);
            if($stmt->rowCount() > 0)
            {
                return 0;
            }
            else
            {
                return 1;
            }
        }

        public function checkRequestStatus($to_id,$from_id)
        {
            $connection = $this->connection();
            $sql = "SELECT * FROM requests WHERE to_id = ? AND from_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$to_id,$from_id]);
            if($stmt->rowCount() > 0)
            {
                return 0;
            }
            else
            {
                return 1;
            }
        }
        
        public function addFriendRequest($to_id,$from_id)
        {
            $connection = $this->connection();
            $sql = "INSERT INTO requests VALUES(?,?)";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$to_id,$from_id]);
        }

        public function getAllRequests($user_id)
        {
            $connection = $this->connection();
            $sql = "SELECT users.user_id,users.username,users.imageUrl FROM users JOIN requests ON requests.from_id = users.user_id  AND requests.to_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$user_id]);
            $users = $stmt->fetchAll();
            return $users;
        }

        public function acceptFriendRequest($user_id,$friend_id)
        {
            $connection = $this->connection();
            $sql = "INSERT INTO friends VALUES(?,?)";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$friend_id,$user_id]);
            $sql = "INSERT INTO friends VALUES(?,?)";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$user_id,$friend_id]);
        }

        public function getAllFriends($userId)
        {
            $connection = $this->connection();
            $sql = "SELECT * FROM friends WHERE user_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$userId]);
            $friends = $stmt->fetchAll();
            return $friends;
        }

        public function deleteFriendship($user_Id,$friend_Id)
        {
            $connection = $this->connection();
            $sql = "DELETE FROM friends WHERE user_id = ? AND friend_id = ? OR user_id = ? AND friend_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$user_Id,$friend_Id,$friend_Id,$user_Id]);
        }

        // public function getSearchResults($searchTerm)
        // {
        //     $connection = $this->connection();
        //     $searchWord = strtolower($searchTerm);
        //     $searchAry = explode(" ",$searchWord);
        //     for($i = 0; $i<count($searchAry);$i++)
        //     {
        //         if($searchAry[$i] == ',' || $searchAry[$i] == '.' || $searchAry[$i] == '!' || $searchAry[$i] == '@')
        //         {
        //             array_shift($searchAry);
        //         }
        //     }
        //     $sql = "SELECT * FROM users WHERE ";
        //     for($i = 0; $i<count($searchAry);$i++)
        //     {
        //         if($i == count($searchAry) - 1)
        //             $sql.= "username LIKE $searchAry[$i]";
        //         else
        //             $sql.="username LIKE $searchAry[$i] OR ";
        //     }
        //     $result = $connection->query($sql);
        //     $searchResults = array();
        //     while($row = $result->fetch())
        //         $searchResults[] = $row;
        //     return $searchResults;
        // }
    }
?>