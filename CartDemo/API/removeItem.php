<?php
    require_once("./includes/autoload.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Origin,Content-Type,X-Requested-With,Authorization");
    $data = json_decode(file_get_contents("php://input"),true);

    if(empty($data['userId']) || empty($data['productId']))
    {
        http_response_code(400);
        echo json_encode(array("flg" => -1));
    }
    else
    {
        $productObj = new Product();
        $results = $productObj->alterQuantity($data['productId'],2);
        if($results['flg'] === 1)
        {   
            $cartObj = new Cart();
            $newResults = $cartObj->removeItemFromCart($data['userId'],$data['productId']);
            if($newResults['flg'] == 1)
            {
                echo json_encode(array("flg" => 1));
            }
            else
            {
                http_response_code(500);
                echo json_encode(array("flg" => 0));
            }
        }
        else
        {
            http_response_code(500);
            echo json_encode(array("flg" => 0, "err" => $results['err']));
        }
    }
?>