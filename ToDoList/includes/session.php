<?php
    session_start();

    if(empty($_SESSION['user_id']) && !empty($_COOKIE['user_id']))
    {
        $_SESSION['user_id'] = $_COOKIE['user_id'];
        $_SESSION['username'] = $_COOKIE['username'];
    }
?>