<?php
    require_once("./includes/connection.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With");
    $data = json_decode(file_get_contents("php://input"),true);
    if(empty($data['movieId']) || empty($data['page_num']))
    {
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $movieId = $data['movieId'];
        $sql = "SELECT * FROM reviews WHERE movie_id = $movieId";
        $result = mysqli_query($conn,$sql) or die("Error while querying the database");
        $limit = 2;
        $total = ceil(mysqli_num_rows($result)/$limit);
        $skip = ($data['page_num'] - 1) * $limit;
        $sql = "SELECT reviews.user_id, reviews.review_id, reviews.reviewText, reviews.rating, users.username FROM reviews inner join users ON reviews.user_id = users.user_id WHERE reviews.movie_id = $movieId LIMIT $skip,$limit";
        $result = mysqli_query($conn,$sql) or die("Error while querying the database");
        if(mysqli_num_rows($result) > 0)
        {
            $reviews = [];
            while($row = mysqli_fetch_assoc($result))
            {
                $reviews[] = $row;
            }
            echo json_encode(array("flg"=>1,"reviews"=>$reviews,"page_num"=>$data['page_num'] + 1));
        }
        else
        {
            echo json_encode(array("flg"=>-2));
        }
    }
    mysqli_close($conn);
?>