<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With");
    if(!empty($_SESSION['username']))
    {
        setcookie("username","",time() - 60*60);
        setcookie("user_id","",time() - 60*60);
        $_SESSION = array();
        echo json_encode(array("flg"=>1));
    }
?>