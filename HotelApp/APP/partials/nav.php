<nav class = 'nav'>
    <div class = 'nav_box_1'>
        <a href = './homepage.php'>Hotel App</a>
    </div>
    <div class = 'nav_box_2'>
        <a href = './addRoom.php'>Add a Room</a>
        <a href = './editRooms.php'>Edit Rooms</a>
        <a href = './viewRooms.php'>View Rooms</a>
        <a href = './register.php'>Register</a>
        <?php
            if(empty($_SESSION['user_id']))
            {
        ?>
                <a href = './login.php'>Log In</a>
        <?php
            }
            else
            {
        ?>
                <a href = './logout.php'>Log Out (<?php echo $_SESSION['username']; ?>)</a>
        <?php
            }
        ?>
    </div>
</nav>