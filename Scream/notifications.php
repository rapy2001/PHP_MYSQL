<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/loader.php");
    require_once("./includes/nav.php");
    if(!empty($_SESSION['user_id']))
    {
        $obj = new Notification();
        $notifications =$obj->getAllUserNotifications($_SESSION['user_id']);
        if(count($notifications) > 0)
        {
?>
            <div class = "notifications">
                <h1>Your Notifications</h1>
<?php
                foreach($notifications as $notification)
                {
                    if($notification['type'] == 1)
                    {
                        $obj = new Scream();
                        $screamData = $obj->getScream($notification['scream_id']);
                        $obj = new User();
                        $friendData = $obj->getUserWithId($screamData['user_id']);
                        ?>
                        <div class = 'user_card'>
                            <h4><i class = "fa fa-plus"></i></h4>
                            <img src = "<?php echo $friendData['imageUrl']?>" alt = "error"/>
                            <h2><?php echo $friendData['username'];?> added a Scream</h2>
                            <a href = "viewScream.php?scream_id=<?php echo $screamData['scream_id']; ?>" class = "btn">View</a>
                        </div>
                        <?php
                    }
                    else if($notification['type'] == 2)
                    {
                        $obj = new Comment();
                        $commentData = $obj->getCommentWithId($notification['comment_id']);
                        $obj = new User();
                        $friendData = $obj->getUserWithId($commentData['user_id']);
                        ?>
                        <div class = 'user_card'>
                            <h4><i class = "fa fa-sticky-note"></i></h4>
                            <img src = "<?php echo $friendData['imageUrl']?>" alt = "error"/>
                            <h2><?php echo $friendData['username'];?> added a comment to Your Scream</h2>
                            <a href = "viewScream.php?scream_id=<?php echo $commentData['scream_id']; ?>" class = "btn">View</a>
                        </div>
                    <?php
                    }
                    else if($notification['type'] == 3)
                    {
                        $obj = new Like();
                        $likeData = $obj->getLike($notification['like_id']);
                        $obj = new User();
                        $friendData = $obj->getUserWithId($likeData['user_id']);
                    ?>
                        <div class = 'user_card'>
                            <h4><i class = "fa fa-heart"></i></h4>
                            <img src = "<?php echo $friendData['imageUrl']?>" alt = "error"/>
                            <?php
                                if($likeData['comment_id'] == 7)
                                {
                                    ?>
                                    <h2><?php echo $friendData['username'];?> added a like to Your Scream</h2>
                                    <a href = "viewScream.php?scream_id=<?php echo $likeData['scream_id']; ?>" class = "btn">View</a>
                                    <?php
                                }
                                else
                                {
                                    $obj = new Comment();
                                    $commentData = $obj->getCommentWithId($likeData['comment_id']);
                                    ?>
                                    <h2><?php echo $friendData['username'];?> added a like to Your Comment</h2>
                                    <a href = "viewScream.php?scream_id=<?php echo $commentData['scream_id']; ?>" class = "btn">View</a>
                                    <?php
                                }
                            ?>
                            
                            <!-- <a href = "viewScream.php?scream_id=<?php echo $screamData['scream_id']; ?>">View</a> -->
                        </div>
                    <?php
                    }
                   
                }
?>
            </div>
<?php
        }
        else
        {
?>
            <div class = "empty">
                <h4>No Notifications Yet ...</h4>
            </div>
<?php
        }
    }
    else
    {
?>
        <div class = "empty">
            <h4>Please Log In to View Your Notifications</h4>
        </div>
<?php
    }
    require_once("./includes/footer.php");
?>