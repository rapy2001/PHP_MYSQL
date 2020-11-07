<?php
    class Image
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

        public function insertImage($relative,$absolute,$gameId)
        {
            $query = "INSERT INTO images (image,game_id,absolute_path) VALUES('$relative',$gameId,'$absolute');";
            if($this->connection->query($query))
            {
                $id = $this->connection->insert_id;
                return array('flg'=>1,"imageId"=>$id);
            }
            else
            {
                return 0;
            }
        }

        public function checkNumberOfImages($gameId)
        {
            if($this->established)
            {
                $query = "SELECT COUNT(game_id) as imageCount FROM images WHERE game_id = $gameId";
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return 0;
                }
                else
                {
                    return $result->fetch_assoc();
                }
            }
            else
            {
                return -1;
            }
            
        }

        public function getImage($imageId)
        {
            if($this->established)
            {
                $query = "SELECT * FROM images WHERE image_id = $imageId";
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return 0;
                }
                else
                {
                    $image = $result->fetch_assoc();
                    return $image;
                }
            }
            else
            {
                return -1;
            }
        }

        public function deleteImage($imageId)
        {
            if($this->established)
            {
                $query = "DELETE FROM images WHERE image_id = $imageId";
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
        public function __destruct()
        {
            if($this->established)
            {
                $this->connection->close();
            }
        }
    }
?>