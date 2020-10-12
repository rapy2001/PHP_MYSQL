<?php
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    if(!empty($_SESSION['user_id']))
    {
        setcookie('user_id','',time()-60*60);
        setcookie('username','',time()-60*60);
        $_SESSION = array();
        header('Refresh:3;url="homepage.php"');
        echo '<h4>Logged Out Successfully</h4>';
    }
    else
    {
        echo '<div class = "empty"><h4 class = "empty_h4">No one to Log Out !</h4></div>';
    }
    require_once("includes/footer.php");
?>