<?php
    require_once('./includes/autoload.php');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Methods,Origin,X-Requested-With,Origin,Content-Type');
    $data = json_decode(file_get_contents('php://input'),true);
    if(empty($data['reviewId']) || empty($data['userId']))
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
                $result = $obj->deleteReview($data['reviewId']);
                if($result['flg'] == 1)
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