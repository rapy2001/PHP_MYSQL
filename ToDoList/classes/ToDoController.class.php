<?php

    class ToDoController extends ToDo
    {
        public function addNewToDo($message,$userId)
        {
            return $this->addToDo($message,$userId);
        }
        public function getAllToDo($userId)
        {
            return $this->getToDoS($userId);
        }
        public function updateToDoItem($id)
        {
            return $this->updateToDo($id);
        }
        public function deleteToDoItem($id)
        {
            return $this->deleteToDo($id);
        }
    }