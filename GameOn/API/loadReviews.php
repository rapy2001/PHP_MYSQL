<?php
    require_once("./includes/autoload.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Origin,Content-Type,X-Requested-With,Authorization");

    $data = json_decode(file_get_contents("php://input"),true);

    if(empty($data['gameId']) || empty($data['page']))
    {
        http_response_code(200);
        echo json_encode(array("flg" => -1));
    }
    else
    {
        $limit = 2;
        $skip = ($data['page'] - 1) * $limit;
        $reviewObj = new Review();
        $result = $reviewObj->getReviews($skip,$limit,$data['gameId']);
        $page = $data['page'] + 1;
        if(is_array($result))
        {
            http_response_code(200);
            echo json_encode(array("flg" => 1, "reviews" => $result, "page" => $page));
        }
        else
        {
            http_response_code(200);
            echo json_encode(array("flg" => 0));
        }
    }
?>