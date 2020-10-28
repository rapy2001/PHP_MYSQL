<?php
    require_once("./includes/session.php");
    require_once("./includes/connection.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With");
    $username = empty($_POST['username']) ? '':$_POST['username'];
    $password = empty($_POST['password']) ? '' :$_POST['password'];
    if(empty($username) || empty($password))
    {
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $query = "SELECT * FROM users WHERE username = '$username'";
        if($result = mysqli_query($conn,$query))
        {
            if(mysqli_num_rows($result) > 0)
            {
                echo json_encode(array("flg"=>-7));
            }
            else
            {
                $filename = empty($_FILES['image']['name']) ? '' :$_FILES['image']['name'];
                if(!empty($_FILES['image']['name']))
                {
                    $ext = explode(".",$filename);
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
                            $path = "../APP/public/IMAGES/USERS/" . $username . "_" . time() . '.' .$ext;
                            if(move_uploaded_file($_FILES['image']['tmp_name'],$path))
                            {
                                $password = sha1($password);
                                $path = "../public/IMAGES/USERS/" . $username . "_" . time() . '.' .$ext;;
                                $query = "INSERT INTO users VALUES(0,'$username','$password','$path')";
                                if(mysqli_query($conn,$query))
                                {
                                    echo json_encode(array("flg"=>1));
                                }
                                else
                                {
                                    echo json_encode(array("flg"=>-2,"err"=>mysqli_error($conn)));
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
                        echo json_encode(array("flg"=>-3,"ext"=>$ext));
                    }
                    @unlink($_FILES['image']['tmp_name']);
                }
                else
                {
                    $password = sha1($password);
                    $query = "INSERT INTO users(username,password) VALUES('$username','$password');";
                    if(mysqli_query($conn,$query))
                    {
                        echo json_encode(array("flg"=>1,"password"=>$password));
                    }
                    else
                    {
                        echo json_encode(array("flg"=>-2,"err"=>mysqli_error($conn)));
                    }
                }
            }
        }
        else
        {
            echo json_encode(array("flg"=>-6,"err"=>mysqli_error($conn)));
        }
        
    }
    mysqli_close($conn);
?>