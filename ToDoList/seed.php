<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("includes/header.php");
    require_once("./includes/nav.php");
    $query = "DELETE FROM users";
    $stmt = mysqli_query($conn,$query) or die("Error while deleting the users");
    $query = "DELETE FROM todo";
    $stmt = mysqli_query($conn,$query) or die("Error while deleting the users");
    setcookie('user_id','',time()-60*60);
    setcookie('username','',time()-60*60);
    $_SESSION = array();
    header('Refresh:3;url="homepage.php"');
    echo '<div class = "empty"><h4 class = "empty_h4">database seeded successfully</h4></div>';
    require_once("./includes/footer.php");
?>