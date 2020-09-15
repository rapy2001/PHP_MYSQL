<?php
    require_once("./includes/session.php");
    require_once("./includes/vars.php");
    if(isset($_SESSION['user_id']))
    {
        $_SESSION = array();
        setcookie('username','',time() - 60*60);
        setcookie('user_id','',time() - 60*60);
        session_destroy();
        header('Refresh:4;url = "homepage.php"');
        echo 'You have Logged Out Successfully. You wil be Redirected Shortly';
    }
    else
    {
        header('Refresh:4?url = "homepage.php"');
        echo 'Plese Log In To logout';
    }
    require_once("./includes/footer.php");
?>