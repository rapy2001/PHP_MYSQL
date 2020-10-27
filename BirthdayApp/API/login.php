<?php
    require_once("./includes/session.php");
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
        $password = $data['password'];
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn,$query) or die("error while getting the data : " . mysqli_query($conn));
        if(mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);
            if(sha1($password) == $row['password'])
            {
                setcookie("username",$username,60*60);
                setcookie("user_id",$row['user_id'],60*60);
                $_SESSION['username'] = $username;
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
    mysqli_close($conn);
?>