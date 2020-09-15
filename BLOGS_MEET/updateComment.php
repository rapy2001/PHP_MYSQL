<?php
    require_once("./includes/vars.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once('./includes/nav.php');
    $show  = 0;
    $msg = '';
    $text = '';
    if(isset($_GET['id']))
        $id = $_GET['id'];
    else
        $id = '';
    if(!isset($_SESSION['user_id']))
    {
        if(isset($_GET['id']))
        {
            $val = $_GET['id'];
            header("Refresh:4;url=viewFullBlog.php?id=$val");
            echo '<div><h2>Please Log In To update a comment</h2></div>';
        }
        else
        {
            header("Refresh:4;url=homepage.php");
            echo '<div><h2>Please Log In To update a comment</h2></div>';
        }
        
    }
    else
    {
        if(isset($_POST['submit']))
        {
            $text = $_POST['comment'];
            if(strlen($text) > 250)
            {
                $msg = 'The comment can be at most 250 characters long';
            }
            else
            {
                $text =mysqli_real_escape_string($conn,trim($text));
                $user_id = $_SESSION['user_id'];
                $blog_id = $_GET['blog_id'];
                $comment_id = $_GET['id'];
                $query = "UPDATE comments set text='$text' where comment_id=$comment_id";
                mysqli_query($conn,$query) or die('Error while querying the database');
                header("Refresh:3;url=viewBlogFull.php?id=$blog_id");
                echo '<div><h2>Comment updated Successfully</h2></div>';
                $show = 1;
            }
        }
    }
    if(isset($_GET['id']))
    {
        $comment_id = $_GET['id'];
        $query = "SELECT * from comments where comment_id = $comment_id";
        $result = mysqli_query($conn,$query) or die("Error while querying the database");
        $row = mysqli_fetch_array($result);
        $text = $row['text'];
    }
    if($show === 0)
    {
        if(!empty($msg))
            echo '<h2>'.$msg.'</h2>';
?>
        <div>
            <form action = "updateComment.php?id=<?php echo $_GET['id'] ;?>&blog_id=<?php echo $_GET['blog_id'] ;?>" method = "POST">
                <input type ="text" placeholder = "Comment" name = "comment" required = "required" autocomplete = "off" value = '<?php echo $text;?>'/>
                <input type ="submit" name = "submit"/>
            </form>
        </div>
<?php
    }
?>
<?php
    mysqli_close($conn);
    require_once("./includes/footer.php");
?>