<?php
    require_once("./includes/connection.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With");
    $data = json_decode(file_get_contents("php://input"),true);
    if(!empty($data['page_num']))
    {
        $sql = "SELECT * FROM movies";
        $result = mysqli_query($conn,$sql) or die("error while querying database");
        $limit = 2;
        $total = ceil(mysqli_num_rows($result)/$limit);
        $skip = ($data['page_num'] - 1) * $limit;
        $sql = "SELECT movies.movie_id,movies.name,movies.year,movies.description,movies.rating,movies.imageUrl,movies.director,genre.genre_name FROM movies inner join genre ON movies.genre = genre.genre_id LIMIT $skip,$limit";
        $result = mysqli_query($conn,$sql) or die("error while querying database");
        if(mysqli_num_rows($result) > 0)
        {
            $ary = array();
            while($row = mysqli_fetch_assoc($result))
            {
                $ary[] = $row;
            }
            echo json_encode(array("flg"=>1,"movies"=>$ary,"pageNum"=>$data['page_num'] + 1));
        }
        else
        {
            echo json_encode(array("flg"=>-2,"movies"=>[]));
        }
    }
    else
    {
        echo json_encode(array("flg"=>-1));
    }

?>