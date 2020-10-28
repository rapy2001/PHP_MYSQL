<?php

    require_once("./includes/connection.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With");
    
    $query = "DELETE FROM users WHERE username <> 'Admin'";
    if(mysqli_query($conn,$query))
    {
        $query = "DELETE FROM birthdays";
        if(mysqli_query($conn,$query))
        {
            echo json_encode(array("flg"=>1));
        }
        else
        {
            echo json_encode(array("flg"=>-2));
        }
    }
    else
    {
        echo json_encode(array("flg"=>-1));
    }
    mysqli_close($conn);
?>