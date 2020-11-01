<?php
    require_once("./includes/autoload.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Origin,Authorization,Content-Type,X-Requested-With");
    $data = json_decode(file_get_contents("php://input"),true);
    if(empty($data['itemId']) || empty($data['name']) || empty($data['price']) || empty($data['description']))
    {
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $menuObj = new menu();
        $flg = $menuObj->updateItem($data['itemId'],$data['name'],$data['price'],$data['description']);
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