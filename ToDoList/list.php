<?php
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    require_once("./includes/loader.php");
    if(!empty($_SESSION['user_id']))
    {
        $msg = '';
        $userId = $_SESSION['user_id'];
        $obj = new ToDoController();
        $list = $obj->getAllToDo($_SESSION['user_id']);
        $user = new UserController();
        $details = $user->getUserDetails($_SESSION['username']);
        if(!empty($_GET['check']))
        {
            if($obj->updateToDoItem($_GET['check']) != 1)
            {
                $msg = 'There was an Error while updating the list';
            }
            else
            {
                header('Refresh:3;url="list.php"');
            }
        }
        if(!empty($_GET['delete']))
        {
            if($obj->deleteToDoItem($_GET['delete']) != 1)
            {
                $msg = 'There was an Error while deleting the To Do Item';
            }
            else
            {
                header('Refresh:3;url="list.php"');
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
            <div>
                <img src = "<?php echo $details['imageUrl'];?>" alt = "error"/>
                <h2><?php echo $details['username']; ?></h2>
            </div>
            <div>
                <h3>Your ToDo List</h3>
                <a href = "addToDo.php">Add a To Do</a>
                <?php
                    if(count($list)>0)
                        foreach($list as $item)
                        {
                            
                    ?>  
                        <div>
                            <a href = "list.php?check=<?php echo $item['id'];?>">
                                <?php 
                                    echo 
                                        ($item['checked'] == 'Y') 
                                        ?  
                                        'Uncheck':
                                        'check'; 
                                ?>
                            </a>
                            <h4 class ="<?php echo ($item['check'] == 'Y') ? 'checked':''; ?>"><?php echo $item['message'];?></h4>
                        <a href = "list.php?delete=<?php echo $item['id'];?>">
                                Delete
                        </a>
                        </div>
                    <?php
                        }
                    else
                        echo '<div><h4>No To Do ....</h4></div>';
                    ?>
            </div>
        </div>
<?php
        
    }
    else
    {
        echo '<div><h4>You need to be Logged in in order to access this page</h4></div>';
    }
    require_once("./includes/footer.php");
?>