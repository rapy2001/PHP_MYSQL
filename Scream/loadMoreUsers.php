<?php
    require_once("./includes/connection.php");
    require_once("./includes/loader.php");
    $lastId = empty($_POST['lastId']) ? '':$_POST['lastId'];
    $userId = $_POST['userId'] == 'empty' ? '':$_POST['userId'];
    $limit_per_page = 2;
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn,$sql) or die("Internal Server Error");
    $total = ceil(mysqli_num_rows($result) / $limit_per_page);
    $skip = ($lastId - 1) * $limit_per_page;
    $sql = "SELECT * FROM users LIMIT $skip,$limit_per_page";
    // echo($sql);
    $result = mysqli_query($conn,$sql);
    if($result)
    {
        if(mysqli_num_rows($result) == 0)
        {
            ?>
            <div class = "load_more_btn_div">
                <h4>No More Users are available</h4>
            </div>
           
            <?php
        }
        else
        {
            while($row = mysqli_fetch_array($result))
            {
                // $lastId = $row['user_id'];
                if(!empty($userId))
                {
                    $block_obj = new Block();
                    $blk_1 = $block_obj->getBlockStatus($row['user_id'],$userId);
                    $blk_2 = $block_obj->getBlockStatus($userId,$row['user_id']);
                    $obj = new User();
                
                
                    if($blk_1 == 0 && $blk_2 == 0 && $userId != $row['user_id'])
                    {
                        $flg_1 = $obj->checkFriendshipStatus($row['user_id'],$userId);
                        $flg_2 = $obj->checkRequestStatus($userId,$row['user_id']);
                        $flg_3 = $obj->checkRequestStatus($row['user_id'],$userId);
                        
    ?>
                            <div class = "user_card">
                                <img src = "<?php echo $row['imageUrl']; ?>" alt = "error"/>
                                <h2>
                                    <?php
                                        echo $row['username'];
                                    ?>
                                </h2>
                                <a href = "profile.php?user_id=<?php echo $row['user_id']; ?>" class = "btn">View Profile</a>
    <?php
                                    if($flg_1 == 1 && $flg_2 == 1 && $flg_3 == 1 && $userId != $row['user_id'])
                                    {
    ?>
                                        <a href ="users.php?user_id=<?php echo $row['user_id']; ?>" class = "btn">Send Friend Request</a>
    <?php
                                    }
                                    if($flg_3 == 0)
                                    {
    ?>
                                        <a href ="requests.php" class = "user_msg">Has Sent you a Friend Request</a>
    <?php
                                    }
                                    if($flg_2 == 0)
                                    {
    ?>
                                        <h4 class = "user_msg">Friend Request Sent</h4>
    <?php
                                    }
                                    if($flg_1 == 1 && $userId != $row['user_id'])
                                    {
                                        ?>
                                            <div class = "load_more_btn_div"><button id = "load_more_btn" data-lst_id = "<?php echo $lastId + 1?>">Load More</button></div>
                                        <?php
                                    }
    ?>
                        </div>
    <?php
                    }
                }
                else
                {
                    ?>
                    <div class = "user_card">
                        <img src = "<?php echo $row['imageUrl'] ;?>" alt = "error"/>
                        <h2>
                            <?php
                                echo $row['username'];
                            ?>
                        </h2>
                        <h4>Please Log In to send friend requests, create screams and access other features.</h4>      
                    </div>
                    <?php
                }
            }
            ?>
                    <div class = "load_more_btn_div"><button id = "load_more_btn" data-lst_id = "<?php echo $lastId + 1?>">Load More</button></div>
            <?php
        }
    }
    else
    {
        ?>
        <h4>Something went Wrong. Please Reload the Page</h4>
        <?php
    }
    mysqli_close($conn);
?>