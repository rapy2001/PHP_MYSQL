<?php
    require_once("./includes/session.php");
    require_once("./includes/vars.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    $query = 
    "SELECT 
    blogs.blog_id,blogs.title, blogs.text, blogs.imageUrl, categories.category_name, users.username from 
    categories inner join blogs using(category_id) inner join users using(user_id) where approved = 1";
    $results = mysqli_query($conn,$query) or die("Error while querying the database");
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
        while($row = mysqli_fetch_array($results))
        {
?>
            <a href = "viewBlogFull.php?id=<?php echo $row['blog_id']; ?>"><?php echo $row['title'];?> <?php echo substr($row['text'],0,10);?> by: <?php echo $row['username'];?></a><br>
            
<?php
        }
    }
    mysqli_close($conn);
    require_once("./includes/footer.php");
?>