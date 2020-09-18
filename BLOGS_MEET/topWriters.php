<?php
    require_once("./includes/vars.php");
    require_once("./includes/session.php");
    require_once("./includes/nav.php");
    $query = "SELECT * FROM USERS WHERE totalViews > 0 ORDER BY totalViews LIMIT 10 ";
    $results=mysqli_query($conn,$query) or die("Error while querying the database");
    if(mysqli_num_rows($results) > 0)
    {
?>
        <div>
            <h1>Top 10 Writers</h1>
        </div>
<?php
        while($row = mysqli_fetch_array($results))
        {
?>
            <div>
                <img src= "<?php echo $row['userImage']; ?>"/>
                <h1><?php echo $row['username']; ?></h1>
                <p>
                    <?php echo $row['description']; ?>
                </p>
                <h1><?php echo $row['totalViews']; ?></h1>
            </div>
<?php
        }
    }
    else
    {
        echo "No blogs posted  yet";
    }
    require_once("./includes/footer.php");
    mysqli_close($conn);
?>