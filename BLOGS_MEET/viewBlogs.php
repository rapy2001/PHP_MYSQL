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
        echo '<div><h3>No Blogs yet ...</h3></div>';
    }
    else
    {
?>
        <div>
            <h2>Blogs</h2>
<?php
        for($i=1;$i<=4;$i++)
        {
            switch($i)
            {
                case 1:
                    echo '<h4>Politics</h4>';
                break;
                case 2:
                    echo '<h4>Entertainment</h4>';
                break;
                case 3:
                    echo '<h4>Sports</h4>';
                break;
                case 4:
                    echo '<h4>Science</h4>';
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
                    <a href = "viewBlogFull.php?id=<?php echo $row['blog_id']; ?>">
                        <?php echo $row['title'];?> <?php echo substr($row['text'],0,10);?> by: <?php echo $row['username'];?>
                    </a><br>
<?php
                }
            }
            else
            {
                echo '<h5>No Blogs in this category</h5>';
            }
        }
        // while($row = mysqli_fetch_array($results))
        // {
?>          
<?php
        // }
        if($page ==1)
        {
?>
            <a href = "#"><--</a>
<?php
        }
        else
        {
?>
            <a href="viewBlogs.php?page=<?php echo $page - 1; ?>"><--</a>
<?php
        }
        for($i=1;$i<=$mainTotal;$i++)
        {
?>
            <a href="viewBlogs.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
<?php
        }
        if($page == $mainTotal)
        {
            
?>
            <a href = "#">--></a>
<?php
        }
        else
        {
?>
            <a href="viewBlogs.php?page=<?php echo $page + 1; ?>">--></a>
<?php
        }
    }
    mysqli_close($conn);
    require_once("./includes/footer.php");
?>