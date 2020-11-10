<?php
    require_once("./includes/autoload.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Origin,Authorization,X-Requested-With");
    $data = json_decode(file_get_contents("php://input"),true);

    if(empty($data['gameId']) || empty($data['userId']) || empty($data['reviewText']) || empty($data['rating']))
    {
        http_response_code(200);
        echo json_encode(array("flg" => -1));
    }
    else
    {
        $reviewObj = new Review();
        $flg = $reviewObj->insertReview($data['gameId'],$data['rating'],$data['userId'],$data['reviewText']);
        if($flg == 1)
        {
            http_response_code(200);
            echo json_encode(array("flg" => 1));
        }
        else
        {
            http_response_code(200);
            echo json_encode(array("flg" => 0));
        }
    }
?>