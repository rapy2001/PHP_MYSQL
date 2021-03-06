<?php
    require_once("./includes/session.php");
    require_once("./includes/connection.php");
    require_once("./includes/loader.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    $username = empty($_POST['username']) ? '':$_POST['username'];
    $password = '';
    $msg = '';
    if(!empty($_POST['submit']))
    {
        if(empty($_POST['username']))
        {
            $msg = 'Username can not be Empty';
        }
        else if(empty($_POST['password']))
        {
            $msg = 'Password can not be empty';
        }
        else
        {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $obj = new User();
            $user = $obj->getUser($username);
            if($user == 0)
            {
                header('Refresh:3;url="register.php"');
                $msg = 'No such usernmae Exists';
            }
            else
            {
                if($user['password'] == sha1($password))
                {
                    setcookie('user_id',$user['user_id'],time()+60*60);
                    setcookie('username',$user['username'],time()+60*60);
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    header('Refresh:3;url="feed.php"');
                    $msg = 'Logged In Successfully';
                }
                else
                {
                    $msg = 'The Password is Wrong';
                }

            }
        }
    }
?>
        <div class = "box login">
            <?php
                if(!empty($msg))
                {
                    echo '<h4 class = "msg">'.$msg.'<i class = "fa fa-times msg_cut"></i></h4>';
                }
            ?>
            <div class = "box_1">
                <form action = "login.php" method = "POST" class = "form">
                    <h3>Log In</h3>
                    <input type = "text" name = "username" placeholder = 'User Name' value = '<?php if (!empty($username)) echo $username; ?>'autocomplete = "off"/>
                    <input type = "password" name = "password" placeholder = 'Your Password' autocomplete = "off"/>
                    <input type = "submit" name = "submit"/>
                    <h4>Don't have an account ? Then <a href = "register.php">Register</a></h4>
                </form>
            </div>
            <div class = "box_2">

            </div>
    </div>
<?php
    require_once("./includes/footer.php");
?>