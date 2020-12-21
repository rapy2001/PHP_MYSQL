<?php
    spl_autoload_register('loadClass');

    function loadClass($name)
    {
        $path = './classes/' . $name . '.class.php';
        require_once($path);
    }
?>