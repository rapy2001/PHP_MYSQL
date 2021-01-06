<?php
    session_start();
    if(!empty($_GET['username']) && !empty($_GET['userId']))
    {
        setcookie('username',$_GET['username'],60*60);
        setcookie('user_id',$_GET['userId'],60*60);
        $_SESSION['user_id'] = $_GET['userId'];
        $_SESSION['username'] = $_GET['username'];
        header('Location:homepage.php');
    }
?>