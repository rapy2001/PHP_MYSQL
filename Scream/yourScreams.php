<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/loader.php");
    require_once("./includes/nav.php");
    if(!empty($_SESSION['user_id']))
    {
        $msg = '';
        if(!empty($_GET['scream_id']))
        {
            $screamObj = new Scream();
            $scream = $screamObj->getScream($_GET['scream_id']);
            if($scream['user_id'] == $_SESSION['user_id'])
            {
                $screamObj->deleteScream($_GET['scream_id']);
                header('Refresh:3;url="yourScreams.php"');
                $msg = 'Scream deleted successfully';
            }
            else
            {
                $msg = 'You don\'t have the permission to delete this scream';
            }
        }
        $obj = new Scream();
        $screams = $obj->getUserScreams($_SESSION['user_id']);
        if(count($screams) > 0)
        {
            ?>
            <div>
                <?php
                if(!empty($msg))
                {
                    echo '<h4>'.$msg.'</h4>';
                }
                foreach($screams as $scream)
                {
    ?>
                    <div>
                        <a href = "updateScream.php?scream_id=<?php echo $scream['scream_id'];?>">Update Scream</a>
                        <a href = "yourScreams.php?scream_id=<?php echo $scream['scream_id'];?>">Delete Scream</a>
                        <img src = "<?php echo $scream['scream_image']; ?>" alt = "error"/>
                        <h2>
                            <?php echo $scream['Scream_text']; ?>
                        </h2>
                        <h4>
                            Posted On:
                            <?php
                                echo substr($scream['created_at'],0,10);
                            ?>
                        </h4>
                        <a href = "viewScream.php?scream_id=<?php echo $scream['scream_id'];?>">View Scream</a>
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
                <h4>No screams yet</h4>
            </div>
<?php
        }
    }
    else
    {
?>
        <div>
            <h4>You need to Log In to view your Screams</h4>
        </div>
<?php
    }
    require_once("./includes/footer.php");

?>