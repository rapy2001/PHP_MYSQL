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
    }
?>