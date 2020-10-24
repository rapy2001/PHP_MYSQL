<?php
    header("Content-Type:application/json");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With");
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    $data = json_decode(file_get_contents("php://input"),true);
    if(empty($data['username']) || empty($data['password']))
    {
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $username = $data['username'];
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn,$sql) or die("Error while querying the database");
        if(mysqli_num_rows($result) > 0)
        {
            $password = sha1($data['password']);
            $row = mysqli_fetch_assoc($result);
            if($row['password'] == $password)
            {
                setcookie("username",$row['username'],60*60);
                setcookie("user_id",$row['user_id'],60*60);
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_id'] = $row['user_id'];
                echo json_encode(array("flg"=>1));
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
?>