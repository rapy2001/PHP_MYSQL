<?php
    require_once('./includes/autoload.php');
    header('Content-Type:application/json');
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:GET");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Origin,X-Requested-With,Authorization");
    
    $product = new Product();
    $ary = $product->getProducts();
    if($ary['flg'] === 1)
    {
        echo json_encode(array("flg" => 1, "products" => $ary['data']));
    }
    else
    {
        http_response_code(500);
        echo json_encode(array("flg" => 0));
    }
?>