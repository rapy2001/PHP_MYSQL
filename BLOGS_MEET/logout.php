<?php
    require_once("./includes/session.php");
    require_once("./includes/vars.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    if(isset($_SESSION['user_id']))
    {
        $_SESSION = array();
        setcookie('username','',time() - 60*60);
        setcookie('user_id','',time() - 60*60);
        session_destroy();
        header('Refresh:4;url = "homepage.php"');
        echo '<div id = "empty_div"><h2 id = "empty">You have Logged Out Successfully. You wil be Redirected Shortly</h2></div>';
    }
    else
    {
        header('Refresh:4?url = "homepage.php"');
        echo '<div id = "empty_div"><h2 id = "empty"Please Log In to Log Out</h2></div>';
    }
    mysqli_close($conn);
    require_once("./includes/footer.php");
?>