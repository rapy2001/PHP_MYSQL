<?php 
    require_once("./includes/session.php");
    require_once("./includes/vars.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    $show = 1;
    $msg = '';
    $title = '';
    $text = '';
    $imageUrl = '';
    if(isset($_SESSION['user_id']))
    {
        $show = 0;
        if(isset($_POST['submit']))
        {
            $show = 1;
            $title = $_POST['title'];
            $text = $_POST['text'];
            $file = $_FILES['file'];
            $title = mysqli_real_escape_string($conn, trim($title));
            $text = mysqli_real_escape_string($conn, trim($text));
            if(isset($_POST['category']))
                $category = $_POST['category'];
            else
                $category = '';
            if(empty($title))
            {
                $msg = 'Please Enter the Title of the Blog';
                $show = 0;
            }
            else if(empty($text))
            {
                $msg = 'Please Enter the Text of the Blog';
                $show = 0;
            }
            else if(!empty($file['name']) && $file['error'] === 1)
            {
                $msg = 'There was an Error while uplading the image.Please Enter the Blog Image again';
                $show = 0;
            }
            else if($file['size'] > 5242880)
            {
                $msg = 'Size of image must be less than or equal to 5 MB';
                $show = 0;
            }
            else if(!empty($file['name']) && $file['type'] != 'image/jpg' && $file['type'] != 'image/jpeg' && $file['type'] != 'image/png' && $file['type'] != 'image/gif')
            {
                $msg = 'Please Enter a image file';
                $show = 0;
            }
            else if(empty($category))
            {
                $msg = 'Please select a category for your blog';
                $show = 0;
            }
            else
            {
                $path = '';
                if(empty($file['name']))
                    $path = 'EMPTY';
                else
                {
                    $path = './IMAGES/BLOGS/'.$_SESSION['username'].'_'.time().$file['name'];
                }
                move_uploaded_file($file['tmp_name'],$path);
                $id = $_SESSION['user_id'];
                $query = "INSERT INTO blogs VALUES(0,NOW(),'$id','$category','$title','$text','$path',0,0,0)";
                mysqli_query($conn,$query) or die("There was Error while querying the database");
                header('Refresh:4;url="homepage.php"');
                echo 'The Blog has been submiited for Approval';
                $show = 1;
                
            }

        }
    }
    else
    {
        header('Refresh:4;url="logIn.php"');
        echo 'Please Log In To Add a Blog. You will be Redirected to the Log In Page Shortly.';
    }
    if($show === 0)
    {
?>
    <div class = "addBlog">
        <?php 
            if(!empty($msg))
            {
                echo '<h2>'.$msg.'</h2>';
            }
        ?>
        <form enctype = "multipart/form-data" action = "addBlog.php" method = 'POST' class = "form">
            <h2>Add a Blog</h2>
            <input type = "text" placeholder = "Title of Blog" name = "title" value = "<?php echo $title; ?>" autocomplete="off"/>
            <input type = "file" name = "file" />
            <textarea name = "text" placeholder = "Your Blog Text"><?php echo $text; ?></textarea>
            <div class = "categories">
                <lable for = "politics">Politics</label>
                <input type = "radio" name = "category" value = "1" id = "politics" />
                <lable for = "entertainment">Entertainment</label>
                <input type = "radio" name = "category" value = "2" id = "entertainment" />
                <lable for = "sports">Sports</label>
                <input type = "radio" name = "category" value = "3" id = "sports" />
                <lable for = "science">Science</label>
                <input type = "radio" name = "category" value = "4" id = "science" />
            </div>
            <input type = "submit" name = "submit" class = "btn"/>
        </form>
    </div>
<?php
    }
    mysqli_close($conn);
    require_once("./includes/footer.php");
?>