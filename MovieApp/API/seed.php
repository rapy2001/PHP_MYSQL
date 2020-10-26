<?php

    require_once("./includes/connection.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Methods,Content-Type,Authorization,X-Requested-With");
    $sql = "DELETE FROM users WHERE username <> 'Admin'";
    if(mysqli_query($conn,$sql))
    {
        $sql = "DELETE FROM reviews";
        if(mysqli_query($conn,$sql))
        {
            $sql = "DELETE FROM movies";
            if(mysqli_query($conn,$sql))
            {
                echo json_encode(array("flg"=>1));
            }
            else
            {
                echo json_encode(array("flg"=>-3));
            }
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