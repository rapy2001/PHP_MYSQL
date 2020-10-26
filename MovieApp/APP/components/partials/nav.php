
        <nav class= "nav">
           <div class = "nav_box_1">
                <a href = "./homepage.php">Movie App</a>
           </div>
           <button id = "brgr">M</button>
           <div class = "nav_box_2">
                <div class = "nav_cut_div"><h4 class = "nav_cut"><i class = "fa fa-times"></i></h4></div>
                <a href = "./addMovie.php">Add Movie</a>
                <a href = "./viewMovies.php">View Movies</a>
                <a href = "./register.php">Register</a>
                <a href = "./search.php">search</a>
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
                        if($_SESSION['username'] == 'Admin')
                        {
                            ?>
                            <button id = "seed">Seed</button>
                            <?php
                        }
                    }
                ?>
           </div>
        </nav>
    