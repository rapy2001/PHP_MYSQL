<?php
    require_once("./session/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
    if(empty($_SESSION['username']))
    {
?>
        <div class = 'login box'>
            <h4 id = 'msg'></h4>
            <div class = 'box_1'>
                <form id = 'login_form' class = 'form'>
                    <h3>Log In</h3>
                    <input type = 'text' id = 'username' placeholder = 'Your Username' autocomplete = 'off'/>
                    <input type = 'password' id = 'password' placeholder = 'Your Username' autocomplete = 'off'/>
                    <button class = 'btn'>Log In</button>
                </form>
            </div>
            <div class = 'box_2'>
                <h3>Game On</h3>
            </div>
        </div>
<?php
    }
    else
    {
?>
        <div class = 'empty_box'>
            <div class = 'empty'>
                <h4>Please Log Out First</h4>
            </div>
        </div>
<?php
    }
?>

        <footer class = "footer">
            <h4>2020. Rajarshi Saha.</h4>
        </footer>
        <script type = 'text/javascript' src = '../public/JS/jquery.js'></script>
        <script type = 'text/javascript' src = '../public/JS/login.js'></script>
    </body>
</html>