<?php
    class ToDo extends dbh
    {
        protected function addToDo($message,$userId)
        {
            $connection = $this->connection();
            $message = empty($message) ? 'Empty':$message;
            $query = "INSERT INTO todo VALUES(0,?,?,?)";
            $stmt = $connection->prepare($query);
            $stmt->execute([$userId,$message,'N']);
            return 1;
        }

        protected function getToDoS($userId)
        {
            $connection = $this->connection();
            $query = "SELECT * FROM todo WHERE user_id = ?";
            $stmt = $connection->prepare($query);
            $stmt->execute([$userId]);
            $list = $stmt->fetchAll();
            return $list;
        }

        protected function updateToDo($id)
        {
            $query = "SELECT checked FROM todo  WHERE id = ?";
            $connection = $this->connection();
            $stmt = $connection->prepare($query);
            $stmt->execute([$id]);
            $ary = $stmt->fetchAll();
            // var_dump($ary);
            if($ary[0]['checked'] == 'N')
                $query = "UPDATE todo SET checked = 'Y' WHERE id =?";
            else
                $query = "UPDATE todo SET checked = 'N' WHERE id = ?";
            $stmt= $connection->prepare($query);
            $stmt->execute([$id]);
            return 1;
        }

        protected function deleteToDo($id)
        {
            $query = "DELETE FROM todo  WHERE id = ?";
            $connection = $this->connection();
            $stmt = $connection->prepare($query);
            $stmt->execute([$id]);
            return 1;
        }
    }