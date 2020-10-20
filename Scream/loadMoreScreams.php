<?php
    require_once("./includes/connection.php");
    require_once("./includes/loader.php");
    $page_number = empty($_POST['pageVal']) ? '' : $_POST['pageVal'];
    $userId =  empty($_POST['userId']) ? '' : $_POST['userId'];
    if($page_number == '' || $userId == '')
    {
        echo '';
    }
    else
    {
        $query = 
        "SELECT screams.scream_id,screams.user_id,screams.Scream_text,screams.scream_image,screams.created_at 
        FROM screams inner join friends  ON screams.user_id = friends.friend_id AND friends.user_id = $userId";
        $result = mysqli_query($conn,$query) or die("Error while retrieving the data");
        $limits_per_page = 2;
        $totalPages = ceil(mysqli_num_rows($result)/$limits_per_page);
        // echo $totalPages.' '.$page_number;
        $skip = ($page_number - 1) * $limits_per_page;
        $query = "SELECT screams.scream_id,screams.user_id,screams.Scream_text,screams.scream_image,screams.created_at 
        FROM screams inner join friends  ON screams.user_id = friends.friend_id AND friends.user_id = $userId LIMIT $skip,$limits_per_page";
        $result = mysqli_query($conn,$query) or die("Internal Server Error");
        if(mysqli_num_rows($result) > 0)
        {
            // echo'hello';
            while($row = mysqli_fetch_assoc($result))
            {
                $user = new User();
                $details = $user->getUserWithId($row['user_id']);
                ?>
                <div class = "feed feed_box">
                    <div class = "user_box">
                        <img src ="<?php echo $details['imageUrl'];?>" alt = "error"/>
                        <div class = "user_box_info">
                            <h3><?php echo $details['username'];?></h3>
                            <h4>
                                On: <b><?php echo substr($row['created_at'],0,10); ?></b> 
                                at: <b><?php echo substr($row['created_at'],11,5);?> </b>
                            </h4>
                        </div>
                    </div>
                    <div class = "scream_img">
                        <img src = "<?php echo $row['scream_image']; ?>" alt = "error"/>
                    </div>
                    <p class = "scream_text">
                        <?php echo $row['Scream_text']; ?>
                    </p>
                    <a class = "btn" href = "viewScream.php?scream_id=<?php echo $row['scream_id'];?>">View Scream</a>
                </div>
                <?php
            }
            ?>
            <?php
                if($page_number != $totalPages)
                {
            ?>
                <button class = "btn" id = "feed_more_btn" data-pg_val = "<?php echo ($page_number + 1) ;?>">Load More</button>            
            <?php
                }
                else
                {
                    ?>
                    <h4>No more screams were posted by your Friends ...</h4>
                    <?php
                }
            ?>
            
            <?php
        }
        else
        {
            ?>
            <h4>No more screams were posted by your Friends ...</h4>
            <?php
        }

    }

?>