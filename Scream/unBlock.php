<?php
    require_once("./includes/loader.php");
    $blockObj = new Block();
    $userId = $_POST['userId'];
    $blockId = $_POST['blockId'];
    if($blockObj->getBlockStatus($userId,$blockId) == 0)
    {
        echo 0;
    }
    else
    {
        $blockObj->unblockUser($userId,$blockId);
        echo 1;
    }

?>