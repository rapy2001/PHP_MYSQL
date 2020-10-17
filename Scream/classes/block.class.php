<?php

    class Block extends dbh
    {
        public function getBlockStatus($user_id,$block_id)
        {
            $connection =  $this->connection();
            $sql = "SELECT * FROM block WHERE user_id = ? AND block_id=?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$user_id,$block_id]);
            if($stmt->rowCount() > 0)
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }

        public function blockUser($user_id,$block_id)
        {
            $connection = $this->connection();
            $sql = "INSERT INTO block VALUES(?,?)";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$user_id,$block_id]);
        }

        public function getAllBlockedUsers($user_id)
        {
            $connection = $this->connection();
            $sql = "SELECT * FROM block WHERE user_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$user_id]);
            $blockedUsers = $stmt->fetchAll();
            return $blockedUsers;
        }

        public function unblockUser($user_id,$block_id)
        {
            $connection = $this->connection();
            $sql = "DELETE FROM block WHERE user_id = ? AND block_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$user_id,$block_id]);
        }
    }
?>