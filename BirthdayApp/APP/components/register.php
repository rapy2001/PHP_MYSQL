<?php
    require_once("../../API/includes/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <div class = "register box">
            <h4 id = "msg" class = "msg"></h4>
            <div class = "box_1">
                <form id = "register_form" class = "form">
                    <h3>Register</h3>
                    <input type = "text" name = "username" placeholder = "Username" id = "username" autocomplete = "off"/>
                    <input type = "password" name = "password" placeholder = "Password" id = "password" autocomplete = "off"/>
                    <label for = "image">Your Image</label>
                    <input type = "file" id = "image" name = "image" />
                    <input type = "submit" value = "register" />
                    <h4>Already have an account ? Then <a href = "./login.php">Log In</a></h4>
                </form>
            </div>
            <div class = "box_2">
                <h3>Birthday App</h3>
            </div>
            
        </div>
        <footer class = "footer">
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        <script type = "text/javascript" src = "../public/JS/jquery.js"></script>
        <script type = "text/javascript" src = "../public/JS/register.js"></script>
        <script type = "text/javascript" src = "../public/JS/logout.js"></script>
    </body>
</html>