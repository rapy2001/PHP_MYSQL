<?php

    class Review
    {
        private $serverName = 'localhost';
        private $userName = 'root';
        private $password = '';
        private $dbName = 'game_on';

        private $established = false;
        private $connection;

        public function __construct()
        {
            $this->connection =  new mysqli($this->serverName,$this->userName,$this->password,$this->dbName);
            if($this->connection->connect_error)
            {
                $this->established = false;
            }
            else
            {
                $this->established = true;
            }
        }

        public function insertReview($gameId,$rating,$userId,$reviewText)
        {
            if($this->established)
            {
                $query = "INSERT INTO reviews (reviewText,rating,user_id,game_id) VALUES ('$reviewText',$rating,$userId,$gameId);";
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

        public function getReviews($skip,$limit,$gameId)
        {
            if($this->established)
            {
                $query = "SELECT reviews.reviewText, reviews.rating, reviews.review_id, users.username FROM reviews inner join users ON reviews.user_id = users.user_id WHERE game_id = $gameId LIMIT $skip,$limit";
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return 0;
                }
                else
                {
                    $reviews = [];
                    while($row = $result->fetch_assoc())
                    {
                        $reviews[] = $row;
                    }
                    return $reviews;
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