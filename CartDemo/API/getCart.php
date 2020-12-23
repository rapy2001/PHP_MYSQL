<?php
    require_once("./includes/autoload.php");
    header('Content-Type:application/json');
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Origin,X-Requested-With,Authorization,Content-Type");

    $data = json_decode(file_get_contents("php://input"),true);

    if(empty($data['userId']))
    {
        http_response_code(400);
        echo json_encode(array("flg" => -1));
    }
    else
    {
        $obj = new Cart();
        $flg = 1;
        $results = $obj->getCartItems($data['userId']);
        if($results['flg'] == 1)
        {
            $ary = [];
            $productObj = new Product();
            for($i = 0; $i < count($results['products']); $i++)
            {
                $result = $productObj->getProduct($results['products'][$i]['product_id']);
                if($result['flg'] === 1)
                {
                    $ary[] = $result['product'];
                    $ary[$i]['count'] = $obj->count($data['userId'],$result['product']['product_id'])['count'];
                }
                else
                {
                    $flg = 1;
                    http_response_code(500);
                    echo json_encode(array("flg" => 0));
                    break;
                }
            }
            if($flg == 1)
                echo json_encode(array("flg" => 1, "products" => $ary));
        }
        else
        {
            http_response_code(500);
            echo json_encode(array("flg" => 0));
        }
    }
?>