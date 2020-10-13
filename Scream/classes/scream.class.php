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
            }
            else
            {
                $sql = 'INSERT INTO screams(user_id,Scream_text,scream_image) VALUES(?,?,?)';
                $stmt = $connection->prepare($sql);
                $stmt->execute([$user_id,$scream_text,$scream_image]);
            }
        }
    }
?>