<?php
    require_once("./includes/session.php");
    require_once("./includes/vars.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    if(isset($_GET['id']))
    {
        $flw = 0;
        $id = $_GET['id'];
        $dlt = 0;
        $msg = '';
        $query="SELECT blogs.posted,blogs.views,blogs.blog_id,blogs.title, blogs.text,blogs.imageUrl,blogs.likes,categories.category_name,users.user_id,users.username,users.totalViews
        from categories inner join blogs using(category_id) inner join users using(user_id) where blogs.blog_id = $id";
        $result = mysqli_query($conn,$query) or die("Error while querying the database to get blog data");
        if(mysqli_num_rows($result) === 0)
        {
            header('Refresh:3;url=viewBlogs.php');
            echo '<div><h3>The Blog Does Not Exist.</h3></div>';
        }
        else
        {
                $row = mysqli_fetch_array($result);
                if(isset($_GET['delete']))
                {
                    if(isset($_SESSION['user_id']))
                    {
                        if($_SESSION['user_id'] == $row['user_id'])
                        {
                            $blgId = $row['blog_id'];
                            $query = "DELETE from comments where blog_id=$blgId";
                            mysqli_query($conn,$query) or die("Error while deleting the comments");
                            $uId=$row['user_id'];
                            $query = "SELECT totalViews from users where user_id=$uId";
                            $result = mysqli_query($conn,$query) or die("Error while querying the database for getting total Views");
                            $result = mysqli_fetch_array($result);
                            $totalViews = $result['totalViews'] - $row['views'];
                            $query = "UPDATE users set totalViews=$totalViews where user_id=$uId";
                            mysqli_query($conn,$query) or die("Error while querying the database for updating the total views during blog deletion");
                            $query = "DELETE from likes where blog_id=$blgId";
                            mysqli_query($conn,$query) or die("Error while deleting the likes associated with the blog");
                            $query = "DELETE FROM blogs where blog_id=$blgId";
                            mysqli_query($conn,$query) or die("Error while deleting the blog");
                            header('Refresh:3;url="homepage.php"');
                            echo '<h4 class = "success msg">Blog Deleted Successfully</h4>';
                            $dlt = 1;
                        }
                        else
                        {
                            echo '<h4 class = "error msg">You don\'t have the permission to delete the blog</h4>';
                        }
                    }
                    else
                    {
                        echo '<h4 class = "error msg">You don\'t have the permission to delete the blog</h4>';
                    }
                }
                if($dlt!=1)
                {
                    if(!empty($_GET['like']) && !empty($_SESSION['user_id']))
                    {
                        $like = $_GET['like'];
                        $uId = $_SESSION['user_id'];
                        $blogId = $row['blog_id'];
                        if($dlt != 1)
                        {
                            if($like === 'like')
                            {
                                $query = "SELECT * from likes where user_id=$uId AND blog_id=$blogId";
                                $result = mysqli_query($conn,$query) or die ("error while adding the like");   
                                if(mysqli_num_rows($result)>0)
                                {
                                    $msg = 'You have already liked this blog';
                                }
                                else
                                {
                                    $query = "INSERT INTO likes VALUES(0,$blogId,$uId)";
                                    mysqli_query($conn,$query) or die("Error while querying the database for adding the like");
                                    $newLikes = $row['likes'] + 1;
                                    $query = "UPDATE BLOGS SET likes=$newLikes where blog_id = $blogId";
                                    mysqli_query($conn,$query) or die("Error while updating the blogs data for likes");
                                    $query = "SELECT user_id from blogs where blog_id=$blogId";
                                    $result = mysqli_query($conn,$query) or die("Error while querying the database for getting the owner");
                                    $own = mysqli_fetch_array($result)['user_id'];
                                    $query = "SELECT like_id from likes where blog_id=$blogId AND user_id=$uId";
                                    $result = mysqli_query($conn,$query) or die("Error while querying the database for getting the like id");
                                    $likeId = mysqli_fetch_array($result)['like_id'];
                                    $query = "INSERT into notifications values(0,$own,$likeId,'2')";
                                    mysqli_query($conn,$query) or die("Error while querying the database for adding the notifications");
                                    header("Refresh:2;url=viewBlogFull.php?id=$blogId");
                                    $msg = 'Like added successfully';
                                }
                            }
                            else if($like === 'remove')
                            {
                                $query = "DELETE FROM likes where blog_id=$blogId AND user_id=$uId";
                                mysqli_query($conn,$query) or die("Error while querying the database for like deletion");
                                $newLikes = $row['likes'] - 1;
                                $query = "UPDATE BLOGS SET likes=$newLikes where blog_id = $blogId";
                                mysqli_query($conn,$query) or die("Error while updating the blogs data for removing the likes");
                                header("Refresh:2;url=viewBlogFull.php?id=$blogId");
                                $msg = 'Liked removed successfully';
                            }
                        }
                    }
                    if(isset($_GET['notif_id']))
                    {
                        $notifId = $_GET['notif_id'];
                        $query = "DELETE from notifications where nottif_id=$notifId";
                        mysqli_query($conn,$query) or die("Error while deleting the notification");
                    }
                    if(!empty($_SESSION['user_id']))
                    {   
                        $userId = $row['user_id'];
                        $followerId = $_SESSION['user_id'];
                        $query = "SELECT * from followers where user_id=$userId and follower_id=$followerId";
                        $result = mysqli_query($conn,$query) or die("Error while checking for following status");
                    }
                   
                    if(mysqli_num_rows($result) > 0)
                        $flw = 1;
                    if(!empty($_GET['follow']))
                    {
                        if(!empty($_SESSION['user_id']))
                        {
                            if($_SESSION['user_id']!=$row['user_id'])
                            {
                                $userId = $_GET['follow'];
                                $followerId = $_SESSION['user_id'];
                                $query = "SELECT * from followers where user_id=$userId and follower_id=$followerId";
                                $result = mysqli_query($conn,$query) or die("Error while checking for following status");
                                if(mysqli_num_rows($result) == 0)
                                {
                                    $query = "INSERT into followers values(0,$userId,$followerId)";
                                    mysqli_query($conn,$query) or die("Error while adding the new follower");
                                    $query = "INSERT into notifications values(0,$userId,$followerId,'3')";
                                    mysqli_query($conn,$query) or die("Error while providing the notification about the new follower");   
                                    $msg ="You started following".$row['username'];
                                    $blgId = $row['blog_id'];
                                    header("Refresh:3;url=viewBlogFull.php?id=$blgId");
                                }
                                else
                                {
                                    $msg  ="You are already a follower";
                                    $flw = 1;
                                }
                                
                            }
                            else
                            {
                                $msg = "You can not follow yourself";
                            }
                            
                        }
                        else
                        {
                            $msg = "Please Log to follow";
                        }
                        
                    }
                }
                if($dlt != 1)
                {


?>

                        <div class = "blog_full">
                            <?php
                                if(!empty($msg))
                                    echo '<h2>'.$msg.'</h2>';
                            ?>
                            <h1><?php echo $row['title']; ?></h1>
                            <h4 class = "">
                                By: <i><?php echo $row['username'];?></i>
                                <?php
                                    if(!empty($_SESSION['user_id']) &&  $row['user_id']!=$_SESSION['user_id'] && $flw == 0)
                                    {
                                ?>
                                        <a href="viewBlogFull.php?id=<?php echo $row['blog_id']; ?>&follow=<?php echo $row['user_id'];?>">Follow</a>
                                <?php  
                                    }
                                ?>
                                
                            </h4>
                            <?php 
                                if(isset($_SESSION['user_id']))
                                {
                                    if($_SESSION['user_id'] == $row['user_id']);
                                    {
            ?>
                                        <a href = "viewBlogFull.php?id=<?php echo $id;?>&delete=yes" class = "dlt">Delete</a>
                            <?php
                                    }
                                }
                            ?>
                            
                            <h3><i><?php echo $row['category_name'];?></i></h3>
                            <div class="blg_fl_img"><img src = "<?php echo $row['imageUrl'];?>" alt = "error"/></div>
                            <div class="lk_vws">
                                <h4> <i class = "fa fa-heart"></i><?php echo $row['likes']; ?></h4>
                                <h4> <i class = "fa fa-eye"></i><?php echo $row['views']; ?></h4>
                            </div>
                            <p>
                                <?php echo $row['text']; ?>
                            </p>
                            
                            <h4>Posted on:<?php echo substr($row['posted'],0,10); ?></h4>
                            <?php
                                if(isset($_SESSION['user_id']))
                                {
                                    $user_id = $_SESSION['user_id'];
                                    $blog_id = $row['blog_id'];
                                    $query = "SELECT * from likes where user_id = $user_id AND blog_id = $blog_id";
                                    $result = mysqli_query($conn,$query) or die("Error while querying the database");
                                    if(mysqli_num_rows($result) === 0 )
                                    {
                            ?>
                                        <a href = "viewBlogFull.php?id=<?php echo $id; ?>&like=like" class = "like">Like</a>
                            <?php
                                    }
                                    else
                                    {
                            ?>
                                        <a href = "viewBlogFull.php?id=<?php echo $id; ?>&like=remove" class = "liked">Liked</a>
                            <?php
                                    }
                                }
                            ?>
                            <div>
                                <h3 class = "cmnt">
                                    Comments
                                    <?php
                                    if(isset($_SESSION['user_id']))
                                    {
                                    ?>
                                            <a href = "addComment.php?id=<?php echo $id; ?>">Add a Comment</a>
                                    <?php
                                        }
                                    ?>
                                </h3>
                                
                            </div>
                            <div class = "comments_box">
            <?php
                            // $id = $row['blog_id'];
                            $query = "SELECT comments.comment_id,comments.text,comments.commented_on,users.username from comments inner join users using(user_id) where comments.blog_id=$id";
                            $results = mysqli_query($conn,$query) or die("Error while querying the database for getting the comments");
                            $limit = 5;
                            $total = ceil(mysqli_num_rows($results)/$limit);
                            // echo mysqli_num_rows($results)/$limit;
                            $skip = 0;
                            $page = empty($_GET['page']) ? 1: $_GET['page'];
                            $skip = ($page -1) * $limit;
                            $query.= " LIMIT $skip, $limit";
                            $results = mysqli_query($conn,$query) or die("Error while getting the commennts");
                            if(mysqli_num_rows($results) > 0)
                            {
                                while($flg = mysqli_fetch_array($results))
                                {

            ?>              
                                    <div class = "comment">
                                        <h3><?php echo $flg['text']; ?></h3>
                                        <h4><i><?php echo $flg['username']; ?></i> <?php echo substr($flg['commented_on'],0,10) ;?></h4>
                                        <div class = "optn">
                                            <?php
                                                if(isset($_SESSION['username']) && $flg['username'] === $_SESSION['username'])
                                                {
                                            ?>
                                                    <a href = "updateComment.php?id=<?php echo $flg['comment_id']; ?>&blog_id=<?php echo $id; ?>" class="upd">Update</a>
                                                    <a href = "deleteComment.php?id=<?php echo $flg['comment_id']; ?>&blog_id=<?php echo $id; ?>" class="cmnt_dlt">Delete</a>
                                        </div>
                                    </div>
            <?php
                                                }
                                }
            ?>
                                <div class = "pages">
                
                                <?php
                                                if($page ==1)
                                                {
                                ?>
                                                    <a href = "#"><i class = "fa fa-angle-left"></i></a>
                                <?php
                                                }
                                                else
                                                {
                                ?>
                                                    <a href="viewBlogs.php?page=<?php echo $page - 1; ?>"><i class = "fa fa-angle-left"></i></a>
                                <?php
                                                }
                                                for($i=1;$i<=$total;$i++)
                                                {
                                ?>
                                                    <a id="<?php if($page == $i) echo "pg_selec" ?>" href="viewBlogs.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                <?php
                                                }
                                                if($page == $total)
                                                {
                                                    
                                ?>
                                                    <a href = "#"><i class = "fa fa-angle-right"></i></a>
                                <?php
                                                }
                                                else
                                                {
                                ?>
                                                    <a href="viewBlogs.php?page=<?php echo $page + 1; ?>"><i class = "fa fa-angle-right"></i></a>
                                <?php
                                                }
                                ?>
                                </div>
                <?php
                                
                            }
                            else
                            {
            ?>
                                    <h2 id=empty>No Comments Yet..</h2>
            <?php
                            }
            ?>
                            </div>
                            
                        </div>
<?php
                }
            if($dlt != 1)
            {
                $newViews = $row['views'] + 1;
                $blogId = $row['blog_id'];
                $query = "UPDATE blogs SET views=$newViews where blog_id=$blogId";
                mysqli_query($conn,$query) or die("Error while querying database for updating the views of the blog");
                $userId= $row['user_id'];
                $totalViews = $row['totalViews'] + 1;
                $query = "UPDATE users set totalViews=$totalViews where user_id=$userId";
                mysqli_query($conn,$query) or die("Error while querying the database for updating the total views of the users");
            }
        }
    }
    else
    {
        header('Refresh:3;url=viewBlogs.php');
        echo '<div><h3>No Blog Selected</h3></div>';
    }
    mysqli_close($conn);
    require_once("./includes/footer.php");
?>