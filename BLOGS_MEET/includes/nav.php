<?php
    if(isset($_SESSION['user_id']))
    {
?> 
        <nav class = "nav">
            <div class = "nav_box_1">
                <a href = "homepage.php">Blogs Meet</a>
            </div>
            <div class = "nav_box_2">
                <div><h1 class = "nav_cut"><i class = "fa fa-times"></i></h1></div>
                <a href = "signup.php">Sign Up</a>
                <a href = "logout.php">Log Out (<?php echo $_SESSION['username'];?>)</a>
                <a href = "addBlog.php">Add a Blog</a>
                <a href = "viewBlogs.php">View Blogs</a>
                <a href = "search.php">Search</a>
                <a href = "topWriters.php">Top 10 Writers</a>
                <?php 
                    if($_SESSION['username'] === 'Admin')
                    {
                        echo '<a href = "admin.php">Admin</a>';
                        echo '<a href = "./includes/seed.php">seed</a>';
                    }
                        
                ?>
            </div>
            <div class = "nav_box_3 brgr">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </nav>
<?php
    }
    else
    {
?>
        <nav class = "nav">
            <div class = "nav_box_1">
                <a href = "homepage.php">Blogs Meet</a>
            </div>
            <div class = "nav_box_2">
                <div><h1 class = "nav_cut"><i class = "fa fa-times"></i></h1></div>
                <a href = "signup.php">Sign Up</a>
                <a href = "login.php">Log In</a>
                <a href = "viewBlogs.php">View Blogs</a>
                <a href = "search.php">Search</a>
                <a href = "topWriters.php">Top 10 Writers</a>
            </div>
            <div class = "nav_box_3 brgr">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </nav>
<?php
    }
?>