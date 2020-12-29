<?php
    require_once('./includes/autoload.php');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Methods,Origin,X-Requested-With,Authorization');

    $data = json_decode(file_get_contents('php://input'),true);

    if(empty($data['roomId']) || empty($data['feature']))
    {
        http_response_code(400);
        echo json_encode(array("flg" => -1));
    }
    else
    {
        $obj= new Room();
        $results = $obj->addFeature($data['roomId'],$data['feature']);
        if($results['flg'] === 1)
        {
            echo json_encode(array("flg" => 1));
        }
        else
        {
            http_response_code(500);
            echo json_encode(array("flg" => 0, "err" => $results['err']));
        }
    }
?>