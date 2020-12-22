<?php
    require_once('./session/session.php');
    if(!empty($_SESSION['username']) && !empty($_SESSION['userId']))
    {
        $_SESSION = array();
        setCookie('username','',time() - 60);
        setCookie('userId','',time() - 60);
        header('Location:homepage.php');
    }

?>