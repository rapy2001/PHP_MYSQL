<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/loader.php");
    require_once("./includes/nav.php");
    $msg = '';
    ?>
    <div>
        <?php
        if(!empty($_SESSION['user_id']))
        {
            if(!empty($_GET['unfriendId']))
            {
                $obj = new User();
                $obj->deleteFriendship($_SESSION['user_id'],$_GET['unfriendId']);
                header('Refresh:3;url="friendsList.php"');
                $msg = 'Friend Removed';
            }
            if(!empty($msg))
            {
                echo '<h4>'.$msg.'</h4>';
            }
            $obj = new User();
            $friends = $obj->getAllFriends($_SESSION['user_id']);
            if(count($friends) > 0)
            {
                foreach($friends as $friend)
                {
                    $obj = new User();
                    $friendData = $obj->getUserWithId($friend['friend_id']);
                    ?>
                    
                    <div>
                        <img src = "<?php echo $friendData['imageUrl']?>" alt = "error" />
                        <h2>
                            <?php
                                echo $friendData['username'];
                            ?>
                        </h2>
                        <a href = "friendsList.php?unfriendId=<?php echo $friendData['user_id'];?>">Unfriend</a>
                    </div>
                    <?php
                }
            }
            else
            {
                ?>
                <div>
                    <h4>You have no Frineds Yet ...</h4>
                </div>
                <?php
            }
        }
        else
        {
            ?>
            <div>
                <h4>No User Selected to Show friends Of</h4>
            </div>
            <?php
        }
    ?>
    </div>
    <footer>
        <a href = "about.php">2020. Rajarshi Saha</a>
    </footer>
    </body>
</html>