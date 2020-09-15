<?php
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    require_once('./includes/vars.php');
    $username = '';
    $password = '';
    $description = '';
    $file = '';
    $msg = '';
    $sub = 0;
    if(isset($_POST['submit']))
    {
        $sub = 1;
        $username = mysqli_real_escape_string($conn,trim($_POST['username']));
        $password = mysqli_real_escape_string($conn,trim($_POST['password']));
        $description = mysqli_real_escape_string($conn,trim($_POST['description']));
        $file = $_FILES['file'];
        // var_dump($file);
        if(empty($username))
        {
            $msg = 'Please Enter a Username';
            $sub = 0;
        }
            
        else if(empty($password))
        {
            $msg = 'Please Enter a Password';
            $sub = 0;
        }
            
        else if(!empty($file['tmp_name']) && $file['error'] === 1)
        {
            $msg = 'There was an error while uploading the file';
            $sub = 0;
        }
            
        else if($file['size'] > 5242880)
        {
            $msg = 'Size of image must be less than or equal to 5 MB';
            $sub = 0;
        }
            
        else if(!empty($file['name']) && $file['type'] != 'image/jpg' && $file['type'] != 'image/jpeg' && $file['type'] != 'image/png' && $file['type'] != 'image/gif')
        {
            $msg = 'Please Enter a image file';
            $sub = 0;
        }
            
        else
        {
            $query = "SELECT username FROM users WHERE username='$username'";
            $results = mysqli_query($conn,$query);
            if(mysqli_num_rows($results) === 0)
            {
                if(empty($file['name']))
                    $path = 'EMPTY';
                else
                    $path = './IMAGES/USERS/'.$username.time().$file['name'];
                if(empty($description))
                    $description = 'No Description Provided';
                move_uploaded_file($file['tmp_name'], $path);
                $password = sha1($password);
                $query = "INSERT INTO users VALUES(0,'$username','$password','$path','$description')";
                mysqli_query($conn, $query) or die("Error while querying the database");
                header('Refresh:4;url="homepage.php');
                echo '<h2>'.$msg = 'User Registration Successfull You will be Redirected shortly'.'</h2>';
            }
            else
            {
                $msg = 'The username already exits please try a different username';
                $sub = 0;
            }
        }
        @unlink($file['tmp_name']);
    }
    if($sub === 0)
    {
?>
        <div>
            <?php
                if(!empty($msg))
                    echo '<h2>'.$msg.'</h2>'; 
            ?>
            <form enctype = "multipart/form-data" method = "POST" action = "signUp.php">
                <h3>Sign Up</h3>
                <input type = "text" name = "username"  placeholder = "User Name" value = "<?php echo $username; ?>" autocomplete ="off">
                <input type = "password" name = "password"  placeholder = "Password">
                <input type = "file" name = "file" >
                <textarea placeholder = "Describe Yourself" name = "description" autocomplete ="off"><?php echo $description; ?></textarea>
                <input type = "submit" name = "submit">
            </form>
        </div>
    <?php
    }
    require_once("./includes/footer.php");
    mysqli_close($conn);
    ?>