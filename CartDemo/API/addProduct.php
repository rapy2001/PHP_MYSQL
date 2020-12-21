<?php
    require_once('./includes/autoload.php');
    header('Access-Control-Access-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Origin,X-Requested-With,Authorization');
    header('Content-Type:application/json');
    $data = json_decode(file_get_contents("php://input"),true);
    if(empty($data['name']) || empty($data['price']) || empty($data['quantity']))
    {
        http_response_code(400);
        echo json_encode(array("flg" => -1));
    }
    else
    {
        $product = new Product();
        if(empty($data['image']))
        {
            $data['image'] = 'https://cdn.dribbble.com/users/997338/screenshots/11042582/media/6a5e4c40661818c9b7fa40ff458d8643.png?compress=1&resize=1000x750';
        }
        $ary = $product->insertProduct($data['name'],$data['price'],$data['quantity'],$data['image']);
        if($ary['flg'] === 1)
        {
            http_response_code(200);
            echo json_encode(array("flg" => 1));
        }
        else
        {
            http_response_code(500);
            echo json_encode(array("flg" => 0, "err" => $ary['err']));
        }
    }
?>