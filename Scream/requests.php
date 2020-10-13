<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    require_once("./includes/loader.php");
    $msg = '';
    if(!empty($_SESSION['user_id']))
    {
        $obj = new User();
        $users = $obj->getAllRequests($_SESSION['user_id']);
        if(!empty($_GET['friend_id']))
        {
            $flg = $obj->checkFriendshipStatus($_SESSION['user_id'],$_GET['friend_id']);
            if($flg == 0)
            {
                header('Refresh:3;url="requests.php"');
                $msg = 'You are already friends';
            }
            else
            {
                $obj->acceptFriendRequest($_SESSION['user_id'],$_GET['friend_id']);
                header('Refresh:3;url="requests.php"');
                $msg = 'You and '.$_GET['friendName'].' are now friends';
            }
        }
?>
        <div>
<?php
        if(!empty($msg))
        {
            echo '<h4>'.$msg.'</h4>';
        }
        if(count($users) > 0)
        {
            foreach($users as $user)
            {
                // $flg = $obj->checkRequestStatus($_SESSION['user_id'],$user['user_id']);
?>
                <div>
                    <img src = "<?php echo $user['imageUrl']; ?>" alt = "error"/>
                    <h2>
                        <?php
                            echo $user['username'];
                        ?>
                    </h2>
                    <a href = "requests.php?friend_id=<?php echo $user['user_id']; ?>&friendName=<?php echo $user['username'];?>">Accept Friend Request</a>
                </div>
<?php
            }
?>
<?php
        }
        else
        {
?>
            <div>
                <h4>No Friend Requests Yet ...</h4>
            </div>
<?php
        }
?>
        </div>
<?php
    }
    else
    {
?>
        <div>
            <h4>Please Log In to view your Friend Request</h4>
        </div>
<?php
    }
    require_once("./includes/footer.php");
?>