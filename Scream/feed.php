<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/loader.php");
    require_once("./includes/nav.php");
    if(!empty($_SESSION['user_id']))
    {
        $obj = new Scream();
        $friendsScreams = $obj->getFriendsScreams($_SESSION['user_id']);
        if(count($friendsScreams) > 0)
        {
            ?>
            <div class = "feed">
                <h1>Your Feed</h1>
            <?php
            foreach($friendsScreams as $scream)
            {
                $user = new User();
                $details = $user->getUserWithId($scream['user_id']);
?> 
                <div class = "feed feed_box">
                    <div class = "user_box">
                        <img src ="<?php echo $details['imageUrl'];?>" alt = "error"/>
                        <div class = "user_box_info">
                            <h3><?php echo $details['username'];?></h3>
                            <h4>
                                On: <b><?php echo substr($scream['created_at'],0,10); ?></b> 
                                at: <b><?php echo substr($scream['created_at'],11,5);?> </b>
                            </h4>
                        </div>
                    </div>
                    <div class = "scream_img">
                        <img src = "<?php echo $scream['scream_image']; ?>" alt = "error"/>
                    </div>
                    <p class = "scream_text">
                        <?php echo $scream['Scream_text']; ?>
                    </p>
                    <a class = "btn" href = "viewScream.php?scream_id=<?php echo $scream['scream_id'];?>">View Scream</a>
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
            <div class = "empty">
                Your Feed is Empty ...
            </div>
<?php
        }
    }
    else
    {
?>
        <div class = "empty">
            <h4>You need to Log In to get Your feed.</h4>
        </div>
<?php
    }
    require_once("./includes/footer.php");
?>