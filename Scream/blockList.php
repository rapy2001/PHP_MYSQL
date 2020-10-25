<?php
    require_once("./includes/loader.php");
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    
    if(!empty($_SESSION['user_id']))
    {
        $blockObj = new Block();
        $blockedUsers = $blockObj->getAllBlockedUsers($_SESSION['user_id']);
        if(count($blockedUsers) > 0)
        {
            ?>
            <div class = "blockList">
                <h1>Your Block List</h1>
                <h4 class = "scs_msg msg"></h4>
                <h4 class = "err_msg msg"></h4>
                <?php
                    foreach($blockedUsers as $blockedUser)
                    {
                        $userObj = new User();
                        $userData = $userObj->getUserWithId($blockedUser['block_id']);
                        ?>
                        <div class = "user_card">
                            <img src = "<?php echo $userData['imageUrl']?>" alt = "error"/>
                            <h2>
                                <?php echo $userData['username']?>
                            </h2>
                            <button class = "unBlk_btn btn" data-unblk = "<?php echo $userData['user_id']; ?>">Unblock</button>
                        </div>
                        <?php
                    }
                ?>
            </div>
            <?php
        }
        else
        {
            ?>
            <div class = "empty">
                <h4>Your Blocked List is Empty</h4>
            </div>
            <?php
        }
    }
    else
    {
        ?>
        <div class = "empty">
            <h4>You need to Log In to View Your Block List</h4>
        </div>
        <?php
    }
?>

<footer>
        <a href = "about.php">2020. Rajarshi Saha</a>
    </footer>
    <script src="./public/jquery.js"></script>
    <script src = "./public/index.js"></script>
    <script>
        $(document).ready(()=>{
            $('.scs_msg').hide();
            $('.err_msg').hide();
            $(document).on("click",".unBlk_btn",function(){
                let blockId = $(this).data('unblk');
                let userId = <?php echo $_SESSION['user_id']; ?>;
                
                let userDiv = $(this).closest('div');
                $.ajax({
                    url:'unBlock.php',
                    type:'POST',
                    data:{userId:userId,blockId:blockId},
                    success:function(data)
                    {
                        if(data == 0)
                        {
                            $('scs_msg').hide();
                            $('err_msg').html('No one to Unblock').show();
                        }
                        else
                        {
                            $('scs_msg').html('Unblocked Successfully').show();
                            $('err_msg').hide();
                            userDiv.fadeOut();
                        }
                    }
                });
            });
        });
    </script>
    </body>
</html>