<?php
// Create a 100*30 image
    require_once("./includes/session.php");
    $captcha = "";
    for($i=0;$i<=5;$i++)

        $captcha.=chr(rand(97,122));
    $_SESSION['captcha'] = sha1($captcha);
    $img = imagecreate(100, 30);
$width = 100;
$height = 30;
// White background and blue text
    $bg_color = imagecolorallocate($img,255,255,255);
    $red = imagecolorallocate($img, 255,0,0);
    $blue = imagecolorallocate($img,0, 102, 255);
    $text = imagecolorallocate($img, 0, 102, 255);
    imagefilledrectangle($img,0,0,$width,$height,$bg_color);
    for($i=1;$i<=5;$i++)
    {
        imageline($img,0,rand() % $height,rand() % $width,rand() % $height,$red);
    }
    for($i=1;$i<=25;$i++)
    {
        imagesetpixel($img,rand() % $width,rand() % $height,$blue);
    }
// Write the string at the top left
imagestring($img, 5, 0, 5, $captcha, $text);

// Output the image
header('Content-type: image/png');

imagepng($img);
imagedestroy($img);

?>
