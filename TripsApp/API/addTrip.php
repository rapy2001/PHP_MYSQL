<?php

    require_once("./includes/autoload.php");
    header('Content-Type:application/json');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With');
    $tripName = empty($_POST['trip_name']) ? '' : $_POST['trip_name'];
    $tripPrice = empty($_POST['trip_price']) ? '' : $_POST['trip_price'];
    $tripDescription = empty($_POST['trip_description']) ? '' : $_POST['trip_description'];
    $tripImage = empty($_FILES['image']['name']) ? 'https://images.unsplash.com/photo-1554629947-334ff61d85dc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=676&q=80' : $_FILES['image']['name'];

    if(empty($tripName) || empty($tripPrice) || empty($tripDescription))
    {
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $trip = new trip();
        if(!empty($tripImage))
        {
            $ext = explode('.',$tripImage);
            $ext = $ext[count($ext) - 1];
            $valid = array("gif","jpeg","png","jpg");
            if(in_array($ext,$valid))
            {
                if($_FILES['image']['size'] > 5000000)
                {
                    echo json_encode(array("flg"=>-5));
                }
                else
                {
                    $time = time();
                    $path = "D:/html/xampp/htdocs/projects/TripsApp/APP/public/IMAGES/" . "trip" . '_' . $time . '.' . $ext;
                    if(move_uploaded_file($_FILES['image']['tmp_name'],$path))
                    {
                        $path = "../public/IMAGES/" . "trip" . '_' . $time . '.' . $ext;
                        $flg = $trip->insert_trip($tripName,$tripDescription,$tripPrice,$path);
                        if($flg == -1)
                        {
                            echo json_encode(array("flg"=>-2));
                        }
                        else if($flg == 0)
                        {
                            echo json_encode(array("flg"=>-3));
                        }
                        else if($flg == 1)
                        {
                            echo json_encode(array("flg"=>1));
                        }
                    }
                    else
                    {
                        echo json_encode(array("flg"=>-6));
                    }
                }
            }
            else
            {
                echo json_encode(array("flg"=>-4));
            }
            @unlink($_FILES['image']['tmp_name']);
        }
        else
        {
            $flg = $trip->insert_trip($tripName,$tripDescription,$tripPrice,$path);
            if($flg == -1)
            {
                echo json_encode(array("flg"=>-2));
            }
            else if($flg == 0)
            {
                echo json_encode(array("flg"=>-3));
            }
            else if($flg == 1)
            {
                echo json_encode(array("flg"=>1));
            }
        }
        
    }
?>