<?php

spl_autoload_register("loader");

function loader($className)
{
    $path = "classes/".$className.".class.php";
    if(!file_exists($path))
    {
        return 0;
    }
    require_once($path);
}