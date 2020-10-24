<?php
    require_once("../../API/Includes/connection.php");
    require_once("../../API/Includes/session.php");
    if(!empty($_SESSION['username']))
    {
        setcookie("username","",time() - 60*60);
        setcookie("user_id","",time() - 60*60);
        $_SESSION = array();
        header('Refresh:0;url = "homepage.php"');
    }
    mysqli_close($conn);
?>