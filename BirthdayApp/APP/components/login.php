<?php
    require_once("../../API/includes/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
    
?>
        <div>
            <h4 id = "msg"></h4>
            <form id = "login_form">
                <input type = "text" name = "username" placeholder = "Username" id = "username" autocomplete = "off"/>
                <input type = "password" name = "password" placeholder = "Password" id = "password" autocomplete = "off"/>
                <input type = "submit" value = "Log In" />
            </form>
        </div>
        <footer>
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        <script type = "text/javascript" src = "../public/JS/jquery.js"></script>
        <script type = "text/javascript" src = "../public/JS/login.js"></script>
        <script type = "text/javascript" src = "../public/JS/logout.js"></script>
    </body>
</html>