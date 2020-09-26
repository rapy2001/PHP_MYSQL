<?php
    require_once("./includes/vars.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    $query = "SELECT * FROM USERS WHERE totalViews > 0 ORDER BY totalViews DESC LIMIT 10";
    $results=mysqli_query($conn,$query) or die("Error while querying the database");
    if(mysqli_num_rows($results) > 0)
    {
        $count = 1;
?>
        <div class = "top_wrt">
            <h1>Top 10 Writers</h1>
            <div class = "top_wrt_box">
                <?php
                        while($row = mysqli_fetch_array($results))
                        {
                ?>
                            <div class = "blog_item">
                                <h2><?php echo $count; ?></h2>
                                <img src= "<?php echo $row['userImage']; ?>"/>
                                <h1><?php echo $row['username']; ?></h1>
                                <p>
                                    <?php echo $row['description']; ?>
                                </p>
                                <h1><?php echo $row['totalViews']; ?></h1>
                            </div>
                <?php
                        $count +=1;
                        }
                ?>
            </div>
        </div>
<?php
        
    }
    else
    {
        echo "<div id = 'empty_div'><h2 id = 'empty'>No blogs posted  yet</h2></div>";
    }
    require_once("./includes/footer.php");
    mysqli_close($conn);
?>