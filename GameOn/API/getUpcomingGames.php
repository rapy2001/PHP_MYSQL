<?php
    require_once('./includes/autoload.php');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Origin,Content-Type,X-Requested-With,Authorization');

    $gameObj = new Game();

    $result = $gameObj->getUpcomingGames();

    if(is_array($result))
    {
        http_response_code(200);
        echo json_encode(array("flg" => 1,"games" => $result));
    }
    else
    {
        http_response_code(200);
        echo json_encode(array("flg" => 0));
    }

?>