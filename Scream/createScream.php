<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/loader.php");
    require_once("./includes/nav.php");

    if(!empty($_SESSION['user_id']))
    {
        $scream_text = empty($_POST['screamText']) ? '':mysqli_real_escape_string($conn,trim($_POST['screamText']));
        $msg = '';
        if(!empty($_POST['submit']))
        {
            if(empty($_POST['screamText']))
            {
                $msg = 'Scream text can\' be empty';
            }
            else if($_FILES['file']['error'] == 1 && $_FILES['file']['size'] > 0)
            {
                $msg = 'Errror while uploading the scream image';
            }
            else if($_FILES['file']['type'] != 'image/gif' && $_FILES['file']['type'] != 'image/jpeg' && $_FILES['file']['type'] != 'image/jpg' && $_FILES['file']['type'] != 'image/gif')
            {
                $msg = 'You must upload an Image File';
            }
            else if($_FILES['file']['size'] > 1000000)
            {
                $msg = 'Image Size can\'t be greater than 10 MB';
            }
            else
            {
                $imageUrl = '';
                $ary = explode('.',$_FILES['file']['name']);
                if($_FILES['file']['size'] > 0)
                {
                    $imageUrl = './Images/Screams/'.$_SESSION['username'].'_'.time().'.'.$ary[count($ary) - 1];
                }
                move_uploaded_file($_FILES['file']['tmp_name'],$imageUrl);
                @unlink($FILES['file']['tmp_name']);
                $obj = new Scream();
                $obj->createScream($scream_text,$imageUrl,$_SESSION['user_id']);
                header('Refresh:3;url="homepage.php"');
                $msg = 'Scream created Successfully';
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
            <form enctype = "multipart/form-data" action = "createScream.php" method = "POST">
                <h3>Create a Scream</h3>
                <textarea name = "screamText" placeholder = "Text" autocomplete = "off">
                    <?php if (!empty($scream_text)) echo $scream_text; ?>
                </textarea>
                <input type = "file" name = "file" />
                <input type = "submit" name = "submit"/>
            </form>
    </div>
<?php
    }   
    else
    {
        header('header:3?url="login.php"');
?>
        <div>
            <h4>Please Log In to Create a Scream</h4>
        </div>
<?php
    }
    require_once("./includes/footer.php");
?>