<?php
    class Game
    {
        private $server = 'localhost';
        private $userName = 'root';
        private $password = '';
        private $dbName = 'game_on';
        private $established = false;
        private $connection;

        public function __construct()
        {
            $this->connection = new mysqli($this->server,$this->userName,$this->password,$this->dbName);
            if($this->connection->connect_error)
            {
                $this->established = false;
            }
            else
            {
                $this->established = true;
            }
        }
        public function insertGame($gameName,$gameDate,$gameImage,$gameDescription,$gameCategory)
        {
            if($this->connection)
            {
                $query = "INSERT INTO games VALUES (0,'$gameName','$gameDate','$gameImage','$gameDescription',$gameCategory);";
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