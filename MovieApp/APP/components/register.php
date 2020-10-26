<?php
    require_once("../../API/Includes/connection.php");
    require_once("../../API/Includes/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");

?>
        <h4 id = "msg"></h4>
        <div class = "register box">
            <div class = "box_1">
                <form id = "register_form" class = "form">
                    <h3>Register</h3>
                    <input type = "text" placeholder = "Username" name = "username" autocomplete = "off" id = "username"/>
                    <input type = "password" placeholder = "Password" name = "password" autocomplete = "off" id = "password" />
                    <input type = "submit" name = "submit" id = "submit"/>
                    <h4>Already have an account ? Then <a href = "./login.php">Log In</a></h4>
                </form>
            </div>
            <div class = "box_2">
                
            </div>
            
        </div>
        <footer class = "footer">
            <h4>2020. Rajarshi Saha.</h4>
        </footer>
    </body>
    <script type = "text/javascript" src = "../public/JS/JQUERY/jquery.js"></script>
    <script type = "text/javascript" src = "../public/JS/register.js"></script>
    <script type = "text/javascript" src = "../public/JS/seed.js"></script>
</html>
<?php
    mysqli_close($conn);
?>