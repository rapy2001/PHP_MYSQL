<?php
    require_once("../../API/Includes/connection.php");
    require_once("../../API/Includes/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <div>
            <input type = "text" placeholder = "serach a Movie" id = "search"/>
        </div>
        <div id = "search_results">
            <h4 id = "msg"></h4>
        </div>
        <footer>
            <h4>2020. Rajarshi Saha.</h4>
        </footer>
        <script type = "text/javascript" src = "../public/JS/JQUERY/jquery.js"></script>
        <script type = "text/javascript" src = "../public/JS/search.js"></script>
        <script type = "text/javascript" src = "../public/JS/seed.js"></script>
    </body>
</html>
<?php
    mysqli_close($conn);
?>