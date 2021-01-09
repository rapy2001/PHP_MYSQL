<?php
    class Review
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

        public function addReview($review,$rating,$userId,$roomId)
        {
            try
            {
                $query = 'INSERT INTO reviews VALUES (0,:review,:rating,:userId,:roomId)';
                $stmt = $this->pdoConnection->prepare($query);
                $stmt->execute(array(':review' => $review, ':rating' => $rating, ':userId' => $userId, ':roomId' => $roomId));
                return array('flg' => 1);
            }
            catch(Exception $e)
            {
                return array('flg' => -1, 'err' => $e->getMessage());
            }
        }

        public function getReviews($roomId,$page)
        {
            $limit = 2;
            $skip = $limit*($page - 1);
            try
            {
                $query = "SELECT * FROM reviews WHERE room_id = :roomId LIMIT $skip, $limit";
                $stmt = $this->pdoConnection->prepare($query);
                $stmt->execute(array(':roomId' => $roomId));
                $reviews = [];
                while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    $reviews[] = $row;
                }
                return array('flg' => 1, 'reviews' => $reviews);
            }
            catch(Exception $e)
            {
                return array('flg' => -1, 'err' => $e->getMessage());
            }
        }

        public function averageReview($roomId)
        {
            try
            {
                $query = 'SELECT AVG(rating) as average from reviews WHERE room_id = :roomId;';
                $stmt = $this->pdoConnection->prepare($query);
                $stmt->execute(array(':roomId' => $roomId));
                $rating = [];
                while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    $rating[] = $row;
                }
                return array('flg' => 1, 'rating' => $rating[0]['average']);
            }
            catch(Exception $e)
            {
                return array('flg' => -1, 'err' => $e->getMessage());
            }
        }

        public function deleteReview($reviewId)
        {
            try
            {
                $query = 'DELETE FROM reviews WHERE review_id = :reviewId';
                $stmt = $this->pdoConnection->prepare($query);
                $stmt->execute(array(':reviewId' => $reviewId));
                return array('flg' => 1);
            }
            catch(Exception $e)
            {
                return array('flg' => -1, 'err' => $e->getMessage());
            }
        }

        public function getReviewById($reviewId)
        {
            try
            {
                $query = 'SELECT * FROM reviews WHERE review_id = :reviewId';
                $stmt = $this->pdoConnection->prepare($query);
                $stmt->execute(array(':reviewId' => $reviewId));
                $review = [];
                while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    $review[] = $row;
                }
                return array('flg' => 1, 'review' => $review[0]);
            }
            catch(Exception $e)
            {
                return array('flg' => -1, 'err' => $e->getMessage());
            }
        }
    }
?>