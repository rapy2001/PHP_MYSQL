<?php
    require_once('./includes/autoload.php');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Origin.X-Requested-With,Authorization,Content-Type');
    $data = json_decode(file_get_contents("php://input"),true);
    if(empty($data['gameId']))
    {
        http_response_code(200);
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $gameObj = new Game();
        $result = $gameObj->getGameDetails($data['gameId']);
        if(is_array($result))
        {
            $game = $result;
            $gamePlatformObj = new GamePlatform();
            $result = $gamePlatformObj->getGamePlatforms($data['gameId']);
            if(is_array($result))
            {
                $platforms = $result;
                $imageObj = new Image();
                $result = $imageObj->getGameImages($data['gameId']);
                if(is_array($result))
                {
                    $images = $result;
                    http_response_code(200);
                    echo json_encode(array("flg"=>1,"game"=>$game,"platforms"=>$platforms,"images"=>$images));
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