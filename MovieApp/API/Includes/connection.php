<?php
    $serverName = "localhost";
    $dbName = "movie";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($serverName,$username,$password,$dbName) or die("Error while connecting to the database");

?>