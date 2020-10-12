<nav>
    <div>
        <h2>Scream</h2>
    </div>
    <div></div>
    <div>
        <a href = "register.php">Register</a>
        <?php 
            if(!empty($_SESSION['user_id']))
            {
        ?>
                <a href = "logout.php">Log Out<?php echo $_SESSION['usernmae']; ?></a>
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