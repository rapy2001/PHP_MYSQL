<?php
    require_once('./includes/autoload.php');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Methods,Origin,X-Requested-With,Authorization,Content-Type');

    $data = json_decode(file_get_contents("php://input"),true);

    if(empty($data['price']) || empty($data['size']) || empty($data['pets']) || empty($data['snacks']) || empty($data['guests']) || empty($data['type']))
    {
        http_response_code(400);
        echo json_encode(array("flg" => -1,"data" => $data));
    }
    else
    {
        $obj = new Room();
        $results = $obj->searchRooms($data['price'],$data['size'],$data['pets'],$data['snacks'],$data['guests'],$data['type']);
        if($results['flg'] === 1)
        {
            echo json_encode(array("flg" => 1, "rooms" => $results['rooms']));
        }
        else
        {
            http_response_code(500);
            echo json_encode(array("flg" => 0, 'err' => $results['err']));
        }
    }
?>