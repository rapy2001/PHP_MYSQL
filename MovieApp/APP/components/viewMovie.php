<?php
    require_once("../../API/Includes/connection.php");
    require_once("../../API/Includes/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
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

<?php
    mysqli_close($conn);
?>
