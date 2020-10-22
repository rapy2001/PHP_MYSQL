<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/loader.php");
    require_once("./includes/nav.php");
    // echo var_dump((int)"37");
    // $userId = "37";
    // $city = "delhi";    
    // $sql = "UPDATE users SET city = '$city' WHERE user_id = $userId";
    // mysqli_query($conn,$sql);
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
                            <img class = "profile_img" src = "<?php echo $userData['imageUrl']?>" alt = "error" />
                            <div>
                                <h2>
                                    <?php
                                        echo $userData['username'];
                                    ?>
                                </h2>
                                <h3 class = "profile_city">
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
                                <div class = "edit_profile_box">
                                    <form id = "edit_form" class = "form">
                                        <h3>Edit Your Profile</h3>
                                        <label for = "city">City:</label>
                                        <input type = "text" name = "city" id = "city" placeholder = "city"/>
                                        <label for = "file">Profile Image:</label>
                                        <input type = "file" name = "image" id = "file" />
                                        <input type = "hidden" name = "userId" value = "<?php echo $_SESSION['user_id']?>"/>
                                        <input type = "submit" value = "submit" />
                                        <h4 id = "edit_form_msg"></h4>
                                    </form>
                                    <h3 class = "edit_cut">
                                        <i class = "fa fa-times"></i>
                                    </h3>
                                </div>        
                                <button id = "edit_profile_btn" class = "btn">Edit Profile</button>
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
                                        <?php echo substr($scream['Scream_text'],0,10) . ' ....'; ?>
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

            $('.edit_profile_box').hide();
            $('#edit_profile_btn').on("click",function(){
                $('body').css("overflow-y","hidden");
                $('.edit_profile_box').show();
                $('.edit_profile_img').remove();
                $('#edit_form_msg').hide();
                let userId = <?php echo empty($_SESSION['user_id']) ? '': $_SESSION['user_id']; ?>;
                $.ajax({
                    url:'http://localhost/projects/scream/getUserData.php',
                    type:"POST",
                    dataType:"JSON",
                    data:{userId:userId},
                    success:function(data){
                        // console.log(data);
                        if(data.msg == 0)
                        {
                            $('#edit_form_msg').html('Error while loading the data').show();
                        }
                        else
                        {
                            // console.log(data[0]);
                            if(data[0].city != '')
                            {
                                $('#city').val(data[0].city);
                            }
                            else
                            {
                                $('#city').val("EMPTY");
                            }
                            $('.edit_profile_box').append('<img id= "edit_profile_img" src = "' + data[0].imageUrl +'" alt = "error" />');
                        }
                    }
                });
                
            });
            $('.edit_cut').on("click",function(){
                $('.edit_profile_box').hide();
                $('body').css("overflow-y","auto");
            });

            $('#edit_form').on("submit",function(e){
                e.preventDefault();
                // console.log("present");
                let formData = new FormData(this);
                let city = $("#city").val();
                //let userId = <?php //echo empty($_SESSION['user_id']) ? '': $_SESSION['user_id']; ?>;
                // data:{city:city,userId:userId}
                // console.log(formData);
                if($('#file').val() != "")
                {
                    $('#edit_profile_box').hide();
                    setTimeout(function(){
                        location.reload();
                        $('body').css("overflow-y","auto");
                    },1500);
                    
                }
                $.ajax({
                    url:'http://localhost/projects/scream/updateProfile.php',
                    type:"POST",
                    dataType:"JSON",
                    data:formData,
                    processData:false,
                    beforesend:function(){
                        $('#edit_form_msg').html('Loading ...').show();
                    },
                    contentType:false,
                    success:function(data){
                        // console.log(data);
                        if(data.flg == 1)
                        {
                            $('#file').val("");
                            $('.edit_profile_box').hide();
                            $('.profile_city').html('City: '+city);
                            $("#edit_profile_img").remove();
                            if(data.imageUrl)
                            $('.edit_profile_box').append('<img id= "edit_profile_img" src = "' + data.imageUrl +'" alt = "error" />');
                            $('body').css("overflow-y","auto");

                        }
                        else if(data.flg == -1)
                        {
                            
                            $('#edit_form_msg').html('You should upload an image File').show();
                            $('#file').val("");
                        }
                        else if(data.flg == -2)
                        {
                            
                            $('#edit_form_msg').html('File size should be less than 10 MB').show();
                            $('#file').val("");
                        }
                        else if(data.flg == -3)
                        {
                            
                            $('#edit_form_msg').html('Error while uploading the new Image').show();
                            $('#file').val("");
                        }
                        else if(data.flg == -4)
                        {
                            $('#edit_form_msg').html('Error while Updation').show();
                            $('#file').val("");
                        }
                        else if(data.flg == -5)
                        {
                            $('#edit_form_msg').html('No data was provided').show();
                            $('#file').val("");
                        }
                    }
                });

            });
        });
    </script>
    </body>
</html>