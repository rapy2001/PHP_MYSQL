<?php
    require_once("./includes/autoload.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Origin,Authorization,X-Requested-With");
    $data = json_decode(file_get_contents("php://input"),true);

    if(empty($data['text']))
    {
        http_response_code(400);
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $itemObj = new Item();
        $flg = $itemObj->insert($data['text']);

        if($flg == 1)
        {
            http_response_code(200);
            echo json_encode(array("flg"=>1));
        }
        else
        {
            http_response_code(500);
            json_encode(array("flg"=>0));
        }

    }
?>  