<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    require_once("./includes/loader.php");
    $msg = '';
    $username = '';
    $password = '';
    $imageUrl = '';
    if(!empty($_POST['submit']))
    {
        if(empty($_POST{'username'}))
        {
            $msg = 'Username can\'t be Empty';
        }
        else if(empty($_POST['password']))
        {
            $msg = 'Password can\'t be empty';
        }
        else if($_FILES['file']['error'] == 0 && empty($_FILES['file']))
        {
            $msg = 'Error while uploading the image';
        }
        else if(($_FILES['file']['type'] !='image/jpeg' || $_FILES['file']['type'] !='image/jpg' || $_FILES['file']['type'] !='image/png' || $_FILES['file']['type'] !='image/gif') && empty($_FILES['file']))
        {
            $msg = 'Please Upload an Image File';
        }
        else if($_FILES['file']['size'] > 500000 && empty($_FILES['file']))
        {
            $msg = 'The size of Image can\'t be greater than 5 MB';
        }
        else
        {
            $username = mysqli_real_escape_string($conn,trim($_POST['username']));
            $password = mysqli_real_escape_string($conn,trim($_POST['password']));
            $ary = explode('.',$_FILES['file']['name']);
            $path = "./Images/User/".$username.'_'.time().'.'.$ary[count($ary) - 1];
            move_uploaded_file($_FILES['file']['tmp_name'],$path);
            $imageUrl =$path;
            // var_dump($_FILES['file']);
            $obj = new User();
            if($obj->setNewUser($username,$password,$imageUrl) == 0)
            {
                $msg = 'The username already exists. Please try a different username';
            }
            else
            {
                header('Refresh:3;url="homepage.php"');
                $username = '';
                $password = '';
                $imageUrl = '';
                $msg = 'User Registration successfull';
            }
            @unlink($_FILES['file']['tmp_name']);
        }
    }
?>
    <div>
        <?php
            if(!empty($msg))
            {
                echo '<h4>'.$msg.'</h4>';
            }
        ?>
        <form enctype = "multipart/form-data" action = "register.php" method = "POST">
            <h3>Register</h3>
            <input type = "text" name = "username" placeholder = 'User Name' value = '<?php if (!empty($username)) echo $username; ?>'autocomplete = "off"/>
            <input type = "password" name = "password" placeholder = 'Your Password' autocomplete = "off"/>
            <input type = "file" name = "file" placeholder = 'Image File'/>
            <input type = "submit" name = "submit"/>
        </form>
    </div>
    <?php
    require_once("./includes/footer.php");
?>