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
                $NOTIF = empty($_GET['notif_id']) ? -1 : $_GET['notif_id'];
                if($NOTIF != -1)
                {
                    $query = "DELETE from notifications where nottif_id=$NOTIF";
                    mysqli_query($conn,$query) or die("Error while querying the dataase for deleting the notif");
                }
                $uId = $_GET['user_id'];
                $query = "SELECT * from followers where user_id=$uId";
                $result = mysqli_query($conn,$query) or die("Error while querying the database");
                $followers = mysqli_num_rows($result);
                $query = "SELECT * from blogs where user_id=$uId";
                $result = mysqli_query($conn,$query) or die("Error while querying the database");
                $blogs =  mysqli_num_rows($result);
                $query = "SELECT * FROM users where user_id=$uId";
                $result = mysqli_query($conn,$query) or die("Error while querying the database");
                if(mysqli_num_rows($result) > 0)
                {
                    $row = mysqli_fetch_array($result);
?>
                    <div class = "dashboard public">
                        <div class = "public_box_1">
                            <div class = "pb1_1">
                                <img src="<?php echo $row['userImage']; ?>" alt ="error"/>
                            </div>
                            <div class = "pb1_2">
                                <div class = "pb1_2_1">
                                    <h1><?php echo $row['username']; ?></h1>
                                </div>
                                <p>
                                    <?php 
                                        echo $row['description'];
                                    ?>
                                </p>
                                <div class = "pb1_2_2">
                                    <h4><i class = "fa fa-image"></i><?php echo $blogs;?></h4>
                                    <h4><i class = "fa fa-male"></i><?php echo $followers;?></h4>
                                    <h4><i class = "fa fa-eye"></i><?php echo $row['totalViews'];?></h4>
                                </div>
                            </div>
                        </div>
                        
                        <h2>Notifications</h2>
<?php
                        $uId = $row['user_id'];
                        $query = "SELECT * from notifications where user_id=$uId";
                        $result = mysqli_query($conn,$query) or die("Error while querying the database for getting the notification type");
                        if(mysqli_num_rows($result) > 0)
                        {
                                while($notif = mysqli_fetch_array($result))
                                {
                                    // $query = "SELECT * from notifications where user_id=$uId";
                                    // $result = mysqli_query($conn,$query) or die("Error while querying the database here");
                                    // $dat = mysqli_fetch_array($result);
                                    
                                   
                                    // $query =     
                                    // "SELECT notifications.notif_id,comments.blog_id,users.username from".
                                    // "notitfications inner join comments on notifications.data_id=comments.comment_id inner join users using(user_id) where users.user_id=$uId";
                                    // $result = mysqli_query($conn,$query) or die("Error while querying the database for getting the notification");
                                    // $data = mysqli_num_rows($result);
                                    if($notif['type'] == 1)
                                    {
                                        // $cmnt = $dat['data_id'];
                                        $cmnt = $notif['data_id'];
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
    ?>
                                        <a href="viewBlogFull.php?id=<?php echo $dat['blog_id']; ?>&notif_id=<?php echo $notif['nottif_id']; ?>">
                                            <?php echo $dat['username'] ?> added a Comment to your Blog
                                        </a>
    <?php
                                    }
                                    else if($notif['type'] == 2)
                                    {
                                        // $query = "SELECT * from notifications where user_id=$uId";
                                        // $result = mysqli_query($conn,$query) or die("Error while querying the database here");
                                        // $univ = mysqli_fetch_array($result);
                                        // $likeId = $univ['data_id'];
                                        $likeId = $notif['data_id'];
                                        $query = "SELECT user_id,blog_id from likes where like_id=$likeId";
                                        $result = mysqli_query($conn,$query) or die("Error while qquerying the database for getting the user_id of the like");
                                        $row = mysqli_fetch_array($result);
                                        $uId = $row['user_id'];
                                        $blogId = $row['blog_id'];
                                        $query = "SELECT users.username from users where user_id=$uId";
                                        $result = mysqli_query($conn,$query) or die("Error while getting the username");
                                        $username = mysqli_fetch_array($result)['username'];
                                        // $ntf = $univ['notif_id'];
                                        
    ?>
                                       <a href="viewBlogFull.php?id=<?php echo $blogId; ?>&notif_id=<?php echo $notif['nottif_id']; ?>">
                                            <?php echo $username ?> added a like to your Blog
                                        </a> 
    
    <?php
                                    }
                                    else if($notif['type'] == 3)
                                    {
                                        // var_dump($notif);
                                        $followerId = $notif['data_id'];
                                        $query = "SELECT username from users where user_id=$followerId";
                                        $result = mysqli_query($conn,$query) or die("Error while querying the database");
                                        $username = mysqli_fetch_array($result)['username'];
                                        $notifId = $notif['nottif_id'];
    ?>
                                        <a href="userDashboard.php?user_id=<?php echo $uId;?>&notif_id=<?php echo $notifId; ?>"><?php echo $username ?> started following you</a>
    <?php
                                    }
                                    else if($notif['type'] == 4)
                                    {
                                        $blgId = $notif['data_id'];
                                        $query = "SELECT user_id from blogs where blog_id=$blgId";
                                        $result = mysqli_query($conn,$query) or die("Error while getting the userId");
                                        $userId = mysqli_fetch_array($result)['user_id'];
                                        $query = "SELECT username from users where user_id=$userId";
                                        $result = mysqli_query($conn,$query) or die("Error while getting the username");
                                        $username = mysqli_fetch_array($result)['username'];
    ?>
                                        <a href="viewBlogFull.php?id=<?php echo $blgId; ?>&notif_id=<?php echo $notif['nottif_id']; ?>">
                                            <?php echo $username ?> added a new blog
                                        </a> 
    <?php
                                    }
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
    mysqli_close($conn);
    require_once("./includes/footer.php");
?>