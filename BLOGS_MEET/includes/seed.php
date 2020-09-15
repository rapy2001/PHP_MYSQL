<?php 
    require_once("vars.php");
    function seed()
    {
        $query = "DELETE from users where username != 'Admin'";
        mysqli_query($GLOBALS['conn'],$query) or die("Error while deleting the users during seeding the database");
        $query = "DELETE from comments where username != 'Admin'";
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
        // $pass = sha1('12345');
        // $query = "INSERT INTO users(username,password,description) VALUES('Admin','$pass','This is the Admin')";
        // mysqli_query($GLOBALS['conn'],$query) or die("Error while creating the Admin");
    }
    seed();
    header('Refresh:3;url=../homepage.php');
    echo "Database seeded successfully";
?>