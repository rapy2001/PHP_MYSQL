<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    require_once("./includes/loader.php");
    $obj = new User();
    $users = $obj->getAllUsers();
    $msg = '';
?>
<div>
<?php
    if(!empty($_GET['user_id']) && $_SESSION['user_id'] != $_GET['user_id'])
    {
        $flg_1 = $obj->checkFriendshipStatus($_GET['user_id'],$_SESSION['user_id']);
        $flg_2 = $obj->checkRequestStatus($_GET['user_id'],$_SESSION['user_id']);
        if($flg_1 == 0)
        {
            header('Refresh:3;url="users.php"');
            $msg = 'You are already friends';
        }
        else if($flg_2 == 0)
        {
            header('Refresh:3;url="users.php"');
            $msg = 'You have already sent a friend Request';
        }
        else
        {
            $obj->addFriendRequest($_GET['user_id'],$_SESSION['user_id']);
            header('Refresh:3;url="users.php"');
            $msg = 'Friend Request sent';
        }
    }
    if(!empty($msg))
    {
        echo '<h4>'.$msg.'</h4>';
    }
?>
<?php
    if(!empty($_SESSION['username']))
    {
        if(count($users) > 0)
        {
            foreach($users as $user)
            {
                $flg_1 = $obj->checkFriendshipStatus($user['user_id'],$_SESSION['user_id']);
                $flg_2 = $obj->checkRequestStatus($user['user_id'],$_SESSION['user_id']);
                $flg_3 = $obj->checkRequestStatus($_SESSION['user_id'],$user['user_id']);
                
?>
                    <div>
                        <img src = "<?php echo $user['imageUrl']; ?>" alt = "error"/>
                        <h2>
                            <?php
                                echo $user['username'];
                            ?>
                        </h2>
<?php
                            if($flg_1 == 1 && $flg_2 == 1 && $flg_3 == 1 && $_SESSION['user_id'] != $user['user_id'])
                            {
?>
                                <a href ="users.php?user_id=<?php echo $user['user_id']; ?>">Send Friend Request</a>
<?php
                            }
                            if($flg_3 == 0)
                            {
?>
                                <a href ="requests.php">Has Sent you a Friend Request</a>
<?php
                            }
                            if($flg_2 == 0)
                            {
?>
                                <h4>Friend Request Sent</h4>
<?php
                            }
?>

                        <?php
                        ?>
                    </div>
<?php
                
                
            }
        }
        else
        {
?>
            <div>
                <h4>No Users Yet</h4>
            </div>
<?php
        }
    }
    else
    {
        header('Refresh:3;url="login.php"');
?>
        <div>
            <h4>Please Log In to View the users</h4>
        </div>
<?php
    } 
?>
</div>
<?php
    require_once("./includes/footer.php");
?>