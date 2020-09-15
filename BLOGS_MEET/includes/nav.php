<?php
    if(isset($_SESSION['user_id']))
    {
?> 
        <nav>
            <div>
                <a href = "homepage.php">Blogs Meet</a>
            </div>
            <div>
                <a href = "signup.php">Sign Up</a>
                <a href = "logout.php">Log Out (<?php echo $_SESSION['username'];?>)</a>
                <a href = "addBlog.php">Add a Blog</a>
                <a href = "viewBlogs.php">View Blogs</a>
                <a href = "search.php">Search</a>
                <?php 
                    if($_SESSION['username'] === 'Admin')
                        echo '<a href = "admin.php">Admin</a>';
                        echo '<a href = "./includes/seed.php">seed</a>';
                ?>
            </div>
        </nav>
<?php
    }
    else
    {
?>
        <nav>
            <div>
                <a href = "homepage.php">Blogs Meet</a>
            </div>
            <div>
                <a href = "signup.php">Sign Up</a>
                <a href = "login.php">Log In</a>
                <a href = "viewBlogs.php">View Blogs</a>
                <a href = "search.php">Search</a>
            </div>
        </nav>
<?php
    }
?>