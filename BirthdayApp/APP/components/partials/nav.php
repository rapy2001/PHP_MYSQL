<nav class = "nav">
    <h4 id = "logout_msg"></h4>
    <div class = "nav_box_1">
        <a href = "./homepage.php">Birthday App</a>
    </div>
    <div class = "nav_box_2">
        <a href = "./register.php">Register</a>
        <?php
            if(!empty($_SESSION['user_id']))
            {
?>
            <a href = "./addBirthday.php">Add a Birthday</a>
            <a href = "./viewAllBirthdays.php">View All Birthdays</a>
            <a href = "./viewBirthdays.php">View Today<?php echo "'"; ?>s Birthdays</a>
            <button class = "btn" id = "logout_btn">Log Out (<?php echo $_SESSION['username']; ?>)</button>
<?php
                if($_SESSION['username'] == 'Admin')
                {
?>
                    <button id = "seed_btn">Seed</button>
<?php
                }
            }
            else
            {
?>
            <a href = "./login.php">Log In</a>
<?php
            }
        ?>
    </div>
</nav>