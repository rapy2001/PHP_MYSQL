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

        public function insertGame($gameName,$gameDate,$gameDescription,$gameCategory)
        {
            if($this->connection)
            {
                $query = "SELECT name FROM games WHERE name = '$gameName'";
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return -3;
                }
                else
                {
                    if($result->num_rows > 0)
                    {
                        return -2;
                    }
                    else
                    {
                        $query = "INSERT INTO games (name,game_date,description,category_id) VALUES ('$gameName','$gameDate','$gameDescription',$gameCategory);";
                        if($this->connection->query($query))
                        {
                            $id = $this->connection->insert_id;
                            return array("flg"=>1,"id"=>$id);
                        }
                        else
                        {
                            return 0;
                        }
                    }
                }
            }
            else
            {
                return -1;
            }
        }

        public function getGame($gameId)
        {
            if($this->established)
            {
                $query = "SELECT * FROM games WHERE game_id = $gameId";
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return 0;
                }
                else
                {
                    $game = $result->fetch_assoc();
                    return $game;
                    
                }
            }
            else
            {
                return -1;
            }
        }

        public function getUpcomingGames()
        {
            if($this->established)
            {
                $query = 'SELECT games.game_id, games.name, games.game_date, games.description, categories.category_name FROM games inner join categories ON games.category_id = categories.category_id WHERE game_date > NOW()';
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return 0;
                }
                else
                {
                    $games = [];
                    $imageObj = new Image();
                    while($row = $result->fetch_assoc())
                    {
                        
                        $data = $imageObj->getGameImages($row['game_id']);
                        $row['imageUrl'] = $data[0]['image'];
                        $games[] = $row;

                    }
                    return $games;
                }
            }
            else
            {
                return -1;
            }
        }

        public function getGameDetails($gameId)
        {
            if($this->established)
            {
                $query = "SELECT games.name, games.game_date, games.imageUrl, games.description, categories.category_name FROM games inner join categories ON games.category_id = categories.category_id WHERE game_id = $gameId";
                $result = $this->connection->query($query);
                if($this->connection->error)
                {
                    return 0;
                }
                else
                {
                    $game = $result->fetch_assoc();
                    return $game;
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