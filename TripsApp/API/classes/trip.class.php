<?php
    class trip {
        private $serverName = 'localhost';
        private $userName = 'root';
        private $password = '';
        private $dbName = 'small_projects';
        private $connection;
        private $established = false;


        public function __construct()
        {
            $this->connection = new mysqli($this->serverName,$this->userName,$this->password,$this->dbName);
            if(! ($this->connection->connect_error))
            {
                $this->established = true;
            }
        }


        public function insert_trip($tripName,$tripDescription,$tripPrice,$tripImage)
        {
            if($this->established)
            {
                $sql = "INSERT INTO trips VALUES(0,'$tripName','$tripDescription',$tripPrice,'$tripImage');";
                if($this->connection->query($sql))
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

        public function getTrips($skip,$pageNum)
        {
            if($this->established)
            {
                $sql = "SELECT * FROM trips LIMIT $skip,$pageNum";
                $result = $this->connection->query($sql);
                if($this->connection->error)
                {
                    return 0;
                }
                else
                {
                    $trips = [];
                    while($row = $result->fetch_assoc())
                        $trips[] = $row;
                    return $trips;
                }
            }
            else
            {
                return -1;
            }
            
        }


        public function __destruct()
        {
            $this->connection->close();
        }
    }
?>