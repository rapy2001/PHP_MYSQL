<?php
    require_once('./includes/session.php');
    require_once("./includes/vars.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    if(empty($_SESSION['user_id']))
    {
        header('Refresh:3;url=homepage.php');
        echo '<div id = "empty_div"><h2 id = "empty">Please Log In to delete a Comment</h2></div>';
    }
    else
    {
        
        if(empty($_GET['id']))
        {
            header('Refresh:3;url=homepage.php');
            echo '<div id = "empty_div"><h2 id = "empty">No Comment to Delete</h2></div>';
        }
        else
        {
            $comment_id = $_GET['id'];
            $query = "SELECT user_id from comments where comment_id=$comment_id";
            $result = mysqli_query($conn,$query) or die("Error while querying the database");
            if(mysqli_num_rows($result) > 0)
            {
                $row = mysqli_fetch_array($result);
                // echo $row['user_id'] ." " .$_SESSION['user_id'];
                if($row['user_id'] == $_SESSION['user_id'])
                {
                    if(!isset($_GET['id']))
                    {
                        header('Refresh:3;url=homepage.php');
                        echo '<div id = "empty_div"><h2 id = "empty">No Comment to delete</h2></div>';
                    }
                    else
                    {
                        $query = "DELETE from notifications where data_id=$comment_id and type=1";
                        mysqli_query($conn,$query) or die("Error while deleting the notification");
                        $query = "DELETE from comments where comment_id=$comment_id";
                        mysqli_query($conn,$query) or die("Error while querying the database");
                        if(!empty($_GET['blog_id']))
                        {
                            $blog_id = $_GET['blog_id'];
                            header("Refresh:3;url=viewBlogFull.php?id=$blog_id");
                        }
                            
                        else
                            header('Refresh:3;url=homepage.php');
                        echo '<div id = "empty_div"><h2 id = "empty">Comment deleted</h2></div>';
                    }
                }
                else
                {
                    if(!empty($_GET['blog_id']))
                    {
                        $blog_id = $_GET['blog_id'];
                        header("Refresh:3;url=viewBlogFull.php?id=$blog_id");
                    }
                    else
                    {
                        header('Refresh:3;url=homepage.php');
                        echo '<div id = "empty_div"><h2 id = "empty">Comment deleted</h2></div>';
                    }
                       
                }
            }
            else
            {
                header('Refresh:3;url=homepage.php');
?>
                <div id = "empty_div">
                    <h2 id = "empty">No comment to delete</h2>
                </div>
<?php
                
            }
            
        }
        
    }
    mysqli_close($conn);
    require_once("./includes/footer.php");
?>