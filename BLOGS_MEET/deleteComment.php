<?php
    require_once('./includes/session.php');
    require_once("./includes/vars.php");
    if(empty($_SESSION['user_id']))
    {
        header('Refresh:3;url=homepage.php');
        echo "You need to log in to delete a comment";
    }
    else
    {
        
        if(empty($_GET['id']))
        {
            header('Refresh:3;url=homepage.php');
            echo 'No Comment to delete';
        }
        else
        {
            $comment_id = $_GET['id'];
            $query = "SELECT user_id from comments where comment_id=$comment_id";
            $result = mysqli_query($conn,$query) or die("Error while querying the database");
            if(mysqli_num_rows($result) > 0)
            {
                $row = mysqli_fetch_array($result);
                echo $row['user_id'] ." " .$_SESSION['user_id'];
                if($row['user_id'] === $_SESSION['user_id'])
                {
                    if(!isset($_GET['id']))
                    {
                        header('Refresh:3;url=homepage.php');
                        echo "No Comment to delete";
                    }
                    else
                    {
                        
                        $query = "DELETE from comments where comment_id=$comment_id";
                        mysqli_query($conn,$query) or die("Error while querying the database");
                        if(!empty($_GET['blog_id']))
                        {
                            $blog_id = $_GET['blog_id'];
                            header("Refresh:3;url=viewBlogFull.php?id=$blog_id");
                        }
                            
                        else
                            header('Refresh:3;url=homepage.php');
                        echo 'Comment deleted';
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
                        header('Refresh:3;url=homepage.php');
                    echo "You are not allowed to delete the comment";
                }
            }
            else
            {
                header('Refresh:3;url=homepage.php');
?>
                <div >
                    <h2 id = "empty">No comment to delete</h2>
                </div>
<?php
                
            }
            
        }
        
    }
?>