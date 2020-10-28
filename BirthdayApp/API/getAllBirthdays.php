<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With");
    $data = json_decode(file_get_contents("php://input"),true);
    if(empty($data['userId']) || empty($data['num']))
    {
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $limit = 2;
        $skip = ($data['num'] - 1)*$limit;
        $userId = $data['userId'];
        $query = "SELECT * FROM birthdays WHERE user_id = $userId LIMIT $skip,$limit";
        $result = mysqli_query($conn,$query) or die("Error while getting the data : ".$query. mysqli_error($conn));
        if(mysqli_num_rows($result) > 0)
        {
            $birthdays = array();
            while($row = mysqli_fetch_assoc($result))
            {
                $birthdays[] = $row;
            }
            for($i = 0; $i<count($birthdays); $i++)
            {
                $val = $birthdays[$i]['birthday'];
                $age = (int)date('yy') - (int)substr($val,0,4);
                $birthdays[$i]['age'] = $age;
            }
            $query = "SELECT * FROM users WHERE user_id = $userId";
            $result = mysqli_query($conn,$query) or die("Error while querying the database : ". mysqli_error($conn));
            $userData = mysqli_fetch_assoc($result);
            echo json_encode(array("flg"=>1,"birthdays"=>$birthdays,"userData"=>$userData,"pageNum"=>$data['num'] + 1));
        }
        else
        {
            $query = "SELECT * FROM users WHERE user_id = $userId";
            $result = mysqli_query($conn,$query) or die("Error while querying the database : ". mysqli_error($conn));
            $userData = mysqli_fetch_assoc($result);
            echo json_encode(array("flg"=>-2,"userData"=>$userData));
        }
    }
    mysqli_close($conn);
?>