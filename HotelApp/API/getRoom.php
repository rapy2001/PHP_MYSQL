<?php
    require_once('./includes/autoload.php');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Methods,Origin,Content-Type,Authorization,X-Requested-With');
    $data = json_decode(file_get_contents('php://input'),true);

    if(empty($data['roomId']))
    {
        http_response_code(400);
        echo json_encode(array('flg' => -1));
    }
    else
    {
        $obj = new Room();
        $results = $obj->getRoom($data['roomId']);
        if($results['flg'] === 1)
        {
            $newResults = $obj->getRoomExtras($data['roomId']);
            if($newResults['flg'] == 1)
            {
                echo json_encode(array('flg' => 1, 'room' => $results['room'], 'extras' => $newResults['extras']));
            }
            else
            {
                http_response_code(500);
                echo json_encode(array('flg' => 0, 'err' => $results['err']));
            }
        }
        else
        {
            http_response_code(500);
            echo json_encode(array('flg' => 0, 'err' => $results['err']));
        }
    }
?>