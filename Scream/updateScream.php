<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/loader.php");
    require_once("./includes/nav.php");

    if(!empty($_SESSION['user_id']))
    {
        if(!empty($_GET['scream_id']))
        {
            $obj = new Scream();
            $scream = $obj->getScream($_GET['scream_id']);
            if($_SESSION['user_id'] == $scream['user_id'])
            {
                $scream_text = $scream['Scream_text'];
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
                    else if($_FILES['file']['type'] != 'image/gif' && $_FILES['file']['type'] != 'image/jpeg' && $_FILES['file']['type'] != 'image/jpg' && $_FILES['file']['type'] != 'image/png' && $_FILES['file']['size'] > 0)
                    {
                        $msg = 'You must upload an Image File';
                    }
                    else if($_FILES['file']['size'] > 1000000)
                    {
                        $msg = 'Image Size can\'t be greater than 10 MB';
                    }
                    else
                    {
                        @unlink($scream['scream_image']);
                        $scream_text = $_POST['screamText'];
                        $imageUrl = '';
                        $ary = explode('.',$_FILES['file']['name']);
                        if($_FILES['file']['size'] > 0)
                        {
                            $imageUrl = './Images/Screams/'.$_SESSION['username'].'_'.time().'.'.$ary[count($ary) - 1];
                        }
                        move_uploaded_file($_FILES['file']['tmp_name'],$imageUrl);
                        @unlink($FILES['file']['tmp_name']);
                        $obj = new Scream();
                        $obj->updateScream($_GET['scream_id'],$scream_text,$imageUrl);
                        header('Refresh:3;url="homepage.php"');
                        $msg = 'Scream updated Successfully';
                        $scream = $obj->getScream($_GET['scream_id']);
                        $scream_text = $scream['Scream_text'];
                    }
                }
            }
            else
            {
                ?>
                <div class = "empty">
                    <h4>You are not authorized to access this page</h4>
                </div>
                <?php
            }
?>
         <div>
            <?php
                if(!empty($msg))
                {
                    echo '<h4>'.$msg.'</h4>';
                }
            ?>
            <form enctype = "multipart/form-data" action = "updateScream.php?scream_id=<?php echo $_GET['scream_id']; ?>" method = "POST">
                <h3>Update Scream</h3>
                <textarea name = "screamText" placeholder = "Text" autocomplete = "off">
                    <?php if (!empty($scream_text)) echo $scream_text; ?>
                </textarea>
                <input type = "file" name = "file" />
                <?php
                    if(!empty($scream['scream_image']))
                    {
                ?>
                        <img src ="<?php echo $scream['scream_image']; ?>" alt = "error"/>
                <?php
                    } 
                ?>
                <input type = "submit" name = "submit"/>
            </form>
    </div>
<?php
        }
        else
            {
?>
                <div>
                    <h4>No Scream to Update</h4>
                </div>
<?php
            }
?>
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