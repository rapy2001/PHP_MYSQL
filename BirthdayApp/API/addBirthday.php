<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With");
    $name = empty($_POST['name']) ? '' : $_POST['name'];
    $birthday = empty($_POST['birthday']) ? '' : $_POST['birthday'];
    if($name == '' || $birthday == '')
    {
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $query = "SELECT * FROM birthdays WHERE person_name = '$name'";
        $result = mysqli_query($conn,$query) or die("Error while getting the data from the database : " . mysqli_error($conn));
        if(mysqli_num_rows($result) > 0)
        {
            echo json_encode(array("flg"=>-2));
        }
        else
        {
            $filename = empty($_FILES['image']['name']) ? '' : $_FILES['image']['name'];
            if(!empty($filename))
            {
                $ext = explode('.',$filename);
                $ext = $ext[count($ext) - 1];
                $validTypes = array('jpeg','jpg','png','gif');
                    if(in_array($ext,$validTypes))
                    {
                        if($_FILES['image']['size'] > 5000000)
                        {
                            echo json_encode(array("flg"=>-4));
                        }
                        else
                        {
                            $path = "../APP/public/IMAGES/PERSONS/" . $name . "_" . time() . '.' .$ext;
                            if(move_uploaded_file($_FILES['image']['tmp_name'],$path))
                            {
                                $query = "INSERT INTO birthdays(person_name,birthday,imageUrl) VALUES('$name','$birthday','$path');";
                                if(mysqli_query($conn,$query))
                                {
                                    echo json_encode(array("flg"=>1));
                                }
                                else
                                {
                                    echo json_encode(array("flg"=>-3,"err"=>mysqli_error($conn)));
                                }
                            }
                            else
                            {
                                echo json_encode(array("flg"=>-5));
                            }
                            
                        }
                    }
                    else
                    {
                        echo json_encode(array("flg"=>-6));
                    }
                @unlink($_FILES['image']['tmp_name']);
            }
            else
            {
                $query = "INSERT INTO birthdays(person_name,birthday) VALUES('$name','$birthday');";
                if(mysqli_query($conn,$query))
                {
                    echo json_encode(array("flg"=>1));
                }
                else
                {
                    echo json_encode(array("flg"=>-3,"err"=>mysqli_error($conn)));
                }
            }
        }
        
    }
    mysqli_close($conn);
?>