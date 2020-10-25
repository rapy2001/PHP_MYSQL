<?php
    require_once("./includes/connection.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With");
    $data = json_decode(file_get_contents("php://input"),true);
    if(empty($data['movieId']) || empty($data['reviewText']) || empty($data['rating']) || empty($data['userId']))
    {
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $reviewText = $data['reviewText'];
        $userId = $data['userId'];
        $movieId = $data['movieId'];
        $rating = $data['rating'];
        $query = "SELECT * FROM reviews WHERE movie_id = $movieId AND user_id = $userId";
        $result = mysqli_query($conn,$query) or die("Error while querying the database");
        if(mysqli_num_rows($result) > 0)
        {
            echo json_encode(array("flg"=>-4));
        }
        else
        {
            $query = "INSERT INTO reviews VALUES(0,$movieId,$userId,'$reviewText',$rating)";
            if(mysqli_query($conn,$query))
            {
                $query = "select avg(rating) as rating from reviews where movie_id = $movieId";
                $result = mysqli_query($conn,$query) or die("Error while querying the database for more ratings");
                $row = mysqli_fetch_assoc($result);
                $rating = $row['rating'];
                $query = "UPDATE movies SET rating = $rating WHERE movie_id=$movieId";
                if(mysqli_query($conn,$query))
                {
                    $query = "SELECT reviews.reviewText, reviews.rating, users.username FROM reviews inner join users ON reviews.user_id = users.user_id WHERE reviews.movie_id = $movieId";
                    $result = mysqli_query($conn,$query) or die("Error while querying the database");
                    if(mysqli_num_rows($result) > 0)
                    {
                        $row = mysqli_fetch_assoc($result);
                        echo json_encode(array("flg"=>1,"review"=>$row,"rating"=>$rating));
                    }
                    else
                    {
                        echo json_encode(array("flg"=>-3));
                    }
                }
                else
                {
                    echo json_encode(array("flg"=>-5));
                }
                
            }
            else
            {
                echo json_encode(array("flg"=>-2));
            }
        }
        
    }
    mysqli_close($conn);
?>