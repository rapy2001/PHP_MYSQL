<?php
    require_once("./includes/loader.php");
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    
    if(empty($_SESSION['user_id']))
    {
        echo '<div>No One to Log Out</div>';
    }
    else
    {
        setcookie('user_id','',time()-60*60);
        setcookie('username','',time()-60*60);
        $_SESSION = array();
        header('Refresh:3;url="homepage.php"');
        echo '<div>Logged Out Successfully</div>';
    }
    require_once("./includes/footer.php");
?>