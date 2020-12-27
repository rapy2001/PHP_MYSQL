<?php
    require_once('./includes/autoload.php');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Methods,Origin,X-Requested-With,Authorization,Content-Type');

    $data = json_decode(file_get_contents("php://input"),true);

    if(empty($data['name']) || empty($data['description']) || empty($data['price']) || empty($data['size']) || empty($data['pets']) || empty($data['snacks']))
    {
        http_response_code(400);
        echo json_encode(array("flg" => -1,"data" => $data));
    }
    else
    {
        if(empty($data['primaryImage']))
        {
            $data['primaryImage'] = 'https://images.pexels.com/photos/262048/pexels-photo-262048.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940';
        }

        if(empty($data['image1']))
        {
            $data['image1'] = 'https://cdn.dribbble.com/users/1180260/screenshots/4834845/alert.gif';
        }

        if(empty($data['image2']))
        {
            $data['image2'] = 'https://cdn.dribbble.com/users/1180260/screenshots/4834845/alert.gif';
        }

        if(empty($data['image3']))
        {
            $data['image3'] = 'https://cdn.dribbble.com/users/1180260/screenshots/4834845/alert.gif';
        }

        $obj = new Room();

        $result = $obj->addRoom($data['name'],$data['primaryImage'],$data['image1'],$data['image2'],$data['image3'],$data['description'],$data['price'],$data['size'],$data['pets'],$data['snacks']);
        if($result['flg'] === 1)
        {   
            echo json_encode(array("flg" => 1));
        }
        else
        {
            http_response_code(500);
            echo json_encode(array("flg" => 0));
        }
    }
?>