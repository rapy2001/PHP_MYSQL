<?php
    require_once('./includes/autoload.php');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Methods,Origin,X-Requested-With,Authorization,Content-Type');
    $data = json_decode(file_get_contents('php://input'),true);

    if(empty($data['username']) || empty($data['password']))
    {
        http_response_code(400);
        echo json_encode(array('flg' => -1));
    }
    else
    {
        $obj = new User();
        if(empty($data['imageUrl']))
            $data['imageUrl'] = 'https://cdn.dribbble.com/users/1355613/screenshots/14735248/media/e8f4b73b359cffcb33233eebbe14bf9e.jpg?compress=1&resize=1000x750';
        $result = $obj->getUserByUsername($data['username']);
        if($result['flg'] == -1)
        {
            http_response_code(500);
            echo json_encode(array('flg' => 0, 'err' => $results['err']));
        }
        else
        {
            if(count($result['user']) > 0)
            {
                echo json_encode(array('flg' => 2));
            }
            else
            {
                $results = $obj->addUser($data['username'],sha1($data['password']),$data['imageUrl']);
                if($results['flg'] == -1)
                {
                    http_response_code(500);
                    echo json_encode(array('flg' => 0, 'err' => $results['err']));
                }
                else
                {
                    echo json_encode(array('flg' => 1));
                }
            }
        }
    }
?>