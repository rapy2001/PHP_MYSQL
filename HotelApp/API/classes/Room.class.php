<?php
    class Room
    {
        private $host = 'localhost';
        private $username = 'root';
        private $password = '';
        private $dbName = 'hotel_app';
        private $pdoConnection = null;

        function __construct()
        {
            $this->pdoConnection = new PDO("mysql:host=$this->host;dbname=$this->dbName",$this->username,$this->password);
            $this->pdoConnection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }

        public function addRoom($name,$primaryImage,$image1,$image2,$image3,$description,$price,$size,$pets,$snacks)
        {
            try
            {
                $query = 'INSERT INTO rooms VALUES (0,:name,:primaryImage,:image1,:image2,:image3,:description,:price,:size,:pets,:snacks)';
                $stmt = $this->pdoConnection->prepare($query);
                $stmt->execute(array(":name" => $name, ":primaryImage" => $primaryImage, ":image1" => $image1, ":image2" => $image2, ":image3" => $image3, ":description" => $description, ":price" => $price, ":size" => $size, ":pets" => $pets, ":snacks" => $snacks));
                return array("flg" => 1);
            }
            catch(Exception $e)
            {
                return array("flg" => -1, "err" => $e->getMessage());
            }
        }

        public function fetchRooms()
        {
            try
            {
                $query = 'SELECT * FROM rooms';
                $results = $this->pdoConnection->query($query);
                $rooms = [];
                while($row = $results->fetch(PDO::FETCH_ASSOC))
                {
                    $rooms[] = $row;
                }
                return array("flg" => 1, "rooms" => $rooms);
            } 
            catch(Exception $e)
            {
                return array("flg" => -1, "err" => $e->getMessage());
            }
        }

        public function addFeature($roomId,$feature)
        {
            try
            {
                $query = 'INSERT INTO extras VALUES (0,:roomId,:feature)';
                $stmt = $this->pdoConnection->prepare($query);
                $stmt->execute(array(":roomId" => $roomId, ":feature" => $feature));
                return array("flg" => 1, "stmt" => $stmt);
            }
            catch(Exception $e)
            {
                return array("flg" => -1, "err" => $e->getMessage());
            }
        }
    }
?>