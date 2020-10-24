<!DOCTYPE html>
<html>
    <head>
        <title>Movie App</title>
    </head>
    <body>
        <nav>
           <div>
                <a href = "./homepage.html">Movie App</a>
           </div>
           <div>
            <a href = "./addMovie.html">Add Movie</a>
            <a href = "./viewMovies.html">View Movies</a>
           </div>
        </nav>
        <?php
            if(!empty($_GET['id']))
            {
        ?>
                <h4 id = "msg"></h4>
                <input type = "hidden" id = "movie_id" value = "<?php echo $_GET['id']; ?>"/>
                <div id = "movie_div">

                </div>
        <?php
            }
            else
            {
        ?>
                <div>
                    <h4>No Data was Provieded</h4>
                </div>
        <?php
            }
        ?>
    </body>
    <script type = "text/javascript" src = "../public/JS/JQUERY/jquery.js"></script>
    <script type = "text/javascript" src = "../public/JS/viewMovie.js"></script>
</html>
