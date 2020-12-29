<?php
    require_once('./includes/autoload.php');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Methods,Origin,Content-Type,X-Requested-With');

    $obj = new Room();

    $results = $obj->fetchRooms();

    if($results['flg'] === -1)
    {
        http_response_code(500);
        echo json_encode(array("flg" => 0));
    }
    else
    {
        echo json_encode(array("flg" => 1, "rooms" => $results['rooms']));
    }
?>