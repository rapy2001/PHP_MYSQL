<?php
    session_start();
    if(!empty($_COOKIE['username']) && !empty($_COOKIE['user_id']))
    {
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['user_id'] = $_COOKIE['user_id'];
    }

?>