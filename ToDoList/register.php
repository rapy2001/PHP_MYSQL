<?php
    require_once("./includes/connection.php");
    require_once("./includes/loader.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    $username = '';
    $password = '';
    $imageUrl = '';
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
            $imageUrl = mysqli_real_escape_string($conn,trim($_POST['imageUrl']));
            $newUser = new UserController();
            if($newUser->addNewUser($username,$password,$imageUrl) == 1)
            {
                $username = '';
                $imageUrl = '';
                $msg = 'User Registartion Successfull';
                header('Refresh:3;url="homepage.php"');
            }
            else
            {
                $username = '';
                $imageUrl = '';
                $msg = 'Username already exists. Please enter a different Username.';
            }
        }
    }
?>
    <div class = "register">
        <?php
            if(!empty($msg))
                echo '<h4 class = "msg">'.$msg.'<i class = "fa fa-times msg_cut"></i></h4>';
        ?>
        <form action = "register.php" method = "POST" class = "form">
            <h3>Register</h3>
            <input type = "text" placeholder = "Username" name = "username"value = "<?php if(!empty($username)) echo $username;?>" autocomplete = "off"/>
            <input type = "password" placeholder = "Password" name = "password"/>
            <input type = "text" placeholder = "ImageUrl" name = "imageUrl" value = "<?php if(!empty($imageUrl)) echo $imageUrl;?>" autocomplete = "off"/>
            <input type = "submit" name= "submit"/>
            <h4> Already have an Account ? Then <a  href = "login.php">Log In</a></h4>
        </form>
    </div>

<?php
    require_once("./includes/footer.php");
?>