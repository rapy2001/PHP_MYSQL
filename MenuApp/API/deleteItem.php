<?php
    require_once("./includes/autoload.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Origin,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With");

    $data = json_decode(file_get_contents("php://input"),true);
    if(empty($data['itemId']))
    {
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $itemObj = new menu();
        $flg = $itemObj->deleteItem($data['itemId']);
        if($flg == 1)
        {
            echo json_encode(array("flg"=>1));
        }
        else
        {
            echo json_encode(array("flg"=>0));
        }
    }
?>