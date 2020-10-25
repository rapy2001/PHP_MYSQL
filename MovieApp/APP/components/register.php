<?php
    require_once("../../API/Includes/connection.php");
    require_once("../../API/Includes/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");

?>
        <h4 id = "msg"></h4>
        <div>
            <form id = "register_form">
                <input type = "text" placeholder = "Username" name = "username" autocomplete = "off" id = "username"/>
                <input type = "password" placeholder = "Password" name = "password" autocomplete = "off" id = "password" />
                <input type = "submit" name = "submit" id = "submit"/>
            </form>
        </div>
        <footer>
            <h4>2020. Rajarshi Saha.</h4>
        </footer>
    </body>
    <script type = "text/javascript" src = "../public/JS/JQUERY/jquery.js"></script>
    <script type = "text/javascript" src = "../public/JS/register.js"></script>
</html>
<?php
    mysqli_close($conn);
?>