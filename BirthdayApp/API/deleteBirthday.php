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
        $query = "SELECT imageUrl FROM birthdays WHERE birthday_id = $id";
        $result = mysqli_query($conn,$query) or die("Error while getting the data :" . mysqli_error($conn));
        $path = mysqli_fetch_assoc($result)['imageUrl'];
        @unlink($path);
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