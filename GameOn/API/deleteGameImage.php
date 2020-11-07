<?php
    require_once('./includes/autoload.php');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Origin,Content-Type,Authorization,X-Requested-With');
    $data = json_decode(file_get_contents("php://input"),true);
    if(empty($data['imageId']))
    {
        http_response_code(200);
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $imageObj = new Image();
        $result = $imageObj->getImage($data['imageId']);
        if(is_array($result))
        {   
            if(unlink($result['absolute_path']))
            {
                $flg = $imageObj->deleteImage($data['imageId']);
                if($flg == 1)
                {
                    $obj = new Game();
                    $flg = $obj->removeImage($result['game_id']);
                    http_response_code(200);
                    echo json_encode(array("flg"=>1));
                }
                else
                {
                    http_response_code(200);
                    echo json_encode(array("flg"=>-4));
                }
            }
            else
            {
                http_response_code(200);
                echo json_encode(array("flg"=>-3));
            }
        }
        else
        {
            http_response_code(200);
            echo json_encode(array("flg"=>-2));
        }
    }
?>