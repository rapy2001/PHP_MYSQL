<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/loader.php");
    require_once("./includes/nav.php");
    $msg = '';
    $commentText = empty($_POST['commentText']) ? '':mysqli_real_escape_string($conn,trim($_POST['commentText']));
    if(!empty($_SESSION['user_id']))
    {
        if(!empty($_GET['scream_id']))
        {
            if(!empty($_POST['submit']))
            {
                if(empty($commentText))
                {
                    $msg = 'The Comment Text can\'t be empty';
                }
                else
                {
                    $obj = new Scream();
                    $screamData = $obj->getScream($_GET['scream_id']);
                    $obj = new Comment();
                    $commentData = $obj->createComment($_SESSION['user_id'],$commentText,$_GET['scream_id']);
                    $screamId = $_GET['scream_id'];
                    $commentText = '';
                    $obj = new Notification();
                    $obj->addNotification($screamData['user_id'],$commentData['comment_id'],2);
                    header("Refresh:3;url=\"viewScream.php?scream_id=$screamId\"");
                    $msg = 'Comment Added';
                }
            }
?>
            <div>
                <?php
                    if(!empty($msg))
                    {
                        echo '<h4>'.$msg.'</h4>';
                    }
                ?>
                <form action = "createComment.php?scream_id=<?php echo $_GET['scream_id']; ?>" method = "POST">
                    <input type = "text" placeholder = "Comment Text" name = "commentText" value = "<?php if(!empty($commentText)) echo $commentText; ?>"/>
                    <input type = "submit" name = "submit"/>
                </form>
            </div>
<?php
        }
        else
        {
?>
            <div>
                <h4>No Scream to add Comment to</h4>
            </div>
<?php
        }
    }
    else
    {
?>
        <div>
            <h4>You need to Log In to add a Comment</h4>
        </div>
<?php
    }
    
    require_once("./includes/footer.php");
?>