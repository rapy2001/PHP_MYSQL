<?php
    require_once("./includes/session.php");
    require_once("./includes/vars.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $query = 
        "SELECT blogs.title, blogs.text,blogs.imageUrl,categories.category_name,users.username 
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
?>
            <div>
                <h1><?php echo $row['title']; ?></h1>
                <h3>By: <i><?php echo $row['username'];?></i></h3>
                <h3>category: <i><?php echo $row['category_name'];?></i></h3>
                <img src = "<?php echo $row['imageUrl'];?>" alt = "error"/>
                <p>
                    <?php echo $row['text']; ?>
                </p>
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