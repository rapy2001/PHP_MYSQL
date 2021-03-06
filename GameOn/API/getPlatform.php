<?php
    require_once("./includes/autoload.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Origin,Authorization,X-Requested-With,Content-Type");

    $data = json_decode(file_get_contents("php://input"),true);

    if(empty($data['platformId']))
    {
        http_response_code(200);
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $platformObj = new Platform();

        $result = $platformObj->getPlatform($data['platformId']);
        if(is_array($result))
        {
            http_response_code(200);
            echo json_encode(array("flg"=>1,"platform"=>$result));
        }
        else
        {
            http_response_code(200);
            echo json_encode(array("flg"=>0));
        }

    }
?>