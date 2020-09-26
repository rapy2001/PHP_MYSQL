<?php
    require_once("./includes/session.php");
    require_once("./includes/vars.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    $page = empty($_GET['page']) ? 1: $_GET['page'];
    $step = 2;
    $total = 0;
    $skip = 0;
    $query = 
        "SELECT 
        blogs.blog_id,blogs.title, blogs.text, blogs.imageUrl, categories.category_name, users.username from 
        categories inner join blogs using(category_id) inner join users using(user_id) where approved = 1";    
    $results = mysqli_query($conn,$query) or die("Error while querying the database");
    // $mainTotal = ceil(mysqli_num_rows($results) / $step);
    $mainTotal = -1;
    if(mysqli_num_rows($results) === 0)
    {
        echo '<div id = "empty_div"><h2 id= "empty">No Blogs yet ...</h2></div>';
    }
    else
    {
?>
        <div class = "blogs">
            <h2 class = "blogs_heading">Blogs</h2>
            <div class ="category">
<?php
                for($i=1;$i<=4;$i++)
                {
                    switch($i)
                    {
                        case 1:
                            echo '<h3 class ="category">Politics</h3>';
                        break;
                        case 2:
                            echo '<h3 class ="category">Entertainment</h3>';
                        break;
                        case 3:
                            echo '<h3 class ="category">Sports</h3>';
                        break;
                        case 4:
                            echo '<h3 class ="category">Science</h3>';
                        break;
                    }
        ?>
        <?php
                    $query = "SELECT * from blogs where category_id='$i' and approved=1";
                    $result = mysqli_query($conn,$query) or die("Error while querying the darabase");
                    $total =ceil(mysqli_num_rows($result) / $step);
                    if($total > $mainTotal)
                        $mainTotal = $total;
                    $skip = ($page-1) * $step;
                    // $query = "SELECT * from blogs where category_id='$i' and approved=1 limit $skip,$step";
                    $query = 
                        "SELECT 
                        blogs.blog_id,blogs.title, blogs.text, blogs.imageUrl, categories.category_name, users.username from 
                        categories inner join blogs using(category_id) inner join users using(user_id) where approved = 1 and category_id='$i' limit $skip,$step";
                    $results = mysqli_query($conn,$query) or die("Error while querying the database");
                    if(mysqli_num_rows($results)>0)
                    {
                        while($row = mysqli_fetch_array($results))
                        {
        ?>
                            <a class = "blog_item" href = "viewBlogFull.php?id=<?php echo $row['blog_id']; ?>">
                                <img src = "<?php echo $row['imageUrl']; ?>"/>
                                <span class = "title"><?php echo $row['title'];?>  </span>
                                <p>
                                    <?php echo substr($row['text'],0,50);?>
                                </p>
                                <span class = "by">
                                    by: 
                                    <?php echo $row['username'];?>
                                </span>
                            </a>
        <?php
                        }
                    }
                    else
                    {
                        echo '<h5 class = "empt">No Blogs in this category</h5>';
                    }
                }
            // while($row = mysqli_fetch_array($results))
            // {
    ?>        
            </div>  
            <div class = "pages">
                <?php
                        // }
                        if($page ==1)
                        {
                ?>
                            <a href = "#"><i class = "fa fa-angle-left"></i></a>
                <?php
                        }
                        else
                        {
                ?>
                            <a href="viewBlogs.php?page=<?php echo $page - 1; ?>"><i class = "fa fa-angle-left"></i></a>
                <?php
                        }
                        for($i=1;$i<=$mainTotal;$i++)
                        {
                ?>
                            <a id="<?php if($page == $i) echo "pg_selec" ?>" href="viewBlogs.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php
                        }
                        if($page == $mainTotal)
                        {
                            
                ?>
                            <a href = "#"><i class = "fa fa-angle-right"></i></a>
                <?php
                        }
                        else
                        {
                ?>
                            <a href="viewBlogs.php?page=<?php echo $page + 1; ?>"><i class = "fa fa-angle-right"></i></a>
                <?php
                        }
                ?>
            </div>
        </div>
<?php
    }
    mysqli_close($conn);
    require_once("./includes/footer.php");
?>