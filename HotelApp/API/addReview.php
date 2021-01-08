<?php
    require_once('./includes/autoload.php');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Methods,Origin,Content-Type,X-Requested-With,Authorizaion');

    $data = json_decode(file_get_contents('php://input'),true);

    if(empty($data['review']) || empty($data['rating']) || empty($data['userId']) || empty($data['roomId']))
    {
        http_response_code(400);
        echo json_encode(array('flg' => -1));
    }
    else
    {
        $obj = new Review();
        $results = $obj->addReview($data['review'],$data['rating'],$data['userId'],$data['roomId']);
        if($results['flg'] == 1)
        {
            echo json_encode(array('flg' => 1));
        }
        else
        {
            http_response_code(500);
            echo json_encode(array('flg' => 0));
        }
    }
?>