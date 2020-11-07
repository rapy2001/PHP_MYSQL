<?php
    require_once('./includes/autoload.php');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Origin,Content-Type,Authorization,X-Requested-With');
    $data = json_decode(file_get_contents('php://input'),true);

    if(empty($data['gameName']) || empty($data['gameDate']) || empty($data['gameDescription']) || empty($data['gameCategory']))
    {
        http_response_code(200);
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $gameObj = new Game();
        $result = $gameObj->insertGame($data['gameName'],$data['gameDate'],$data['gameDescription'],$data['gameCategory']);
        if(is_array($result))
        {
            http_response_code(200);
            echo json_encode($result);
        }
        else if($result == -2)
        {
            http_response_code(200);
            echo json_encode(array("flg"=>-2));
        }
        else
        {
            http_response_code(500);
            echo json_encode(array("flg"=>0));
        }
    }
?>