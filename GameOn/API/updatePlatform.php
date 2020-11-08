<?php
    require_once("./includes/autoload.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Origin,Authorization,X-Requested-With,Content-Type");

    $data = json_decode(file_get_contents("php://input"),true);

    if(empty($data['platformId']) || empty($data['updatedPlatformText']))
    {
        http_response_code(200);
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $updateText = strtolower($data['updatedPlatformText']);
        $platformObj = new Platform();
        $flg = $platformObj->checkPlatformStatus($updateText);
        if($flg == 1)
        {
            $updateText = strtolower($data['updatedPlatformText']);
            $flg = $platformObj->updatePlatform($data['platformId'],$updateText);
            if($flg == 1)
            {
                http_response_code(200);
                echo json_encode(array("flg"=>1));
            }
            else
            {
                http_response_code(200);
                echo json_encode(array("flg"=>0));
            }
        }
        else if($flg == 2)
        {
            http_response_code(200);
            echo json_encode(array("flg"=>2));
        }
        else
        {
            http_response_code(200);
            echo json_encode(array("flg"=>0));
        }
    }
?>