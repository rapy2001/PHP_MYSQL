    <nav>
        <div>
            <a href = "homepage.php">ToDoList</a>
        </div>
        <div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div>
            <a href = "register.php">Register</a>
            <?php
                if(!empty($_SESSION['user_id']))
                {
            ?>
                    <a href = "list.php">Your List</a>
                    <a href = "logout.php">Log Out (<?php echo $_SESSION['username'];?>)</a>
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