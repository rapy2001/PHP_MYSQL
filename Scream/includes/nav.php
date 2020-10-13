<nav>
    <div>
        <a href = "homepage.php">Scream</a>
    </div>
    <div></div>
    <div>
        <a href = "register.php">Register</a>
        <a href = "users.php">View Users</a>
        
<?php 
            if(!empty($_SESSION['user_id']))
            {
?>
                <a href = "createScream.php">Create Scream</a>
                <a href = "logout.php">Log Out (<?php echo $_SESSION['username']; ?>)</a>
                <a href = "requests.php">View Friend Requests</a>
                <a href = "yourScreams.php">Your Screams</a>
                <a href = "feed.php">Your Feed</a>
                <?php
                    if($_SESSION['username'] == 'Admin')
                    {
?>
                        <a href = "seed.php">Seed</a>
<?php
                    }
                ?>
        <?php
            }
            else
            {
        ?>
                <a href = "login.php">Log In</a>
        <?php
            }
        ?>
    </div>
</nav>