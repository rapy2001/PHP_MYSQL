<?php
    require_once("./includes/connection.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With");
    $data = json_decode(file_get_contents("php://input"),true);
    if(empty($data['movieId']) || empty($data['userId']))
    {
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $movieId = $data['movieId'];
        $userId= $data['userId'];
        $sql = "SELECT * FROM reviews WHERE movie_id = $movieId AND user_id = $userId";
        $result = mysqli_query($conn,$sql) or die("Error while querying the database");
        if(mysqli_num_rows($result) > 0)
        {
            echo json_encode(array("flg"=>1));
        }
        else
        {
            echo json_encode(array("flg"=>2));
        }
    }
?>