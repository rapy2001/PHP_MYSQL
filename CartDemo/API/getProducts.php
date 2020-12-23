<?php
    require_once('./includes/autoload.php');
    header('Content-Type:application/json');
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:GET,POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Origin,X-Requested-With,Authorization");
    if(empty($_GET['userId']))
    {
        http_response_code(400);
        echo json_encode(array("flg" => -1));
    }
    else
    {
        $product = new Product();
        $ary = $product->getProducts();
        if($ary['flg'] === 1)
        {
            $products = $ary['data'];
            $cartObj = new Cart();
            for($i = 0; $i<count($products); $i++)
            {
                $results = $cartObj->getStatus($_GET['userId'],$products[$i]['product_id']);
                if($results['flg'] == -1)
                {
                    http_response_code(500);
                    echo json_encode(array("flg" => 0));
                    break;
                }
                else
                {
                    $products[$i]['status'] = $results['flg'];
                }
            }
            echo json_encode(array("flg" => 1, "products" => $products));
        }
        else
        {
            http_response_code(500);
            echo json_encode(array("flg" => 0));
        }
    }
    
?>