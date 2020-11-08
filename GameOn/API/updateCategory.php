<?php
    require_once('./includes/autoload.php');
    header("Content-Type:application/json");
    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Methods:POST");
    header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Origin,Content-Type,Authorization,X-Requested-With");
    $data = json_decode(file_get_contents("php://input"),true);

    if(empty($data['updatedCategoryText']) || empty($data['categoryId']))
    {
        http_response_code(200);
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $categoryObj = new Category();
        $categoryText = strtolower($data['updatedCategoryText']);
        $flg = $categoryObj->checkCategoryStatus($categoryText);
        if($flg == 1)
        {
            $flg = $categoryObj->updateCategory($categoryText,$data['categoryId']);
            if($flg == 1)
            {
                http_response_code(200);
                echo json_encode(array("flg"=>1));
            }
            else
            {
                http_response_code(200);
                echo json_encode(array("flg"=>0));
            }
        }
        else if($flg == 2)
        {
            http_response_code(200);
            echo json_encode(array("flg"=>2));
        }
        else
        {
            http_response_code(200);
            echo json_encode(array("flg"=>0));
        }
    }
?>