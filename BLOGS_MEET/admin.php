<?php 
    require_once("./includes/session.php");
    require_once("./includes/vars.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    $show = 0;
    if(isset($_SESSION['user_id']))
    {
        if($_SESSION['username'] === "Admin")
        {
            $query = "SELECT * FROM blogs WHERE approved=0";
            $results = mysqli_query($conn,$query) or die('Error while querying the database for displaying the form');
            if(isset($_GET['id']))
            {
                $id = trim($_GET['id']);
                $query = "UPDATE blogs set approved='1' where blog_id='$id'";
                mysqli_query($conn,$query) or die("Error while querying the database for approval");
                header('Refresh:2;url=admin.php');
                echo 'The Blog was approved';
            }
        }
        else
        {
            echo 'Please Log In as the Admin to access this page';
            $show = 1;
        }
    }
    else
    {
        echo 'Please Log In as the Admin to access this page';
        $show = 1;
    }
    if($show === 0)
    {
        if(mysqli_num_rows($results) === 0)
                echo 'No Blogs To approve';
        else
        {
?>
            
                <?php
                    while($row = mysqli_fetch_array($results))
                    {
                        echo '<h2>'.$row['title'].'</h2>'.'<a href = "admin.php?id='.$row['blog_id'].'">Approve</a>';
                    }
                ?>
<?php
        }
    }
    mysqli_close($conn);
    require_once("./includes/footer.php");
?>