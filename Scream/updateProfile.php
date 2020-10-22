<?php
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With");
    require_once("./includes/loader.php");
    require_once("./includes/connection.php");
    $city = empty($_POST['city']) ? '':$_POST['city'];
    $userId = empty($_POST['userId']) ? '':$_POST['userId'];
    if(!empty($_FILES['image']['name']) && $userId != '' && $city != '')
    {
        $filename = $_FILES['image']['name'];
        $ary = explode(".",$filename);
        $ext = pathinfo($filename,PATHINFO_EXTENSION);
        $allowed = array("jpeg","jpg","png","gif");
        if(in_array($ext,$allowed))
        {
            if($_FILES['image']['size'] <= 1000000)
            {
                $obj =  new User();
                $userDetails = $obj->getUserWithId($userId);
                $path = "./images/User/" . $userDetails['username'] . "_" . time() . "." . $ext;
                if(move_uploaded_file($_FILES['image']['tmp_name'],$path))
                {
                    echo json_encode(array("flg"=>1,"path"=>$path));
                    $userId = (int)$userId;
                    $sql = "UPDATE users SET imageUrl = '$path', city = '$city' WHERE user_id = $userId";
                    // mysqli_query($conn,$sql);
                    // echo json_encode(array("flg"=>1));
                    if(mysqli_query($conn,$sql))
                    {
                        echo json_encode(array("flg"=>1,"path"=>$path));
                    }
                    else
                    {
                        echo json_encode(array("flg"=>-4));
                    }
                    @unlink($userDetails['imageUrl']);
                }
                else
                {
                    echo json_encode(array("flg"=>-3));
                }
            }
            else
            {
                echo json_encode(array("flg"=>-2));
            }
        }
        else
        {
            echo json_encode(array("flg"=>-1));
        }
        @unlink($_FILES['image']['tmp_name']);
    }
    else if($city != '' && $userId != '')
    {
        $userId = (int)$userId;
        $sql = "UPDATE users SET city = '$city' WHERE user_id = $userId";
        if(mysqli_query($conn,$sql))
        {
            echo json_encode(array("flg"=>1));
        }
        else
        {
            echo json_encode(array("flg"=>-4));
        }           
    }
    else
    {
        echo json_encode(array("flg"=>-5));
    }
    mysqli_close($conn);
?>