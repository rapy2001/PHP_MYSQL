<?php
    require_once("./includes/autoload.php");
    require_once("../APP/components/session/session.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Origin,Authorization,X-Requested-With,Content-Type");
    $data = json_decode(file_get_contents("php://input"),true);

    if(empty($data['username']) || empty($data['password']))
    {
        http_response_code(200);
        echo json_encode(array("flg" => -1));
    }
    else
    {
        $userObj = new User();
        $flg = $userObj->checkUser($data['username']);
        if($flg == 2)
        {
            $user = $userObj->getUserUsingUsername($data['username']);
            
            if($user['password'] == sha1($data['password']))
            {
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['user_id'];
                http_response_code(200);
                echo json_encode(array("flg" => 1));
            }
            else
            {
                http_response_code(200);
                echo json_encode(array("flg" => 3));
            }
        }
        else if($flg == 1)
        {
            http_response_code(200);
            echo json_encode(array("flg" => 2));
        }
        else
        {
            http_response_code(200);
            echo json_encode(array("flg" => 0));
        }
    }
?>