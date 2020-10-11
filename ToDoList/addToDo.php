<?php
    require_once("./includes/session.php");
    require_once("./includes/loader.php");
    require_once("./includes/connection.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    if(!empty($_SESSION['user_id']))
    {
        $msg = '';
        $message = '';
        if(!empty($_POST['submit']))
        {
            if(empty($_POST['message']))
            {
                $msg = 'Enter a To Do Please';
            }
            else
            {
                $message = mysqli_real_escape_string($conn,trim($_POST['message']));
                $obj = new ToDoController();
                if($obj->addNewToDo($message,$_SESSION['user_id'])!=1)
                {
                    $msg = "There was a Problem while adding the new To Do";
                }
                else
                {
                    header('Refresh:3;url=list.php');
                    $msg = 'To Do addded Successfully to your list';
                }

            }
        }
?>
        <div>
            <?php
                echo '<h4>'.$msg.'</h4>'; 
            ?>
            <form action="addToDo.php" method="POST">
                <input type = "text" placeholder = "New To Do" name = "message" autocomplete = "off"/>
                <input type = "submit" name = "submit"/>
            </form>
        </div>
<?php
    }
    else
    {
        echo '<div><h4>You need to Log In to add to yout to do List</h4></div>';
    }
    require_once("./includes/footer.php");
?>