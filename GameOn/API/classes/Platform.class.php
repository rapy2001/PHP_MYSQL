<?php

    class Platform
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

        public function getPlatforms()
        {
            if($this->established)
            {
                $query = "SELECT * FROM platforms";
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return 0;
                }
                else
                {
                    $categories = [];
                    while($row = $result->fetch_assoc())
                    {
                        $categories[] = $row;
                    }
                    return $categories;
                }
            }
            else
            {
                return -1;
            }
        }
        
        public function deletePlatform($platformId)
        {
            if($this->established)
            {
                $query = "DELETE FROM platforms WHERE platform_id = $platformId";
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

        public function checkPlatformStatus($platformText)
        {
            if($this->established)
            {
                $query = "SELECT platform_name FROM platforms WHERE platform_name LIKE '$platformText'";
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return 0;
                }
                else
                {
                    if($result->num_rows > 0)
                    {
                        return 2;
                    }
                    else
                    {
                        return 1;
                    }
                }
            }
            else
            {
                return -1;
            }
        }

        public function insertPlatform($platformText)
        {
            $platformText = strtolower($platformText);
            $query = "INSERT INTO platforms VALUES (0,'$platformText');";

            if($this->connection->query($query))
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }

        public function getPlatform($platformId)
        {
            if($this->established)
            {
                $query = "SELECT * FROM platforms WHERE platform_id = $platformId";
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return 0;
                }
                else
                {
                    $platform = $result->fetch_assoc();
                    return $platform;
                }
            }
            else
            {
                return -1;
            }
        }

        public function updatePlatform($platformId,$updatedText)
        {
            $updatedText = strtolower($updatedText);
            if($this->established)
            {
                $query = "UPDATE platforms SET platform_name = '$updatedText' WHERE platform_id = $platformId";
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