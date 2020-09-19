<?php
    require_once("./includes/session.php");
    require_once("./includes/vars.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    if(isset($_GET['id']))
    {
        
        $id = $_GET['id'];
        $dlt = 0;
        $msg = '';
        $query="SELECT blogs.posted,blogs.views,blogs.blog_id,blogs.title, blogs.text,blogs.imageUrl,blogs.likes,categories.category_name,users.user_id,users.username,users.totalViews
        from categories inner join blogs using(category_id) inner join users using(user_id) where blogs.blog_id = $id";
        $result = mysqli_query($conn,$query) or die("Error while querying the database");
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
                }
                if($dlt != 1)
                {


?>

                        <div>
                            <?php
                                if(!empty($msg))
                                    echo '<h2>'.$msg.'</h2>';
                            ?>
                            <h1><?php echo $row['title']; ?></h1>
                            <h3>By: <i><?php echo $row['username'];?></i></h3>
                            <?php 
                                if(isset($_SESSION['user_id']))
                                {
                                    if($_SESSION['user_id'] == $row['user_id']);
                                    {
            ?>
                                        <a href = "viewBlogFull.php?id=<?php echo $id;?>&delete=yes">Delete</a>
                            <?php
                                    }
                                }
                            ?>
                            
                            <h3>category: <i><?php echo $row['category_name'];?></i></h3>
                            <img src = "<?php echo $row['imageUrl'];?>" alt = "error"/>
                            <p>
                                <?php echo $row['text']; ?>
                            </p>
                            <h4> likes: <?php echo $row['likes']; ?></h4>
                            <h4> views: <?php echo $row['views']; ?></h4>
                            <h4>posted on <?php echo substr($row['posted'],0,10); ?></h4>
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
                                        <a href = "viewBlogFull.php?id=<?php echo $id; ?>&like=like">Like</a>
                            <?php
                                    }
                                    else
                                    {
                            ?>
                                        <a href = "viewBlogFull.php?id=<?php echo $id; ?>&like=remove">Liked</a>
                            <?php
                                    }
                                }
                            ?>
                            <div>
                                <h3>Comments</h3>
                                <?php
                                    if(isset($_SESSION['user_id']))
                                    {
                                ?>
                                        <a href = "addComment.php?id=<?php echo $id; ?>">Add a Comment</a>
                                <?php
                                    }
                                ?>
                            </div>
                            <div>
            <?php
                            // $id = $row['blog_id'];
                            $query = "SELECT comments.comment_id,comments.text,comments.commented_on,users.username from comments inner join users using(user_id) where comments.blog_id=$id";
                            $results = mysqli_query($conn,$query) or die("Error while querying the database for getting the comments");
                            $limit = 5;
                            $total = ceil(mysqli_num_rows($results)/$limit);
                            // echo mysqli_num_rows($results)/$limit;
                            $skip = 0;
                            if(isset($_GET['page']))
                            {
                                $skip = ($_GET['page'] - 1) * $limit;
                            }
                            $query.= " LIMIT $skip, $limit";
                            $results = mysqli_query($conn,$query) or die("Error while getting the commennts");
                            if(mysqli_num_rows($results) > 0)
                            {
                                while($flg = mysqli_fetch_array($results))
                                {

            ?>              
                                    <div>
                                        <h3><?php echo $flg['text']; ?></h3>
                                        <h4>By: <?php echo $flg['username']; ?> posted on: <?php echo substr($flg['commented_on'],0,10) ;?></h4>
                                        <?php
                                            if(isset($_SESSION['username']) && $flg['username'] === $_SESSION['username'])
                                            {
                                        ?>
                                                <a href = "updateComment.php?id=<?php echo $flg['comment_id']; ?>&blog_id=<?php echo $id; ?>">Update</a>
                                                <a href = "deleteComment.php?id=<?php echo $flg['comment_id']; ?>&blog_id=<?php echo $id; ?>">Delete</a>
                                    </div>
            <?php
                                            }
                                }
                                if(!empty($_GET['page']))
                                {
                                    // echo $total,$_GET['page'];
                                    if($_GET['page'] == 1)
                                        echo '<h4><--</h4>';
                                    else
                                    {
            ?>
                                        <a href = "viewBlogFull.php?id=<?php echo $id; ?>&page=<?php echo $_GET['page'] - 1 ;?>"><--</a>
            <?php
                                    }
                                }
                                else
                                {
            ?>
                                    <h4><--</h4>
                                    
            <?php
                                    
                                }
                                // echo $total;
                                for($i=1;$i<=$total;$i++)
                                {
            ?>
                                    <a href = "viewBlogFull.php?id=<?php echo $id; ?>&page=<?php echo ($i) ;?>"><?php echo $i; ?></a>
            <?php
                                }
                                if(!empty($_GET['page']))
                                {
                                    // echo $total,$_GET['page'];
                                    if($_GET['page'] == $total)
                                        echo '<h4>--></h4>';
                                    else
                                    {
            ?>
                                        <a href = "viewBlogFull.php?id=<?php echo $id; ?>&page=<?php echo $_GET['page'] + 1 ;?>">--></a>
            <?php
                                    }
                                }
                                else
                                {
            ?>
                                    <h4>--></h4>
            <?php
                                }
                                
                            }
                            else
                            {
            ?>
                                    <h2>No Comments Yet..</h2>
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