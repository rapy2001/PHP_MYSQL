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
                $msg = 'Please Enter a Username';
            }
            else if(empty($password))
            {
                $msg = 'Plese Enter Your Password';
            }
            else
            {
                $query = "SELECT * FROM users WHERE username = '$username'";
                $results = mysqli_query($conn,$query) or die("Error while querying the database");
                if(mysqli_num_rows($results) === 0)
                {
                    $msg = 'Username does not exists please register';
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
                        header('Refresh:4;url="homepage.php"');
                        echo  'You have Logged In Successfully';
                        $show = 1;
                    }
                    else
                    {
                        $msg = 'The Password is Wrong.Please Enter the password again';
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
        <div>
            <h2>Log In</h2>
            <?php 
                if(!empty($msg))
                    echo '<h2>'.$msg.'</h2>';
            ?>
            <form action = "logIn.php" method = "POST">
                <input type ="text" value = "<?php echo $username; ?>" placeholder = "Your Username" name = "username"/>
                <input type ="password" placeholder = "Your Password" name = "password"/>
                <input type = "submit" name = "submit">
            </form>
        </div>
<?php
    }
    mysqli_close($conn);
    require_once('./includes/footer.php');
?>