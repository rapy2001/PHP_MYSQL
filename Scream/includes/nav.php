<nav class = "nav">
    <div class = "nav_box_1">
        <a href = "homepage.php">Scream</a>
    </div>
    <div class = "brgr">
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div class = "nav_box_2">
        <h1 id = "cut"><i class = "fa fa-times"></i></h1>
        <a href = "register.php">Register</a>
        <a href = "users.php">View Users</a>
        
<?php 
            if(!empty($_SESSION['user_id']))
            {
?>
                <a href = "createScream.php">Create Scream</a>
                <a href = "requests.php">View Friend Requests</a>
                <a href = "profile.php?user_id=<?php echo $_SESSION['user_id']; ?>">Your Profile</a>
                <a href = "feed.php">Your Feed</a>
                <a href ="notifications.php">View Notifications</a>
                <a href ="blockList.php">View Blocked Users</a>
                <a href ="searchUsers.php">Search Users</a>
                <a href = "logout.php">Log Out (<?php echo $_SESSION['username']; ?>)</a>
                
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