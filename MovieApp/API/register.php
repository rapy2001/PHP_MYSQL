<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With");
    $data = json_decode(file_get_contents("php://input"),true);
    if(empty($data['username']) || empty($data['password']))
    {
        echo json_encode(array("flg"=>-1,"data"=>$data));
    }
    else
    {
        $username = $data['username'];
        
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn,$sql) or die("Error while querying the database");
        if(mysqli_num_rows($result) > 0)
        {
            echo json_encode(array("flg"=>-2));
        }
        else
        {
            $password = sha1($data['password']);
            $sql = "INSERT INTO users VALUES(0,'$username','$password')";
            if(mysqli_query($conn,$sql))
            {
                echo json_encode(array("flg"=>1));
            }
            else
            {
                echo json_encode(array("flg"=>-3));
            }
        }
    }
    mysqli_close($conn);
?>