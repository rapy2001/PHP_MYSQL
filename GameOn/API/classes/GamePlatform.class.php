<?php

    class GamePlatform
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

        public function insertGamePlatform($gameId,$platformId)
        {
            if($this->established)
            {
                $query = "INSERT INTO game_platforms VALUES ($gameId,$platformId)";
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

        public function getGamePlatforms($gameId)
        {
            if($this->established)
            {
                $query = "SELECT platforms.platform_name FROM game_platforms inner join platforms ON game_platforms.platform_id = platforms.platform_id WHERE game_platforms.game_id = $gameId";
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return 0;
                }
                else
                {
                    $platforms = [];
                    while($row = $result->fetch_assoc())
                    {
                        $platforms[] = $row;
                    }
                    return $platforms;
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