<?php
    require_once("./includes/connection.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With");
    $data = json_decode(file_get_contents("php://input"),true);
    if(empty($data['reviewId']) || empty($data['reviewText']) || empty($data['rating']) || empty($data['movieId']))
    {
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $reviewText = $data['reviewText'];
        // $userId = $data['userId'];
        $movieId = $data['movieId'];
        $rating = $data['rating'];
        $reviewId = $data['reviewId'];
        $query = "UPDATE reviews SET reviewText = '$reviewText', rating = $rating WHERE review_id = $reviewId";
        if(mysqli_query($conn,$query))
        {
            $sql = "SELECT reviews.review_id,reviews.reviewText, reviews.rating, users.username FROM reviews inner join users ON reviews.user_id = users.user_id WHERE reviews.review_id = $reviewId";
            $result = mysqli_query($conn,$sql) or die("Error while querying the database");
            if(mysqli_num_rows($result) > 0)
            {
                $review = mysqli_fetch_assoc($result);
                $sql = "SELECT avg(rating) as rating FROM reviews WHERE movie_id = $movieId";
                $result = mysqli_query($conn,$sql) or die("Error while querying the database");
                $row = mysqli_fetch_assoc($result);
                $rating = $row['rating'];
                $sql = "UPDATE movies SET rating = $rating WHERE movie_id=$movieId";
                mysqli_query($conn,$sql) or die("Error while querying the database");
                echo json_encode(array("flg"=>1,"review"=>$review,"data"=>$rating));
            }
            else
            {
                echo json_encode(array("flg"=>-3));
            }
            
        }
        else
        {
            echo json_encode(array("flg"=>-2,"data"=>$data));
        }
        
        
    }
    mysqli_close($conn);
?>