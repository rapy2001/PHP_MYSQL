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
                if(!empty($_GET['postLikeId']))
                {
                    $obj = new Like();
                    $obj->addLike($_SESSION['user_id'],$_GET['postLikeId'],1,-1);
                    $screamId = $_GET['scream_id'];
                    header("Refresh:3;url=\"viewScream.php?scream_id=$screamId\"");
                    $msg = 'Like added Successfully';
                }
                if(!empty($_GET['postUnlikeId']))
                {
                    $obj = new Like();
                    $obj->deleteLike($_SESSION['user_id'],$_GET['postUnlikeId'],1,-1);
                    $screamId = $_GET['scream_id'];
                    header("Refresh:3;url=\"viewScream.php?scream_id=$screamId\"");
                    $msg = 'Like deleted Successfully';
                }
                if(!empty($_GET['commentLikeId']))
                {
                    $obj = new Like();
                    $obj->addLike($_SESSION['user_id'],$_GET['commentLikeId'],2,$_GET['scream_id']);
                    $screamId = $_GET['scream_id'];
                    header("Refresh:3;url=\"viewScream.php?scream_id=$screamId\"");
                    $msg = 'Like added to the comment Successfully';
                }
                if(!empty($_GET['commentUnlikeId']))
                {
                    $obj = new Like();
                    $obj->deleteLike($_SESSION['user_id'],$_GET['commentUnlikeId'],2);
                    $screamId = $_GET['scream_id'];
                    header("Refresh:3;url=\"viewScream.php?scream_id=$screamId\"");
                    $msg = 'Like deleted from comment Successfully';
                }
                if(!empty($_GET['deleteCommentId']))
                {
                    $screamId = $_GET['scream_id'];
                    $obj_6 =  new Comment();
                    $comment = $obj_6->getCommentWithId($_GET['deleteCommentId']);
                    $screamId = $_GET['scream_id'];
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
                            <?php
                                $obj = new Like();
                                $likes = $obj->getLikeCount($scream['scream_id'],1);
                            ?>
                            <h4>
                                Likes:
                                <?php
                                    echo $likes;
                                ?>
                            </h4>
                        </div>
                        <?php
                            $obj_1 = new Like();
                            $flg = $obj_1->checkLikeStatus($_SESSION['user_id'],$scream['scream_id'],1);
                            if($flg == 0)
                            {
                        ?>
                                <a href = "viewScream.php?postLikeId=<?php echo $scream['scream_id'];?>&scream_id=<?php echo $scream['scream_id'];?>">Like</a>
                        <?php
                            }
                            else
                            {
                        ?>
                                <a href = "viewScream.php?postUnlikeId=<?php echo $scream['scream_id'];?>&scream_id=<?php echo $scream['scream_id'];?>">Liked</a>
                        <?php
                            }
                        ?>
                        <div>
                            
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
                                                $obj = new Like();
                                                $likes = $obj->getLikeCount($comment['comment_id'],2);
                                            ?>
                                            <h5>Likes: <?php echo $likes;?></h5>
                                            <?php
                                                $obj = new Like();
                                                $flg = $obj->checkLikeStatus($_SESSION['user_id'],$comment['comment_id'],2);
                                                if($flg == 0)
                                                {
                                            ?>
                                                    <a href = "viewScream.php?commentLikeId=<?php echo $comment['comment_id'];?>&scream_id=<?php echo $scream['scream_id'];?>">Like</a>
                                            <?php
                                                }
                                                else
                                                {
                                            ?>
                                                    <a href = "viewScream.php?commentUnlikeId=<?php echo $comment['comment_id'];?>&scream_id=<?php echo $scream['scream_id'];?>">Liked</a>
                                            <?php
                                                }
                                            ?>
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