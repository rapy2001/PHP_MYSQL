<?php
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With");
    if(!empty($_FILES['image']))
    {
        $filename = $_FILES['image']['name'];
        $ary = explode(".",$filename);
        $ext = pathinfo($filename,PATHINFO_EXTENSION);
        $allowed = array("jpeg","jpg","png","gif");
        if(in_array($ext,$allowed))
        {
            if($_FILES['image']['size'] <= 1000000)
            {
                $path = "./images/" . $ary[0] . "_" . time() . "." . $ext;
                if(move_uploaded_file($_FILES['image']['tmp_name'],$path))
                {
                    echo json_encode(array("flg"=>1,"path"=>$path));
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
        @unlink($_FILES['image']);
    }
?>