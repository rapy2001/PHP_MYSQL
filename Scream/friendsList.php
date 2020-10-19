<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/loader.php");
    require_once("./includes/nav.php");
    $msg = '';
    ?>
    <div class = "friends_list">
        <h1>Your Friends</h1>
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
                    
                    <div class = "user_card">
                        <img src = "<?php echo $friendData['imageUrl']?>" alt = "error" />
                        <h2>
                            <?php
                                echo $friendData['username'];
                            ?>
                        </h2>
                        <a href = "friendsList.php?unfriendId=<?php echo $friendData['user_id'];?>" class = "btn">Unfriend</a>
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src = "./public/index.js"></script>
    </body>
</html>