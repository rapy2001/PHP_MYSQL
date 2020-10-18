<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/loader.php");
    require_once("./includes/nav.php");
    if(!empty($_GET['scream_id']))
    {
        if(!empty($_SESSION['user_id']))
        {
            if(!empty($_GET['updateCommentId']))
            {
                $msg = '';
                
                $obj = new Comment();
                $comment = $obj->getCommentWithId($_GET['updateCommentId']);
                $commentText = $comment['comment_text'];
                
                if(!empty($_POST['submit']))
                {
                    $commentText = empty($_POST['commentText']) ? '':mysqli_real_escape_string($conn,trim($_POST['commentText']));
                    if($comment['user_id'] == $_SESSION['user_id'])
                    {
                        $screamId = $_GET['scream_id'];
                        $obj->updateComment($comment['comment_id'],$commentText);
                        header("Refresh:3;url=\"viewScream.php?scream_id=$screamId\"");
                        $msg = 'Comment Updated Successfully';
                    }
                    else
                    {
                        header("Refresh:3;url=\"viewScream.php?scream_id=$screamId\"");
?>
                        <div>
                            <h4>You are not authorized to Update this Comment</h4>
                        </div>
<?php
                    }
                }
?>
                <div class = "update_comment box">
                    <?php
                        if(!empty($msg))
                        {
                            echo '<h4>'.$msg.'</h4>';
                        }
                    ?>
                    <div class = "box_1">
                        <form action = "updateComment.php?scream_id=<?php echo $_GET['scream_id']; ?>&updateCommentId=<?php echo $_GET['updateCommentId']; ?>" method = "POST" class = "form">
                            <h3>Update Comment</h3>
                            <input type = "text" placeholder = "Comment Text" name = "commentText" value = "<?php if(!empty($commentText)) echo $commentText; ?>" />
                            <input type = "submit" name = "submit" value = "Update"/>
                        </form>
                    </div>
                    <div class = "box_2">

                    </div>
                    
                </div>
<?php
            }
            else
            {
                header("Refresh:3;url=\"viewScream.php?scream_id=$screamId\"");
?>
                <div>
                    <h4>No Comment to Update</h4>
                </div>
<?php
            }
        }
        else
        {
            $screamId = $_GET['scream_id'];
            header("Refresh:3;viewScream.php?url=\"scream_id=$screamId\"");
    ?>
            <div>
                <h4>You need to Log In in order to Update a Comment</h4>
            </div>
<?php
        }
    }
    else
    {
?>
        <div>
            <h4>No Scream to return to</h4>
        </div>
<?php
    }
    require_once("./includes/footer.php");
?>