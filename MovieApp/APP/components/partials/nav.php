
        <nav>
           <div>
                <a href = "./homepage.php">Movie App</a>
           </div>
           <div>
                <a href = "./addMovie.php">Add Movie</a>
                <a href = "./viewMovies.php">View Movies</a>
                <?php
                    if(empty($_SESSION['user_id']))
                    {
                ?>
                        <a href = "../components/login.php">Log In</a>
                <?php
                    }
                    else
                    {
                ?>
                        <a href = "../components/logout.php"> Log Out ( <?php echo $_SESSION['username']; ?> )</a>
                <?php
                    }
                ?>
           </div>
        </nav>
    