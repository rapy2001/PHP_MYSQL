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
            foreach($friendsScreams as $scream)
            {
                $user = new User();
                $details = $user->getUserWithId($scream['user_id']);
?>
                <div>
                    <div>
                        <img src ="<?php echo $details['imageUrl'];?>" alt = "error"/>
                        <h3><?php echo $details['username'];?></h3>
                        <h4>
                            Posted On:
                            <?php
                                echo substr($scream['created_at'],0,10);
                            ?>
                        </h4>
                    </div>
                    <img src = "<?php echo $scream['scream_image']; ?>" alt = "error"/>
                    <h2>
                        <?php echo $scream['Scream_text']; ?>
                    </h2>
                    <a href = "viewScream.php?scream_id=<?php echo $scream['scream_id'];?>">View Scream</a>
                </div>
<?php
            }
        }
        else
        {
?>
            <div>
                Your Feed is Empty ...
            </div>
<?php
        }
    }
    else
    {
?>
        <div>
            <h4>You need to Log In to get Your feed.</h4>
        </div>
<?php
    }
    require_once("./includes/footer.php");
?>