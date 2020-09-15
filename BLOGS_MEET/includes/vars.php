<?php 
    $dbLocation = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'blogs_meet';

    $conn = mysqli_connect($dbLocation, $dbUsername, $dbPassword, $dbName) or die('There was an error while connecting to the database');
?>