<?php

    class UserController extends UserModel
    {
        public function addNewUser($username,$password,$imageUrl)
        {
            return $this->addUser($username,$password,$imageUrl);
        }
        public function getUserDetails($username,$password)
        {
            return $this->getUser($username);
        }
    }