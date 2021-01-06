<?php
    require_once('./session/session.php');
    $_SESSION = [];
    setcookie('username','',time() - 60);
    setcookie('user_id','',time() - 60);
    header('Location:homepage.php');
?>