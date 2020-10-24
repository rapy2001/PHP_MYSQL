<?php
    require_once("../../API/Includes/connection.php");
    require_once("../../API/Includes/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <h4 id = "msg"></h4>
        <div>
            <h1>Movies</h1>
            <div id = "movies_div">
                
            </div>
        </div>
        <script type = "text/javascript" src = "../public/JS/JQUERY/jquery.js"></script>
        <script type = "text/javascript" src = "../public/JS/viewMovies.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>