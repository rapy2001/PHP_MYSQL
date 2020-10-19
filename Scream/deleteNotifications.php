<?php
    require_once("./includes/connection.php");
    $owner = empty($_POST['ownerId']) ? '' :$_POST['ownerId'];
    if($owner == '')
    {
        echo 0;
    }
    else
    {
        $sql = "DELETE FROM notifications WHERE owner_id = {$owner}";
        if(mysqli_query($conn,$sql))
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    }
?>