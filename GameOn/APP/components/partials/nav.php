<nav class = "nav">
    <div class = "nav_box_1">
        <a href = './homepage.php'>Game On</a>
    </div>
    <div class = "nav_box_2">
<?php
    if(!empty($_SESSION['username']))
    {
?>
        <a href = 'logout.php'>Log Out ( <?php echo $_SESSION['username']; ?> ) </a>
<?php
        if($_SESSION['username'] == 'Admin')
        {
?>
            <a href = 'addGame.php'>Add a Game</a>
            <a href = 'categories.php'>View Categories</a>
            <a href = 'platforms.php'>View Platforms</a>
<?php
        }
    }
    else
    {
?>
        <a href = './login.php'>Log In</a>
<?php
    }
?>
        <a href = 'viewGames.php'>View Games</a>
        <a href = 'register.php'>Register</a>
    </div>
</nav>