<?php
    require_once("./includes/autoload.php");
    header('Content-Type:application/json');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Origin,Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With');
    $categoryObj = new category();

    $categories = $categoryObj->getCategories();
    if($categories == -1)
    {
        echo json_encode(array("flg"=>-1));
    }
    else if($categories == -2)
    {
        echo json_encode(array("flg"=>-2));
    }
    else
    {
        echo json_encode(array("flg"=>1,"categories"=>$categories));
    }
?>