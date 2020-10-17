<?php
    require_once("./includes/loader.php");
    $user_id = $_POST['userId'];
    $block_id = $_POST['blockId'];
    $userObj = new User();
    if($userObj->getUserWithId($user_id) == 0)
    {
        echo -2;
    }
    elseif($userObj->checkFriendshipStatus($user_id,$block_id) == 0)
    {
        echo -1;
    }
    else
    {
        $blockObj = new Block();
        if($blockObj->getBlockStatus($user_id,$block_id))
        {
            echo 0;
        }
        else
        {
            $blockObj->blockUser($user_id,$block_id);
            echo 1;
        }
    }
?>