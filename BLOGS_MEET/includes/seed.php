<?php 
    require_once("vars.php");
    require_once("./session.php");
    function seed()
    {
        $query = "SELECT userImage from users";
        $results = mysqli_query($GLOBALS['conn'],$query) or die("Error while deleting the user images");
        if(mysqli_num_rows($results)>0)
        {
            echo mysqli_num_rows($results);
            while($row = mysqli_fetch_array($results))
            {
                // echo $row['userImage'];
                @unlink($row['userImage']);
            }
        }
        $query = "DELETE from users where username != 'Admin'";
        mysqli_query($GLOBALS['conn'],$query) or die("Error while deleting the users during seeding the database");
        $query = "DELETE from comments";
        mysqli_query($GLOBALS['conn'],$query) or die("Error while deleting the comments during seeding the database");
        $query  = "SELECT * from blogs";
        $results = mysqli_query($GLOBALS['conn'],$query) or die("Error while deleting the blogs in the seed");
        if(mysqli_num_rows($results) > 0)
        {
            while($row = mysqli_fetch_array($results))
            {
                @unlink($row['imageUrl']);
                $query = "DELETE FROM blogs where blog_id=".$row['blog_id'].";";
                mysqli_query($GLOBALS['conn'],$query) or die("Error while deleting a single blog");
            }
        }
        $query = "DELETE from likes";
        mysqli_query($conn,$query) or die("Error while deleting the likes");
        // $pass = sha1('12345');
        // $query = "INSERT INTO users(username,password,description) VALUES('Admin','$pass','This is the Admin')";
        // mysqli_query($GLOBALS['conn'],$query) or die("Error while creating the Admin");
    }
    if(isset($_SESSION['username']) && $_SESSION['username'] === "Admin")
        seed();
    else
        echo "You need Admin access to seed the database";
    header('Refresh:3;url=../homepage.php');
    echo "Database seeded successfully";
?>