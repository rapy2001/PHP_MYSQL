<?php
    require_once('./includes/autoload.php');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Origin.X-Requested-With,Authorization');
    $data = json_decode(file_get_contents("php://input"),true);
    if(empty($data['username']) || empty($data['password']))
    {
        http_response_code(400);
        echo json_encode(array("flg" => -1));
    }
    else
    {
        $user = new User();
        $ary = $user->getUserByUsername($data['username']);
        if($ary['flg'] === 1)
        {
            if(!empty($ary['data']))
            {
                if(sha1($data['password']) == $ary['data']['password'])
                {
                    echo json_encode(array("flg" => 1, "user" => $ary['data']));
                }
                else
                {
                    echo json_encode(array("flg" => 2));
                }
            }
            else
            {
                echo json_encode(array("flg" => 3));
            }
        }
        else
        {
            http_response_code(500);
            echo json_encode(array("flg" => 0, "err" => $ary['err']));
        }
    }
?>