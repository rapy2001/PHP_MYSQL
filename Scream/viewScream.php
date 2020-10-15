<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/loader.php");
    require_once("./includes/nav.php");
    if(!empty($_SESSION['user_id']))
    {
        if(!empty($_GET['scream_id']))
            {
                $msg = '';
                if(!empty($_GET['deleteCommentId']))
                {
                    $screamId = $_GET['scream_id'];
                    $obj_6 =  new Comment();
                    $comment = $obj_6->getCommentWithId($_GET['deleteCommentId']);
                    if($comment['user_id'] == $_SESSION['user_id'])
                    {
                        $obj_6->deleteComment($_GET['deleteCommentId']);
                        header("Refresh:3;url=\"viewScream.php?scream_id=$screamId\"");
                        $msg = 'Comment deleted Successfully';
                    }
                    else
                    {
                        header("Refresh:3;url=\"viewScream.php?scream_id=$screamId\"");
                        $msg = 'You are not authorized to delete this Comment';
                    }

                }
                $obj_1 = new Scream();
                $scream = $obj_1->getScream($_GET['scream_id']);
                $obj_2 = new User();
                $flg_1 = $scream['user_id'] == $_SESSION['user_id'];
                $flg_2 = $obj_2->checkFriendshipStatus($scream['user_id'],$_SESSION['user_id']);
                if($flg_1 || $flg_2 == 0)
                {
                    $obj_3 =  new User();
                    $scream_owner = $obj_3->getUserWithId($scream['user_id']);
        ?>
                    <div>
                        <?php
                            if(!empty($msg))
                            {
                                echo '<h4>'.$msg.'</h4>';
                            }
                        ?>
                        <div>
                            <img src = "<?php echo $scream_owner['imageUrl']; ?>" alt = "error"/>
                            <h3><?php echo $scream_owner['username']; ?></h3>
                        </div>
                        <div>
                            <img src = "<?php echo $scream['scream_image']; ?>" alt = "error"/>
                            <h4>Posted On: <?php echo substr($scream['created_at'],0,10); ?> at: <?php echo substr($scream['created_at'],11,15);?></h4>
                        </div>
                        <div>
                            <h3>Comments</h3>
                            <a href = "createComment.php?scream_id=<?php echo $scream['scream_id'];?>">Add a Comment</a>
                            <?php
                                $obj_4 = new Comment();
                                $comments = $obj_4->getAllScreamComments($scream['scream_id']);
                                if(count($comments) > 0)
                                {
                                    foreach($comments as $comment)
                                    {
            ?>
                                        <div>
                                            <h4><?php echo $comment['comment_text'];?></h4>
                                            <?php
                                                $obj_5 = new User();
                                                $user = $obj_5->getUserWithId($comment['user_id'])
                                            ?>
                                            <h5>Posted On: <?php echo substr($comment['created_at'],0,10); ?> at: <?php echo substr($comment['created_at'],11,15);?></h5>
                                            <h5>By: <?php echo $user['username'];?></h5>
                                            <?php
                                                if($comment['user_id'] == $_SESSION['user_id'])
                                                {
                                            ?> 
                                                    <a href = "viewScream.php?deleteCommentId=<?php echo $comment['comment_id']; ?>&scream_id=<?php echo $_GET['scream_id']; ?>">Delete</a>
                                                    <a href = "updateComment.php?updateCommentId=<?php echo $comment['comment_id']; ?>&scream_id=<?php echo $_GET['scream_id']; ?>">Update</a>
                                            <?php
                                                } 
                                            ?>
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
                                        <h4>No Comments Yet ...</h4>
                                    </div>
                                    <?php
                                }
                                ?>
                        </div>
                    </div>
        <?php

                }
                else
                {
                    header('Refresh:3;url=feed.php');
        ?>
                    <div>
                        <h4>You are not authorzed to View this Scream</h4>
                    </div>
        <?php
                }
            }
            else
            {
                header('Refresh:3;url=feed.php');
        ?>
                <div>
                    <h4>No Scream selected</h4>
                </div>
        <?php
            }
    }
    else
    {
        header('Refresh:3;url=feed.php');
?>
        <div>
            You need to Log In to view this Scream
        </div>
<?php
    }
?>
<?php
    require_once("./includes/footer.php");
?>