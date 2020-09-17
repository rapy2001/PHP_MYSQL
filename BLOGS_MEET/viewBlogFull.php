<?php
    require_once("./includes/session.php");
    require_once("./includes/vars.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $msg = '';
        $query="SELECT blogs.views,blogs.blog_id,blogs.title, blogs.text,blogs.imageUrl,blogs.likes,categories.category_name,users.username 
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
                if(!empty($_GET['like']) && !empty($_SESSION['user_id']))
                {
                    $like = $_GET['like'];
                    $uId = $_SESSION['user_id'];
                    $blogId = $row['blog_id'];
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
?>
            <div>
                <?php
                    if(!empty($msg))
                        echo '<h2>'.$msg.'</h2>';
                ?>
                <h1><?php echo $row['title']; ?></h1>
                <h3>By: <i><?php echo $row['username'];?></i></h3>
                <h3>category: <i><?php echo $row['category_name'];?></i></h3>
                <img src = "<?php echo $row['imageUrl'];?>" alt = "error"/>
                <p>
                    <?php echo $row['text']; ?>
                </p>
                <h4> likes: <?php echo $row['likes']; ?></h4>
                <h4> views: <?php echo $row['views']; ?></h4>
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
                $query = "SELECT comments.comment_id,comments.text,users.username from comments inner join users using(user_id) where comments.blog_id=$id";
                $results = mysqli_query($conn,$query) or die("Error while querying the database for getting the comments");
                if(mysqli_num_rows($results) > 0)
                {
                    while($flg = mysqli_fetch_array($results))
                    {

?>              
                        <div>
                            <h3><?php echo $flg['text']; ?></h3>
                            <h4>By: <?php echo $flg['username']; ?></h4>
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
            $newViews = $row['views'] + 1;
            $blogId = $row['blog_id'];
            $query = "UPDATE blogs SET views=$newViews where blog_id=$blogId";
            mysqli_query($conn,$query) or die("Error while querying database for updating the views of the blog");
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