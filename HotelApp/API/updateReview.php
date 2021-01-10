<?php
    require_once('./includes/autoload.php');
    require_once('./includes/autoload.php');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Methods,Origin,X-Requested-With,Authorization,Content-Type');

    $data = json_decode(file_get_contents('php://input'),true);
    if(empty($data['userId']) || empty($data['reviewId']) || empty($data['review']) || empty($data['rating']))
    {
        http_response_code(400);
        echo json_encode(array('flg' => -1, 'data' => $data));
    }
    else
    {
        $obj = new Review();
        $results = $obj->getReviewById($data['reviewId']);
        if($results['flg'] == 1)
        {
            if($results['review']['user_id'] == $data['userId'])
            {
                $results = $obj->updateReview($data['review'],$data['rating'],$data['reviewId']);
                if($results['flg'] == 1)
                {
                    echo json_encode(array('flg' => 1));
                }
                else
                {
                    http_response_code(500);
                    echo json_encode(array('flg' => 0, 'err' => $results['err']));
                }
            }
            else
            {
                echo json_encode(array('flg' => 2));
            }
        }
        else
        {
            http_response_code(500);
            echo json_encode(array('flg' => 0, 'err' => $results['err']));
        }
    }
?>