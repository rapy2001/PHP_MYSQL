<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With");
    $data = json_decode(file_get_contents("php://input"),true);
    if($data['id'] == '')
    {
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $id = $data['id'];
        $query = "DELETE FROM birthdays WHERE birthday_id = $id";
        if(mysqli_query($conn,$query))
        {
            echo json_encode(array("flg"=>1));
        }
        else
        {
            echo json_encode(array("flg"=>-2));
        }
    }
    mysqli_close($conn);
?>