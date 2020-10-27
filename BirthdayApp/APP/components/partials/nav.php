<nav>
    <h4 id = "logout_msg"></h4>
    <div>
        <a href = "./homepage.php">Birthday App</a>
    </div>
    <div>
        <a href = "./register.php">Register</a>
        <?php
            if(!empty($_SESSION['user_id']))
            {
?>
            <a href = "./addBrthday.php">Add a Birthday</a>
            <a href = "./viewAllBirthdays.php">View All Birthdays</a>
            <button id = "logout_btn">Log Out (<?php echo $_SESSION['username']; ?>)</button>
<?php
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