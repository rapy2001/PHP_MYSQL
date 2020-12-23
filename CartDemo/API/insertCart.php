<?php
    require_once("./includes/autoload.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Methods,Access-Control-Allow-Headers,Origin,X-Requested-With,Authorization");
    $data = json_decode(file_get_contents("php://input"),true);

    if(empty($data['userId']) || empty($data['productId']))
    {
        http_response_code(400);
        echo json_encode(array("flg" => -1));
    }
    else
    {
        $productObj = new Product;
        $results = $productObj->getProduct($data['productId']);
        if($results['flg'] === -1)
        {
            http_response_code(500);
            echo json_encode(array("flg" => 0, "err" => $ary['err']));
        }
        else
        {
            if($results['product']['quantity'] <= 0)
            {
                echo json_encode(array("flg" => 2));
            }
            else
            {
                $results = $productObj->alterQuantity($data['productId'],1);
                if($results['flg'] == -1)
                {
                    http_response_code(500);
                    echo json_encode(array("flg" => 0, "err" => $ary['err']));
                }
                else
                {
                    $obj = new Cart();
                    $ary = $obj->insertItem($data['userId'],$data['productId']);
                    if($ary['flg'] == 1)
                    {
                        echo json_encode(array("flg" => 1));
                    }
                    else
                    {
                        http_response_code(500);
                        echo json_encode(array("flg" => 0, "err" => $ary['err']));
                    }
                }
            }
        }
    }
?>