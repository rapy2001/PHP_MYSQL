<?php
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Methos,Content-Type,Authorization,X-Requested-With");
    require_once("./includes/connection.php");
    $userId = empty($_POST['userId']) ? '' : $_POST['userId'];
    if($userId != '')
    {
        $query = "SELECT city,imageUrl FROM users WHERE user_id = $userId";
        $result = mysqli_query($conn,$query) or die("Error while querying the database");
        if(mysqli_num_rows($result) > 0)
        {
            $userData = mysqli_fetch_all($result,MYSQLI_ASSOC);
            $userData = json_encode($userData);
            echo $userData;
        }
        else
        {
            echo json_encode(array("status"=>0));
        }
    }
    else
    {
        echo json_encode(array("status"=>0));
    }
    mysqli_close($conn);
?>