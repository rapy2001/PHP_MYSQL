<?php
    require_once("./includes/autoload.php");
    header('Content-Type:application/json');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Origin,Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With');
    $data = json_decode(file_get_contents("php://input"),true);
    if(empty($data['categoryId']))
    {
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $menuObj = new menu();
        $items = $menuObj->getItems($data['categoryId']);
        if(is_array($items))
        {
            echo json_encode(array("flg"=>1,"items"=>$items));
        }
        else
        {
            echo json_encode(array("flg"=>0));
        }
    }
?>