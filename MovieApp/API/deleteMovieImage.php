<?php
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With");
    $data = json_decode(file_get_contents("php://input"),true);
    echo json_encode(array("flg"=>$data["path"]));
    if(!empty($data['path']))
    {
        if(unlink($data['path']))
        {
            echo json_encode(array("flg"=>1));
        }
        else
        {
            echo json_encode(array("flg"=>0));
        }
    }
?>