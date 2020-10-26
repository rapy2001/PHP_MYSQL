<?php
    require_once("../../API/Includes/connection.php");
    require_once("../../API/Includes/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <h4 id = "msg" class = "msg"></h4>
        <div class = "movies">
            <h1>Movies</h1>
            <div id = "movies_div">
                
            </div>
        </div>
        <footer class = "footer">
            <h4>2020. Rajarshi Saha.</h4>
        </footer>
        <script type = "text/javascript" src = "../public/JS/JQUERY/jquery.js"></script>
        <script type = "text/javascript" src = "../public/JS/seed.js"></script>
        <script type = "text/javascript" src = "../public/JS/viewMovies.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>