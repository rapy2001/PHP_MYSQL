<?php
    require_once("./includes/connection.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With");
    $id = empty($_POST['id']) ? '' : $_POST['id'];
    if(!empty($_FILES['image']) && !empty($id))
    {
        $filename = $_FILES['image']['name'];
        $ary = explode(".",$filename);
        $ext = pathinfo($filename,PATHINFO_EXTENSION);
        $allowed = array("jpeg","jpg","png","gif");
        if(in_array($ext,$allowed))
        {
            if($_FILES['image']['size'] <= 5000000)
            {
                $time = time();
                $path = "../IMAGES/MOVIES/" . $ary[0] . "_" . $time . "." . $ext;
                $actPath = "/projects/MovieApp/IMAGES/MOVIES/" . $ary[0] . "_" . $time . "." . $ext;
                if(move_uploaded_file($_FILES['image']['tmp_name'],$path))
                {
                    $sql = "UPDATE movies SET imageUrl = '$actPath' WHERE movie_id = $id";
                    if(mysqli_query($conn,$sql))
                    {
                        echo json_encode(array("flg"=>1,"path"=>$actPath));
                    }
                    else
                    {
                        echo json_encode(array("flg"=>-5));
                    }
                    
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
    else
    {
        echo json_encode(array("flg"=>-4));
    }
    mysqli_close($conn);
?>