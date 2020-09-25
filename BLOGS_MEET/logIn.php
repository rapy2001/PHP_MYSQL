<?php 
    require_once("./includes/vars.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    $show = 0;
    $username = '';
    $password = '';
    $msg = '';
    if(!isset($_SESSION['user_id']))
    {
        if(isset($_POST['submit']))
        {
            $username = mysqli_real_escape_string($conn, trim($_POST['username']));
            $password = mysqli_real_escape_string($conn, trim($_POST['password']));
            if(empty($username))
            {
                $msg = '<h4 class = "error msg">Please Enter a Username <i class = "fa fa-times msg_cut"></i></h4>';
            }
            else if(empty($password))
            {
                $msg = '<h4 class = "error msg">Plese Enter Your Password <i class = "fa fa-times msg_cut"></i></h4>';
            }
            else
            {
                $query = "SELECT * FROM users WHERE username = '$username'";
                $results = mysqli_query($conn,$query) or die("Error while querying the database");
                if(mysqli_num_rows($results) === 0)
                {
                    $msg = '<h4 class = "error msg">Username does not exists please register <i class = "fa fa-times msg_cut"></i></h4>';
                }
                else
                {
                    $row = mysqli_fetch_array($results);
                    if($row['password'] === sha1($password))
                    {
                        setcookie('username',$row['username'],time() + 60*60);
                        setcookie('user_id',$row['user_id'], time() + 60*60);
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['user_id']  = $row['user_id'];
                        $uId = $row['user_id'];
                        if($_SESSION['username'] == "Admin")
                        {
                            header("Refresh:4;url='admin.php'");
                        }
                        else
                        {
                            header("Refresh:4;url='userDashboard.php?user_id=$uId");
                            
                        }
                        
                        echo  '<h4 class = "success msg">You have Logged In Successfully <i class = "fa fa-times msg_cut"></i></h4>';
                        $username = "";
                        $show = 0;
                    }
                    else
                    {
                        $msg = '<h4 class = "error msg">The Password is Wrong.Please Enter the password again <i class = "fa fa-times msg_cut"></i></h4>';
                    }
                    
                }
            }
        }
    }
    else
    {
        header('Refresh:4;url="homepage.php');
        echo '<h2>You are already Logged In. You will be redirected to Homepage shortly</h2>';
    }
    if($show === 0)
    {
?>
        <div class = "login">
            
            <?php 
                if(!empty($msg))
                    echo '<h2>'.$msg.'</h2>';
            ?>
            <form action = "logIn.php" method = "POST" class = "form">
                <h2>Log In</h2>
                <input type ="text" value = "<?php echo $username; ?>" placeholder = "Your Username" name = "username" autocomplete = "off"/>
                <input type ="password" placeholder = "Your Password" name = "password"/>
                <input type = "submit" name = "submit" id = "btn">
                <h4>Don't have an account ? Then <a href = "signup.php">Sign Up</a></h4>
            </form>
        </div>
<?php
    }
    mysqli_close($conn);
    require_once('./includes/footer.php');
?>