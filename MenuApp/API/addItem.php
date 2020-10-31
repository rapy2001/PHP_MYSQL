<?php
    require_once("./includes/autoload.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Origin,Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With");
    $name = empty($_POST['name']) ? '' : $_POST['name'];
    $price = empty($_POST['price']) ? '' : $_POST['price'];
    $description = empty($_POST['description']) ? '' : $_POST['description'];
    $categoryId = empty($_POST['categoryId']) ? '' : $_POST['categoryId'];
    $imageName = empty($_FILES['image']['name']) ? '' : $_FILES['image']['name'];

    if(empty($name) || empty($price) || empty($description) || empty($categoryId))
    {
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $images = 
        [
            'https://cdn.dribbble.com/users/143350/screenshots/14006097/media/6d7806731a1d2cfff7b37598338f5502.png',
            'https://cdn.dribbble.com/users/143350/screenshots/14052412/media/27ab3785352e64f357bc1608bae74361.png',
            'https://cdn.dribbble.com/users/1012997/screenshots/14073001/media/4994fedc83e967607f1e3b3e17525831.png'
        ];
        if(!empty($imageName))
        {
            $ext = explode('.',$imageName);
            $ext = $ext[count($ext) - 1];
            $allowed = array('jpg','jpeg','png','gif');
            if(in_array($ext,$allowed))
            {
                if($_FILES['image']['size'] > 500000)
                {
                    echo json_encode(array("flg"=>-5));
                }
                else
                {
                    $time = time();
                    $path = "D:/html/xampp/htdocs/projects/MenuApp/APP/public/IMAGES/" . $name . '_' . $time . '.' .$ext;
                    if(move_uploaded_file($_FILES['image']['tmp_name'],$path))
                    {
                        $path = "../public/IMAGES/" . $name . '_' . $time . '.' .$ext;
                        $itemObj = new menu();
                        $flg = $itemObj->insertItem($name,$price,$description,$path,$categoryId);
                        if($flg == 1)
                        {
                            echo json_encode(array("flg"=>1));
                        }
                        else if($flg == -1)
                        {
                            echo json_encode(array("flg"=>-2));
                        }
                        else if($flg == 0)
                        {
                            echo json_encode(array("flg"=>-3));
                        }
                    }
                    else
                    {
                        echo json_encode(array("flg"=>-6));
                    }
                }
            }
            else
            {
                echo json_encode(array("flg"=>-4));
            }
            @unlink($_FILES['image']['tmp_name']);
        }
        else
        {
            
            $imageUrl = $images[rand(0,3)];
            $itemObj = new menu();
            $flg = $itemObj->insertItem($name,$price,$description,$imageUrl,$categoryId);
            if($flg == 1)
            {
                echo json_encode(array("flg"=>1));
            }
            else if($flg == -1)
            {
                echo json_encode(array("flg"=>-2));
            }
            else if($flg == 0)
            {
                echo json_encode(array("flg"=>-3));
            }
        }
    }
?>