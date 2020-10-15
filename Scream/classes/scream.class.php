<?php

    class Scream extends dbh
    {
        public function createScream($scream_text,$scream_image,$user_id)
        {
            $connection = $this->connection();
            if(empty($scream_image))
            {

                $sql = 'INSERT INTO screams(user_id,Scream_text) VALUES(?,?)';
                $stmt = $connection->prepare($sql);
                $stmt->execute([$user_id,$scream_text]);
                $sql = "SELECT * FROM screams WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
                $stmt = $connection->prepare($sql);
                $stmt->execute([$user_id]);
                $scream = $stmt->fetch();
                return $scream;
            }
            else
            {
                $sql = 'INSERT INTO screams(user_id,Scream_text,scream_image) VALUES(?,?,?)';
                $stmt = $connection->prepare($sql);
                $stmt->execute([$user_id,$scream_text,$scream_image]);
                $sql = "SELECT * FROM screams WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
                $stmt = $connection->prepare($sql);
                $stmt->execute([$user_id]);
                $scream = $stmt->fetch();
                return $scream;
            }
        }

        public function getScream($scream_id)
        {
            $connection = $this->connection();
            $sql = "SELECT * from screams WHERE scream_id=?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$scream_id]);
            $scream = $stmt->fetch();
            return $scream;
        }

        public function updateScream($screamId,$screamText,$screamImage)
        {
            $connection = $this->connection();
            $scream = $this->getScream($screamId);
            @unlink($scream['scream_image']);
            if(empty($screamImage))
            {
                echo 'working 1';
                $sql = "UPDATE screams SET Scream_text='$screamText',created_at=NOW() WHERE scream_id=$screamId";
                $stmt = $connection->query($sql);
                // $stmt = $connection->prepare($sql);
                // $stmt->execute([$scream_text,$scream_id]);
            }
            else
            {
                echo 'working 2';
                $sql = "UPDATE screams SET Scream_text='$screamText',scream_image='$screamImage',created_at=NOW() WHERE scream_id='$screamId';";
                $stmt = $connection->query($sql);
                // $stmt = $connection->prepare($sql);
                // $stmt->execute([$scream_text,$scream_image,$scream_id]);
            }
        }

        public function getUserScreams($userId)
        {
            $connection = $this->connection();
            $sql = "SELECT * FROM screams WHERE user_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$userId]);
            $screams = $stmt->fetchAll();
            return $screams;
        }

        public function getFriendsScreams($userId)
        {
            $connection = $this->connection();
            $sql = "SELECT screams.scream_id,screams.user_id,screams.Scream_text,screams.scream_image,screams.created_at FROM screams inner join friends  ON screams.user_id = friends.friend_id AND friends.user_id = ?;";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$userId]);
            $screams = $stmt->fetchAll();
            return $screams;
        }

        public function deleteScream($screamId)
        {
            $connection = $this->connection();
            $scream = $this->getScream($screamId);
            @unlink($scream['scream_image']);
            $sql = "DELETE from screams WHERE scream_id=?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$screamId]);
        }
    }

    
?>