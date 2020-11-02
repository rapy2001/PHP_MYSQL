<?php
    require_once("./includes/autoload.php");
    header("Content-Type:Application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:GET");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Origin,Content-Type,Authorization,X-Requested-With");
    $itemObj = new Item();
    $items = $itemObj->getAllItems();
    if(is_array($items))
    {
        http_response_code(200);
        echo json_encode(array("flg" => 1,"items"=>$items));
    }
    else
    {
        http_response_code(500);
        echo json_encode(array("flg" => -11));
    }
?>