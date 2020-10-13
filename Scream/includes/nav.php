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
                <a href = "logout.php">Log Out (<?php echo $_SESSION['username']; ?>)</a>
                <a href = "requests.php">View Friend Requests</a>
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