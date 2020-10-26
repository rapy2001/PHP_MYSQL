<?php
    require_once("./includes/connection.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With");
    $data = json_decode(file_get_contents("php://input"),true);
    if(empty($data['reviewId']) || empty($data['movieId']))
    {
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $reviewId = $data['reviewId'];
        $movieId = $data['movieId'];
        $sql = "DELETE FROM reviews WHERE review_id = $reviewId";
        if(mysqli_query($conn,$sql))
        {
            $sql = "SELECT avg(rating) as rating FROM reviews WHERE movie_id = $movieId";
            $result = mysqli_query($conn,$sql) or die("Error while querying the database");
            $row = mysqli_fetch_assoc($result);
            $rating = $row['rating'];
            $rating = (float)$rating;
            $sql = "UPDATE movies SET rating = $rating WHERE movie_id = $movieId";
            if(mysqli_query($conn,$sql))
            {
                echo json_encode(array("flg"=>1,"data"=>$data,"rating"=>$rating));
            }
            else
            {
                echo json_encode(array("flg"=>-3,"rating"=>$rating));
            }
            
        }
        else
        {
            echo json_encode(array("flg"=>-2));
        }
    }
    mysqli_close($conn);
?>