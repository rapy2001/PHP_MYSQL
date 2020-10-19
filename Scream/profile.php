<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/loader.php");
    require_once("./includes/nav.php");
    if(!empty($_SESSION['user_id']))
    {
        $msg = '';
        if(!empty($_GET['scream_id']))
        {
            $screamObj = new Scream();
            $scream = $screamObj->getScream($_GET['scream_id']);
            if($scream['user_id'] == $_SESSION['user_id'])
            {
                $screamObj->deleteScream($_GET['scream_id']);
                header('Refresh:3;url="profile.php"');
                $msg = 'Scream deleted successfully';
            }
            else
            {
                $msg = 'You don\'t have the permission to delete this scream';
            }
        }
        if(!empty($_GET['user_id']))
        {
?>
            <div class = "profile">
                <h1>Profile</h1>
            <h4 class = "scs_msg msg"></h4>
            <h4 class = "err_msg msg"></h4>
<?php
                $obj = new User();
                $userData = $obj->getUserWithId($_GET['user_id']);
                $flg = $obj->checkFriendshipStatus($_GET['user_id'],$_SESSION['user_id']);
                if($_SESSION['user_id'] == $_GET['user_id'] || $userData['mode'] == 'P' || $flg == 0)
                {
?>
                    <div class = "profile_box">
                        <div>
                            <img src = "<?php echo $userData['imageUrl']?>" alt = "error" />
                            <div>
                                <h2>
                                    <?php
                                        echo $userData['username'];
                                    ?>
                                </h2>
                                <h3>
                                    City:
                                    <?php
                                        echo empty($userData['city']) ? 'EMPTY': $userData['city'];
                                    ?>
                                </h3>
                            </div>
                        </div>
                        
                        <?php
                            if($_SESSION['user_id'] == $_GET['user_id'])
                            {
                                ?>
                                <a href ="friendsList.php" class = "btn">View Friends</a>
                                <?php
                            }
                        ?>
                        
                    </div>
<?php
                }
                else
                {
                    
?>
                    <div class = "profile_box">
                        <div>
                            <img src = "<?php echo $userData['imageUrl']?>" alt = "error" />
                            <div>
                                <h2>
                                    <?php
                                        echo $userData['username'];
                                    ?>
                                </h2>
                            </div>
                        </div>
                    </div>
<?php
                }
                ?>
                    <div class = "profile_status">
                        <?php
                            if($_SESSION['user_id'] == $_GET['user_id'])
                            {
                                ?>
                                <div>
                                    <h4>
                                        Profile Status :
                                        <b>
                                            <span class = "currentStatus">
                                                <?php echo $userData['mode'] == 'P' ? 'Public': 'Private'?>
                                            </span>
                                        </b>
                                    </h4>
                                    
                                    <button class = "toggleStatus btn">Toggle Status</button>
                                </div>
                                <!-- <ul>
                                    <h5>Note</h5>
                                    <li>Public :- Profile (including Profile Picture, Screams) will be visisble to all</li>
                                    <li>Private :- Profile (including Profile Picture, Screams) will be visisble to Friends only</li>
                                </ul> -->
                                
                                
                                <?php
                            }
                        ?>
                    </div>
                    <h1>Screams</h1>
                <?php
                if($_SESSION['user_id'] == $_GET['user_id'] || $userData['mode'] == 'P' || $flg == 0)
                {
                    $obj = new Scream();
                    $screams = $obj->getUserScreams($userData['user_id']);
                    if(count($screams) > 0)
                    {
                        ?>
                        <div class = "profile_screams">
                            <?php
                            if(!empty($msg))
                            {
                                echo '<h4>'.$msg.'</h4>';
                            }
                            foreach($screams as $scream)
                            {
                ?>
                                <div class = "user_card scream_box">
                                    <img src = "<?php echo $scream['scream_image']; ?>" alt = "error"/>
                                    <h2>
                                        <?php echo $scream['Scream_text']; ?>
                                    </h2>
                                    <h4>
                                        Posted On:
                                        <?php
                                            echo substr($scream['created_at'],0,10);
                                        ?>
                                    </h4>
                                    <a href = "viewScream.php?scream_id=<?php echo $scream['scream_id'];?>" class = "view">View Scream</a>
                                    <?php
                                        if($_SESSION['user_id'] == $_GET['user_id'])
                                        {
                                    ?>
                                            <a href = "updateScream.php?scream_id=<?php echo $scream['scream_id'];?>" class = "update">Update Scream</a>
                                            <a href = "profile.php?user_id=<?php echo $_SESSION['user_id']; ?>&scream_id=<?php echo $scream['scream_id'];?>" class = "delete">Delete Scream</a>
                                    <?php
                                        }
                                    ?>
                                    
                                    
                                </div>
                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    else
                    {
            ?>
                        <div class = "empty">
                            <h4>No screams Posted yet ... </h4>
                        </div>
            <?php
                    }
                }
                else
                {
                    ?>
                    <div class = "empty">
                        <h4>No Screams Posted</h4>
                    </div>
                    <?php
                }  
        }
        else
        {
?>
            <div class = "empty">
                <h4>No User was provided</h4>
            </div>
<?php
        }
?>
        </div>
<?php 
    }
    else
    {
?>
        <div class = "empty">
            <h4>You need to Log In to view this Profile</h4>
        </div>
<?php
    }
    ?>
    <footer>
        <a href = "about.php">2020. Rajarshi Saha</a>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src = "./public/index.js"></script>
    <script>
        $(document).ready(()=>{
            $('.scs_msg').remove();
            $('.err_msg').remove();
            $('.toggleStatus').click(()=>{
                $.ajax({
                    url:'toggleProfile.php',
                    type:'POST',
                    data:{userId:<?php echo $userData['user_id']; ?>},
                    success:function(data){
                        if(data == '1')
                        {
                            if($('.currentStatus').html() == 'Public')
                            {
                                
                                $('.currentStatus').html('Private');
                                
                            }
                            else
                            {
                                $('.currentStatus').html('Public');
                            }
                            $('.scs_msg').html('Status changed successfully').slideDown();
                            $('.err_msg').slideUp();
                        }
                        else
                        {
                            $('.err_msg').html('Status could not be changed').slideDown();
                            $('.scs_msg').slideUp();
                        }
                        setTimeout(function(){
                                $('.scs_msg').fadeOut().remove();
                                $('.err_msg').fadeOut().remove();
                        },3000)
                    }
                })
            });
        });
    </script>
    </body>
</html>