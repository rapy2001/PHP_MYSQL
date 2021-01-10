<?php
    require_once('./includes/autoload.php');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Methods,Origin,X-Requested-With,Authorization,Content-Type');
    $reviewId = empty($_GET['id']) ? -1 : $_GET['id'];

    if($reviewId == -1)
    {
        http_response_code(400);
        echo json_encode(array('flg'  => -1));
    }
    else
    {
        $obj = new Review();
        $results = $obj->getReviewById($reviewId);
        if($results['flg'] == 1)
        {
            echo json_encode(array('flg' => 1 , 'review' => $results['review']));
        }
        else
        {
            http_response_code(500);
            echo json_encode(array('flg' => 0));
        }
    }
?>