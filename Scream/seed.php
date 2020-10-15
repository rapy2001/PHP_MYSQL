<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/loader.php");
    require_once("./includes/nav.php");

    if($_SESSION['username'] == 'Admin')
    {
        $query = "DELETE FROM users WHERE username <> 'Admin'";
        mysqli_query($conn,$query) or die("Error while deleting the users");
        $query = "DELETE FROM requests";
        mysqli_query($conn,$query) or die("Error while deleting the firend Request");
        $query = "DELETE FROM friends";
        mysqli_query($conn,$query) or die("Error while deleting the friends");
        $query = "DELETE FROM screams WHERE scream_id <> 9";
        mysqli_query($conn,$query) or die("Error while deleting the screams");
        $query = "DELETE FROM comments WHERE comment_id <> 7";
        mysqli_query($conn,$query) or die("Error while deleting the comments");
        $query = "DELETE FROM likes WHERE like_id <> 28";
        mysqli_query($conn,$query) or die("Error while deleting the likes");
        $query = "DELETE FROM notifications";
        mysqli_query($conn,$query) or die("Error while deleting the notifications");
        // $password =  sha1('12345');
        // $query = "INSERT INTO users VALUES(0,'Admin,$password,'https://cdn.dribbble.com/users/556848/screenshots/6660123/admin_4x.png?compress=1&resize=800x600'";
        // mysqli_query($conn,$query) or die("Error while creating the Admin");
        header('Refresh:3;url="homepage.php"');
        echo '<div><h4>Database seeded successfully</h4></div>';
        
    }
    else
    {
?>
        <div>
            <h4>You need Admin access to Seed the database</h4>
        </div>
<?php
    }
    require_once("./includes/footer.php");
?>