<?php
    require_once('./includes/autoload.php');
    header('Content-Type:application/json');
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:POST');
    header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Origin,Authorization,X-Requested-With,Content-Type');
    $gameId = empty($_POST['gameId']) ? '' : $_POST['gameId'];
    $imageName = empty($_FILES['image']) ? '' : $_FILES['image']['name'];

    if(empty($gameId) || empty($imageName))
    {
        http_response_code(200);
        echo json_encode(array("flg"=>-1));
    }
    else
    {
        $imageObj = new Image();
        $result = $imageObj->checkNumberOfImages($gameId);
        if(is_array($result))
        {
            if($result['imageCount'] >= 5)
            {
                http_response_code(200);
                echo json_encode(array("flg"=>-8));
            }
            else
            {
                $ext = explode('.',$_FILES['image']['name']);
                $ext = $ext[count($ext) - 1];
                $allowed = array("jpeg","jpg","gif","png");
                if(in_array($ext,$allowed))
                {
                    if($_FILES['image']['size'] > 5000000)
                    {
                        http_response_code(200);
                        echo json_encode(array("flg"=>-3));
                    }   
                    else
                    {
                        $gameObj = new Game();
                        $result = $gameObj->getGame($gameId);
                        if(is_array($result))
                        {
                            $timeNow = time();
                            $relative = '../public/IMAGES/' . $result['name'] . '_' . $timeNow . '.' . $ext;
                            $absolute = '../APP/public/IMAGES/' . $result['name'] . '_' . $timeNow . '.' . $ext;
                            if(move_uploaded_file($_FILES['image']['tmp_name'],$absolute))
                            {
                                $imageObj = new Image();
                                $result = $imageObj->insertImage($relative,$absolute,$gameId);
                                if(is_array($result))
                                {
                                    http_response_code(200);
                                    $data = [];
                                    $data['flg'] = 1;
                                    $data['imageId'] = $result['imageId'];
                                    $data['relative'] = $relative;
                                    echo json_encode($data);
                                }
                                else
                                {
                                    http_response_code(200);
                                    echo json_encode(array("flg"=>-5));
                                }
                            }
                            else
                            {
                                http_response_code(200);
                                echo json_encode(array("flg"=>-6));
                            }
                        }
                        else
                        {
                            http_response_code(200);
                            echo json_encode(array("flg"=>-4));
                        }
                        
                    }
                }
                else
                {
                    http_response_code(200);
                    echo json_encode(array("flg"=>-2));
                }
            }
        }
        else
        {
            http_response_code(200);
            echo json_encode(array("flg"=>-7));
        }
        @unlink($_FILES['image']['tmp_name']);
    }
?>