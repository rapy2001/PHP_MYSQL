<?php
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Methos,Content-Type,Authorization,X-Requested-With");
    require_once("./includes/loader.php");
    require_once("./includes/connection.php");
    $userId = empty($_POST['userId']) ? '' : $_POST['userId'];
    $city = empty($_POST['city']) ? '' : $_POST['city'];
    if($userId != '')
    {
        $filename = empty($_FILES['image']) ? '' : $_FILES['image']['name'];
        if($filename != '')
        {
            $validTypes = array("jpeg",'jpg','png','gif');
            $ext = pathinfo($filename,PATHINFO_EXTENSION);
            if(in_array($ext,$validTypes))
            {
                if($_FILES['image']['size'] <= 1000000)
                {
                    $obj = new User();
                    $userDetails = $obj->getUserWithId($userId);
                    $path = "./Images/User/".$userDetails['username'].'_'.time().'.'.$ext;
                    if(move_uploaded_files($_FILES['image']['tmp_name'],$path))
                    {
                        $query = "UPDATE users SET city = $city, imageUrl=$path WHERE user_id=$userId";
                        if(mysqli_query($conn,$query))
                        {
                            // echo json_encode(array("status"=>200));
                            echo json_encode(array("status"=>200,"filename"=>"$filename"));
                        }
                        else
                        {
                            // echo json_encode(array("status"=>4));
                            echo json_encode(array("status"=>200,"filename"=>"$filename"));
                        }
                        @unlink($_FILES['image']['tmp_name']);
                        @unlink($userDetails['imageUrl']);
                    }
                    else
                    {
                        // echo json_encode(array("status"=>3));
                        echo json_encode(array("status"=>200,"filename"=>"$filename"));
                    }
                }
                else
                {
                    // echo json_encode(array("status"=>2));
                    echo json_encode(array("status"=>200,"filename"=>"$filename"));
                }
            }
            else
            {
                // echo json_encode(array("status"=>1));
                echo json_encode(array("status"=>200,"filename"=>"$filename"));
            }
        }
        else
        {
            // $ary = explode('.',$_FILES['image']['name']);
            // $ext = $ary[strlen($ary) - 1];
            // $path = "./Images/User/".rand().'_'.time().'.'.$ext;
            $query = "UPDATE users SET city = '$city' WHERE user_id=$userId;";
            if(mysqli_query($conn,$query))
            {
                echo json_encode(array("status"=>200));
            }
            else
            {
                echo json_encode(array("status"=>4,"msg"=>'error'));
            }           
        }
    }
    else
    {
        echo json_encode(array("status"=>0));
    }
    mysqli_close($conn);
?>