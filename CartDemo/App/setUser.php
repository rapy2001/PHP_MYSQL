<?php
    require_once('./session/session.php');
    if(!empty($_GET['username']) && !empty($_GET['userId']))
    {
        $_SESSION['username'] = $_GET['username'];
        $_SESSION['userId'] = $_GET['userId'];
        setCookie('username',$_GET['username'],60*60);
        setCookie('userId',$_GET['userId'],60*60);
        header('Location: homepage.php');
    }
?>