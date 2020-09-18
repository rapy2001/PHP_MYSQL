<?php
    require_once("./includes/vars.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    if(isset($_GET['user_id']))
    {
        if(isset($_SESSION['user_id']))
        {
            if($_SESSION['user_id'] == $_GET['user_id'])
            {
                $uId = $_GET['user_id'];
                $query = "SELECT * FROM users where user_id=$uId";
                $result = mysqli_query($conn,$query) or die("Error while querying the database");
                if(mysqli_num_rows($result) > 0)
                {
                    $row = mysqli_fetch_array($result);
?>
                    <div>
                        <h1>username: <?php echo $row['username']; ?></h1>
                        <img src="<?php echo $row['userImage']; ?>" alt ="error"/>
                        <p>
                            <?php 
                                echo $row['description'];
                            ?>
                        </p>
                        <h4>Total Views:<?php echo $row['totalViews'];?></h4>
                        <h2>Notifications</h2>
<?php
                        $uId = $row['user_id'];
                        $query = "SELECT type from notifications where user_id=$uId";
                        $result = mysqli_query($conn,$query) or die("Error while querying the database for getting the notification type");
                        if(mysqli_num_rows($result) > 0)
                        {
                                $notif = mysqli_fetch_array($result);
                                $query = "SELECT * from notifications where user_id=$uId";
                                $result = mysqli_query($conn,$query) or die("Error while querying the database here");
                                $dat = mysqli_fetch_array($result);
                                $cmnt = $dat['data_id'];
                                $query = "SELECT user_id,blog_id from comments where comment_id=$cmnt";
                                $result = mysqli_query($conn,$query) or die("error while querying the database present");
                                $my = mysqli_fetch_array($result);
                                $uId = $my['user_id'];
                                $dat['blog_id'] = $my['blog_id'];
                                echo $dat['blog_id']."here";
                                $query = "SELECT users.username from users where user_id=$uId";
                                $result = mysqli_query($conn,$query) or die("Error while querying the database there");
                                $val = mysqli_fetch_array($result);
                                $dat['username']=$val['username'];
                               
                                // $query =     
                                // "SELECT notifications.notif_id,comments.blog_id,users.username from".
                                // "notitfications inner join comments on notifications.data_id=comments.comment_id inner join users using(user_id) where users.user_id=$uId";
                                // $result = mysqli_query($conn,$query) or die("Error while querying the database for getting the notification");
                                // $data = mysqli_num_rows($result);
                                if($notif['type'] == 1)
                                {
?>
                                    <a href="viewBlogFull.php?id=<?php echo $dat['blog_id']; ?>&notif_id=<?php echo $dat['nottif_id']; ?>">
                                        <?php echo $dat['username'] ?> added a Comment to your Blog
                                    </a>
<?php
                                }
                                else
                                {
?>
                                   <a href="viewBlogFull.php?id=<?php echo $dat['blog_id']; ?>&notif_id=<?php echo $dat['notif_id']; ?>">
                                        <?php echo $dat['username'] ?> added a like to your Blog
                                    </a> 

<?php
                                }
                        }
                        else
                        {
?>
                            <h4>No Notifications</h4>
<?php
                        }
?>
                    </div>
<?php
                
                }
                else
                {
                    header('Refresh:3;url="homepage.php"');
                    echo '<h4 class = "error msg">No Data available</h4>';
                }
            }
            else
            {
                header('Refresh:3;url="homepage.php"');
                echo '<h4 class = "error msg">You don\'t  have the permission to access this page</h4>';
            }
        }
        else
        {
            header('Refresh:3;url="homepage.php"');
            echo '<h4 class = "error msg">You need to login to access the dashboard</h4>';
        }
    }
    else
    {
        header('Refresh:3;url="homepage.php"');
        echo '<h4 class = "error msg">No User Selected</h4>';
    }
    $query = "SELECT * from users";
    mysqli_close($conn);
    require_once("./includes/footer.php");
?>