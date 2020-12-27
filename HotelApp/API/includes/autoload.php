<?php
    spl_autoload_register('load');

    function load ($className)
    {
        $path = './classes/' . $className . '.class.php';
        require_once($path);
    }

?>