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
                $screamData = $obj->createScream($scream_text,$imageUrl,$_SESSION['user_id']);
                $obj = new User();
                $friends = $obj->getAllFriends($_SESSION['user_id']);
                $obj = new Notification();
                if(count($friends) > 0)
                {
                    foreach($friends as $friend)
                    {
                        echo $screamData['scream_id'];
                        $obj->addNotification($friend['friend_id'],$screamData['scream_id'],1);
                    }
                    
                }
                header('Refresh:3;url="homepage.php"');
                $msg = 'Scream created Successfully';
            }
        }
?>
         <div class = "box createScream">
            <?php
                if(!empty($msg))
                {
                    echo '<h4 class = "msg">'.$msg.'</h4>';
                }
            ?>
            <div class = "box_1">
                <form enctype = "multipart/form-data" action = "createScream.php" method = "POST" class = "form">
                    <h3>Create a Scream</h3>
                    <textarea name = "screamText" placeholder = "Text" autocomplete = "off">
                        <?php if (!empty($scream_text)) echo $scream_text; ?>
                    </textarea>
                    <h4>Image: </h4>
                    <input type = "file" name = "file" />
                    <input type = "submit" name = "submit"/>
                </form>
            </div>
            
            <div class = "box_2">

            </div>
    </div>
<?php
    }   
    else
    {
        header('header:3?url="login.php"');
?>
        <div class = "empty">
            <h4>Please Log In to Create a Scream</h4>
        </div>
<?php
    }
    require_once("./includes/footer.php");
?>