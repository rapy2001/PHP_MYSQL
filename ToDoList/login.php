<?php
    require_once("./includes/session.php");
    require_once("includes/loader.php");
    require_once("./includes/connection.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    $username = '';
    $password  = '';
    $msg = '';
    if(!empty($_POST['submit']))
    {
        if(empty($_POST['username']))
        {
            $msg = 'Username is Empty. Please Enter a Username';
        }
        else if(empty($_POST['password']))
        {
            $msg = 'Password is empty. Please Enter a Password';
        }
        else
        {
            $username = mysqli_real_escape_string($conn,trim($_POST['username']));
            $password = mysqli_real_escape_string($conn,trim($_POST['password']));
            
            $newUser = new UserController();
            $user = $newUser->getUserDetails($username,$password);
            if(!empty($user))
            {
                $hash = sha1($password);
                if($user['password'] === $hash)
                {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    setcookie('user_id',$user['user_id'],time() + 60*60);
                    setcookie('username',$user['username'],time() + 60*60);
                    $msg = 'Log In Successfull.';
                    header('Refresh:3;url="homepage.php"');
                }
                else
                {
                    $msg = 'Password is Wrong. Please Re-enter the Password';
                }
            }
            else
            {
                $username = '';
                $msg = 'Username does not exists. Please Register';
                header('Refresh:3;url="register.php"');
            }
        }
    }
?>
    <div class = "login">
        <?php
            if(!empty($msg))
                echo '<h4 class = "msg">'.$msg.'<i class = "fa fa-times msg_cut"></i></h4>';
        ?>
        <form action = "login.php" method = "POST" class = "form">
                <h3>Log In</h3>
                <input type = "text" placeholder = "Username" name = "username"value = "<?php if(!empty($username)) echo $username;?>" autocomplete = "off"/>
                <input type = "password" placeholder = "Password" name = "password"/>
                <input type = "submit" name= "submit"/>
                <h4> Don't have an Account ? Then <a  href = "register.php">Register</a></h4>
        </form>
    </div>

<?php
    require_once("./includes/footer.php");
?>