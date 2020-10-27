<?php
    require_once("../../API/includes/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <div>
            <h4 id = "msg"></h4>
            <form id = "register_form">
                <input type = "text" name = "username" placeholder = "Username" id = "username" autocomplete = "off"/>
                <input type = "password" name = "password" placeholder = "Password" id = "password" autocomplete = "off"/>
                <label for = "image">Your Image</label>
                <input type = "file" id = "image" name = "image" />
                <input type = "submit" value = "register" />
            </form>
        </div>
        <footer>
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        <script type = "text/javascript" src = "../public/JS/jquery.js"></script>
        <script type = "text/javascript" src = "../public/JS/register.js"></script>
        <script type = "text/javascript" src = "../public/JS/logout.js"></script>
    </body>
</html>