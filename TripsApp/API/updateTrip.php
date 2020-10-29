<?php
    require_once("./includes/autoload.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Methods,Access-Control-Allow-Headers,Content-Type,Authorization,X-Requested-With");
    $data = json_decode(file_get_contents("php://input"),true);

    if(empty($data['tripName']) || empty($data['tripPrice']) || empty($data['tripDescription']) || empty($data['tripId']))
    {
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $tripObj = new trip();
        $flg = $tripObj->updateTrip($data['tripId'],$data['tripName'],$data['tripDescription'],$data['tripPrice']);
        if($flg == -1)
        {
            echo json_encode(array("flg"=>-2));
        }
        else if($flg == 0)
        {
            echo json_encode(array("flg"=>-3));
        }
        else if($flg == 1)
        {
            echo json_encode(array("flg"=>1));
        }
    }

?>