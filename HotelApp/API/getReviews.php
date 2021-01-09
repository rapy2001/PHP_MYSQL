<?php
    require_once('./includes/autoload.php');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Methods,Origin,Content-Type,X-Requested-With,Authorizaion');

    $data = json_decode(file_get_contents('php://input'),true);

    if(empty($data['roomId']) || empty($data['page']))
    {
        http_response_code(400);
        echo json_encode(array('flg' => -1));
    }
    else
    {
        $obj = new Review();
        $results = $obj->getReviews($data['roomId'],$data['page']);
        if($results['flg'] == 1)
        {
            $result = $obj->averageReview($data['roomId']);
            if($result['flg'] == 1)
            {
                echo json_encode(array('flg' => 1, 'reviews' => $results['reviews'], 'rating' => $result['rating']));
            }
            else
            {
                http_response_code(500);
                echo json_encode(array('flg' => 0));
            }
        }
        else
        {
            http_response_code(500);
            echo json_encode(array('flg' => 0));
        }
    }
?>