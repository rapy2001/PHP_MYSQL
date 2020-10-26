<?php
    require_once("./includes/connection.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With");
    $data = json_decode(file_get_contents("php://input"),true);
    $movieName = empty($data['name']) ? '' :$data['name'];
    $year = empty($data['year']) ? '' : $data['year'];
    $description = empty($data['description']) ? '': $data['description'];
    $genre = empty($data['genre']) ? '':$data['genre'];
    $director = empty($data['director']) ? '' : $data['director'];

    if(empty($movieName) || empty($year) || empty($genre) || empty($description) || empty($director))
    {
        echo json_encode(array("flg"=>-1,"data"=>$data));
    }
    else
    {
        $sql = "SELECT * FROM movies WHERE name = '$movieName'";
        $result = mysqli_query($conn,$sql) or die("error while querying the database");
        if(mysqli_num_rows($result) > 0)
        {
            echo json_encode(array("flg"=>-2));
        }
        else
        {
            $sql = "INSERT INTO movies(name,year,description,genre,director) VALUES ('$movieName','$year','$description',$genre,'$director')";
            if(mysqli_query($conn,$sql))
            {
                $sql = "SELECT * FROM movies WHERE name = '$movieName'";
                $result = mysqli_query($conn,$sql) or die("Error while querying the database");
                $row = mysqli_fetch_assoc($result);
                echo json_encode(array("flg"=>1,"movie_id"=>$row['movie_id']));
            }
            else
            {
                echo json_encode(array("flg"=>-3));
            }
        }
    }
    mysqli_close($conn);
?>