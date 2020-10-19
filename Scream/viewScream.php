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
                if(!empty($_GET['notif_id']))
                {
                    $notifObj = new Notification();
                    $notifObj->changeStatus($_GET['notif_id']);
                }
                if(!empty($_GET['postLikeId']))
                {
                    $obj = new Like();
                    $likeId = $obj->addLike($_SESSION['user_id'],$_GET['postLikeId'],1,-1);
                    $screamId = $_GET['scream_id'];
                    $obj = new Scream();
                    $screamtData = $obj->getScream($_GET['scream_id']);
                    $obj = new Notification();
                    $obj->addNotification($screamtData['user_id'],$likeId,3);
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
                    $likeId = $obj->addLike($_SESSION['user_id'],$_GET['commentLikeId'],2,$_GET['scream_id']);
                    $screamId = $_GET['scream_id'];
                    $obj = new Comment();
                    $commentData = $obj->getCommentWithId($_GET['commentLikeId']);
                    $obj = new Notification();
                    $obj->addNotification($commentData['user_id'],$likeId,3);
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
                    <div class = "viewScream">
                        <?php
                            if(!empty($msg))
                            {
                                echo '<h4>'.$msg.'</h4>';
                            }
                        ?>
                        <div class = "user_box">
                            <img src = "<?php echo $scream_owner['imageUrl']; ?>" alt = "error"/>
                            <div class = "user_box_info">
                                <h3><?php echo $scream_owner['username']; ?></h3>
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
                        <div class = "scream_like">
                            <?php
                                $obj = new Like();
                                $likes = $obj->getLikeCount($scream['scream_id'],1);
                            ?>
                            <h4>
                                <i class = "fa fa-heart"></i>
                                <?php
                                    echo $likes;
                                ?>
                            </h4>
                            <?php
                                $obj_1 = new Like();
                                $flg = $obj_1->checkLikeStatus($_SESSION['user_id'],$scream['scream_id'],1);
                                if($flg == 0)
                                {
                            ?>
                                    <a  class = "light" href = "viewScream.php?postLikeId=<?php echo $scream['scream_id'];?>&scream_id=<?php echo $scream['scream_id'];?>"><i class = "fa fa-heart"></i></a>
                            <?php
                                }
                                else
                                {
                            ?>
                                    <a class = "dark" href = "viewScream.php?postUnlikeId=<?php echo $scream['scream_id'];?>&scream_id=<?php echo $scream['scream_id'];?>">Liked</i></a>
                            <?php
                                }
                            ?>
                        </div>
                        
                        <!-- <div>
                            
                        </div> -->
                        <div class = "scream_comments">
                            <h3>Comments</h3>
                            <a href = "createComment.php?scream_id=<?php echo $scream['scream_id'];?>" class = "btn">Add a Comment</a>
                            <?php
                                $obj_4 = new Comment();
                                $comments = $obj_4->getAllScreamComments($scream['scream_id']);
                                if(count($comments) > 0)
                                {
                                    foreach($comments as $comment)
                                    {
                                        $obj = new User();
                                        $commentUser = $obj->getUserWithId($comment['user_id']);
            ?>
                                        <?php
                                                $obj_5 = new User();
                                                $user = $obj_5->getUserWithId($comment['user_id'])
                                        ?>
                                        <div class = "comment user_card">
                                            <div class = "comment_user">
                                                <img src = "<?php echo $commentUser['imageUrl']; ?>" alt = "error" />
                                                <?php
                                                    $obj = new Like();
                                                    $likes = $obj->getLikeCount($comment['comment_id'],2);
                                                ?>
                                                <div class = "comment_user_info">
                                                    <h4><b><?php echo $user['username'];?></b></h4>
                                                    <h3><?php echo $comment['comment_text'];?></h3>
                                                    <div class = "comment_time">
                                                        <h5> <?php echo substr($comment['created_at'],0,10); ?>  <?php echo substr($comment['created_at'],11,5);?></h5>
                                                        
                                                    </div>

                                                </div>
                                            </div>
                                            <div class = "comment_manipulate">
                                                <?php
                                                    if($comment['user_id'] == $_SESSION['user_id'])
                                                    {
                                                ?> 
                                                        <a class = "danger" href = "viewScream.php?deleteCommentId=<?php echo $comment['comment_id']; ?>&scream_id=<?php echo $_GET['scream_id']; ?>">Delete</a>
                                                        <a class = "process" href = "updateComment.php?updateCommentId=<?php echo $comment['comment_id']; ?>&scream_id=<?php echo $_GET['scream_id']; ?>">Update</a>
                                                <?php
                                                    } 
                                                ?>
                                                <?php
                                                    $obj = new Like();
                                                    $flg = $obj->checkLikeStatus($_SESSION['user_id'],$comment['comment_id'],2);
                                                    if($flg == 0)
                                                    {
                                                ?>
                                                        <a class = "dark" href = "viewScream.php?commentLikeId=<?php echo $comment['comment_id'];?>&scream_id=<?php echo $scream['scream_id'];?>"><i class = "fa fa-heart"></i> <?php echo $likes;?></a>
                                                <?php
                                                    }
                                                    else
                                                    {
                                                ?>
                                                        <a class = "light" href = "viewScream.php?commentUnlikeId=<?php echo $comment['comment_id'];?>&scream_id=<?php echo $scream['scream_id'];?>"> Liked &nbsp; <i class = "fa fa-heart"></i> <?php echo $likes;?> </a>
                                                <?php
                                                    }
                                                ?>
                                                
                                            </div>
                                        </div>
            <?php
                                    }
                                ?>
                                <?php
                                }
                                else
                                {
?>
                                    <div class = "empty">
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
                    <div class = "empty">
                        <h4>You are not authorzed to View this Scream</h4>
                    </div>
        <?php
                }
            }
            else
            {
                header('Refresh:3;url=feed.php');
        ?>
                <div class = "empty">
                    <h4>No Scream selected</h4>
                </div>
        <?php
            }
    }
    else
    {
        header('Refresh:3;url=feed.php');
?>
        <div class = "empty">
            You need to Log In to view this Scream
        </div>
<?php
    }
?>
<?php
    require_once("./includes/footer.php");
?>