<?php
    session_start();
    if(!empty($_COOKIE['username']))
    {
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['userId'] = $_COOKIE['userId'];
    }
?>