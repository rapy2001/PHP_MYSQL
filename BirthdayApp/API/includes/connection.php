<?php

    $serverName = "localhost";
    $dbUserName = "root";
    $password = "";
    $dbName = "small_projects";

    $conn = mysqli_connect($serverName,$dbUserName,$password,$dbName) or die("Error while connecting to the Database : " . mysqli_connect_error());
?>