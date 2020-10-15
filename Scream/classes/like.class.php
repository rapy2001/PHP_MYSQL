<?php
    class Like extends dbh
    {
        public function checkLikeStatus($user_id,$id,$type)
        {
            $connection = $this->connection();
            if($type == 1)
            {
                $sql = "SELECT * FROM likes WHERE user_id = ? AND scream_id=?";
            }
            else if($type == 2)
            {
                $sql = "SELECT * FROM likes WHERE user_id = ? AND comment_id=?";
            }
            $stmt = $connection->prepare($sql);
            $stmt->execute([$user_id,$id]);
            $results = $stmt->fetchAll();
            if(count($results) > 0)
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }

        public function addLike($user_id,$id,$type,$scream_id)
        {
            $connection = $this->connection();
            $sql = '';
            if($type == 1)
            {
                $sql = "INSERT INTO likes(user_id,scream_id,comment_id) VALUES(?,?,7)";
                // echo "Wroking 1";
                $stmt = $connection->prepare($sql);
                $stmt->execute([$user_id,$id]);
            }
            else if($type == 2)
            {
                $sql = "INSERT INTO likes(user_id,scream_id,comment_id) VALUES(?,?,?)";
                // echo "Wroking 2";
                $stmt = $connection->prepare($sql);
                $stmt->execute([$user_id,$scream_id,$id]);
            }
            // var_dump($sql);
            
        }

        public function deleteLike($user_id,$id,$type)
        {
            $connection = $this->connection();
            if($type == 1)
            {
                $sql = "DELETE FROM likes WHERE user_id = ? AND scream_id = ?";
            }
            else if($type == 2)
            {
                $sql = "DELETE FROM likes WHERE user_id = ? AND comment_id = ?";
            }
            $stmt = $connection->prepare($sql);
            $stmt->execute([$user_id,$id]);
        }

        public function getLikeCount($id,$type)
        {
            $connection = $this->connection();
            if($type == 1)
            {
                $sql = "SELECT * FROM likes WHERE scream_id = ?";
            }
            else if($type == 2)
            {
                $sql = "SELECT * FROM likes WHERE comment_id=?";
            }
            $stmt = $connection->prepare($sql);
            $stmt->execute([$id]);
            $results = $stmt->fetchAll();
            return count($results);
        }
    }
?>