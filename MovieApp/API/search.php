<?php
    require_once("./includes/connection.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With");
    $data = json_decode(file_get_contents("php://input"),true);
    if(empty($data['searchTerm']))
    {
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $searchTerm = $data['searchTerm'];
        $ary = explode(" ",$searchTerm);
        for($i = 0;$i<count($ary);$i++)
        {
            if($ary[$i] == '.' || $ary[$i] == '@' || $ary[$i] == '!' || $ary[$i] == '#' || $ary[$i] == '_')
            {
                array_shift($ary);
            }
        }
        $sql = "SELECT * FROM movies WHERE name";
        for($i = 0;$i<count($ary);$i++)
        {
            if($i != count($ary) -1)
                $sql.=" LIKE '%$ary[$i]%' OR";
            else
                $sql.=" LIKE '%$ary[$i]%';";
        }
        $result = mysqli_query($conn,$sql) or die("Error while querying the database");
        if(mysqli_num_rows($result) > 0)
        {
            $ary = [];
            while($row = mysqli_fetch_assoc($result))
            {
                $ary[] = $row;
            }
            echo json_encode(array("flg"=>1,"movies"=>$ary));
        }
        else
        {
            echo json_encode(array("flg"=>-2));
        }
    }
    mysqli_close($conn);
?>