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
        $results = $obj->getUserByUsername($data['username']);
        if($results['flg'] == -1)
        {
            http_response_code(500);
            echo json_encode(array('flg' => 0));
        }
        else
        {
            if(count($results['user']) > 0)
            {
                if($results['user'][0]['password'] == sha1($data['password']))
                {
                    echo json_encode(array('flg' => 1, 'user' => $results['user'][0]));
                }
                else
                {
                    echo json_encode(array('flg' => 3));
                }
            }
            else
            {
                echo json_encode(array('flg' => 2));
            }
        }
    }
?>