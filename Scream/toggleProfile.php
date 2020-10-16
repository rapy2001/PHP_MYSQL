<?php
    require_once("./includes/session.php");
    require_once("./includes/loader.php");
    require_once("./includes/connection.php");
    if(!empty($_POST['userId']))
    {
        $obj = new User();
        $userData = $obj->getUserWithId($_POST['userId']);
        $query = '';
        $userId = $_POST['userId'];
        if($userData['mode'] == 'P')
        {
            $query = "UPDATE users SET mode = 'N' WHERE user_id = $userId";
        }
        else
        {
            $query = "UPDATE users SET mode = 'P' WHERE user_id = $userId";
        }
        if(mysqli_query($conn,$query))
        {
            echo '1';
        }
        else
        {
            echo '0';
        }
    }
    else
    {
        echo '0';
    }
?>