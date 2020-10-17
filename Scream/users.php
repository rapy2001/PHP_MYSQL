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
        ?>
        <div>
            <h4 class = "scs_msg"></h4>
            <h4 class = "err_msg"></h4>
        <?php
        if(count($users) > 0)
        {
            foreach($users as $user)
            {
                $block_obj = new Block();
                $blk_1 = $block_obj->getBlockStatus($user['user_id'],$_SESSION['user_id']);
                $blk_2 = $block_obj->getBlockStatus($_SESSION['user_id'],$user['user_id']);
                if($blk_1 == 0 && $blk_2 == 0 && $_SESSION['user_id'] != $user['user_id'])
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
                            <a href = "profile.php?user_id=<?php echo $user['user_id']; ?>">View Profile</a>
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
                                if($flg_1 == 1 && $_SESSION['user_id'] != $user['user_id'])
                                {
                                    ?>
                                        <button class = "blk_btn" data-id = "<?php echo $user['user_id']; ?>">Block</button>
                                    <?php
                                }
?>
                        </div>
                                <?php
                }
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
        ?>
        </div>
        <?php
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
    <footer>
        <a href = "about.php">2020. Rajarshi Saha</a>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(()=>{
            $('.scs_msg').hide();
            $('.err_msg').hide();
            $(document).on("click",".blk_btn",function(){
                let blockId = $(this).data("id");
                let userId = <?php echo $_SESSION['user_id'];?>;
                let blockedUser = this;
                $.ajax({
                    url:'blockUser.php',
                    type:'POST',
                    data:{userId:userId,blockId:blockId},
                    success:function(data)
                    {
                        if(data == -2)
                        {
                            $('.err_msg').html('No User selected on behalf of whom Block needs to be performed').show();
                            $('.scs_msg').hide();
                        }
                        else if(data == -1)
                        {
                            $('.err_msg').html('You can not block your Friend. Please Unfriend the User first before blocking').show();
                            $('.scs_msg').hide();
                        }
                        else if(data == 0)
                        {
                            $('.err_msg').html('You have already blocked this User').show();
                            $('.scs_msg').hide();
                        }
                        else if(data == 1)
                        {
                            $('.scs_msg').html('The user was blocked').show();
                            $('.err_msg').hide();
                            $(blockedUser).closest('div').slideUp();
                        }

                    }
                })
            });
        });
    </script>
    </body>
</html>