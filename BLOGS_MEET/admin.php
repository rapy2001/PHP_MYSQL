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
            $limit = 5;
            $query = "SELECT * FROM blogs WHERE approved=0";
            $results = mysqli_query($conn,$query) or die("Error while querying the database");
            $total = ceil(mysqli_num_rows($results) / $limit);
            $page = empty($_GET['page']) ? 1 : $_GET['page'];
            $skip = ($page-1)*$limit;
            $query = "SELECT * from blogs where approved=0 limit $skip,$limit";
            $results = mysqli_query($conn,$query) or die('Error while querying the database for displaying the form in admin page');
            if(isset($_GET['id']))
            {
                $id = trim($_GET['id']);
                $query = "UPDATE blogs set approved='1' where blog_id='$id'";
                mysqli_query($conn,$query) or die("Error while querying the database for approval");
                $query = "SELECT user_id from blogs where blog_id=$id";
                $result = mysqli_query($conn,$query) or die("Error while querying the database getting blog user_id");
                $userId = mysqli_fetch_array($result)['user_id'];
                $query = "SELECT * from followers where user_id=$userId";
                $result = mysqli_query($conn,$query) or die("Error while getting the followers");
                while($row = mysqli_fetch_array($result))
                {
                    $flwId = $row['follower_id'];
                    $query = "INSERT into notifications values(0,$flwId,$id,'4')";
                    mysqli_query($conn,$query) or die("Error while querying the database for giving the followers notifications");
                }
                header('Refresh:2;url=admin.php');
                echo 'The Blog was approved';
            }
        }
        else
        {
            echo '<div id = "empty_div"><h2 id = "empty">Please Log In as the Admin to access this page</h2></div>';
            $show = 1;
        }
    }
    else
    {
        echo '<div id = "empty_div"><h2 id = "empty">Please Log In as the Admin to access this page</h2></div>';
        $show = 1;
    }
    if($show === 0)
    {
        if(mysqli_num_rows($results) === 0)
                echo '<div id = "empty_div"><h2 id="empty">No Blogs To approve</h2></div>';
        else
        {
?>
                <div class = "admin">
                    <h1>Blogs Submitted for Approval</h1>
                    <div class = "admin_box">
                        <?php
                            while($row = mysqli_fetch_array($results))
                            {
                        ?>
                                <div class = "approval">
                                    <h2><?php echo $row['title']; ?></h2>
                                    
                                    <img src = "<?php echo $row['imageUrl'] ?>" />
                                    <div class = "approval_p">
                                        <p>
                                            <?php echo $row['text']; ?>
                                            
                                        </p>
                                        <span><i class = "fa fa-angle-down expand"></i></span>
                                    </div>
                                    
                                    <a href = "admin.php?id=<?php echo $row['blog_id']; ?>" class = "admin_btn">Approve</a>
                                </div>
                        <?php
                            }
                            // echo $total,$page;
                        ?>
                        <div class = "pages">
                        <?php
                            if($page === 1)
                            {        
                        ?>
                                <a href="#"><i class = "fa fa-angle-left"></i></a>
                        <?php
                            }
                            else
                            {
                        ?>
                                <a href = "admin.php?page=<?php echo $page-1?>"><i class = "fa fa-angle-left"></i></a>
                        <?php
                            }
                            for($i=1;$i<=$total;$i++)
                            {
                        ?>
                                <a href = "admin.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        <?php
                            }
                            if($page == $total)
                            {
                        ?>
                                <a href="#"><i class = "fa fa-angle-right"></i></a>
                        <?php
                            }
                            else
                            {
                        ?>
                                <a href="admin.php?page=<?php echo $page+1; ?>"><i class = "fa fa-angle-right"></i></a>
                        <?php
                            }
                        ?>
                        </div>
                    </div>
                </div>
<?php
        }
    }
    mysqli_close($conn);
    require_once("./includes/adminFooter.php");
?>