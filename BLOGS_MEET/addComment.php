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
            echo '<div><h2>Please Log In To add a comment</h2></div>';
        }
        else
        {
            header("Refresh:4;url=homepage.php");
            echo '<div><h2>Please Log In To add a comment</h2></div>';
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
                $userId = $_SESSION['user_id'];
                $blogId = $id;
                $query = "INSERT INTO comments values(0,'$userId','$blogId','$text',NOW())";
                mysqli_query($conn,$query) or die('Error while querying the database');
                $query = "SELECT user_id from blogs where blog_id=$blogId";
                $result = mysqli_query($conn,$query) or die("Error while querying the database for getting the owner id");
                $value= mysqli_fetch_array($result);
                $ownerId = $value['user_id'];
                $query = "SELECT comments.comment_id from comments where user_id=$userId and blog_id=$blogId order by commented_on desc limit 1";
                $result = mysqli_query($conn,$query) or die("Error while querying the database for getting the comment_id of the latest comment");
                $data = mysqli_fetch_array($result);
                $cmntId = $data['comment_id'];
                $query = "INSERT INTO notifications values(0,$ownerId,$cmntId,'1')";
                mysqli_query($conn,$query) or die("Error while adding the notification");
                header("Refresh:3;url=viewBlogFull.php?id=$blogId");
                echo '<div><h2>Comment Added Successfully</h2></div>';
                $show = 1;
            }
        }
    }
    if($show === 0)
    {
        if(!empty($msg))
            echo '<h2>'.$msg.'</h2>';
?>
        <div>
            <form action = "addComment.php?id=<?php echo $_GET['id'] ;?>" method = "POST">
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