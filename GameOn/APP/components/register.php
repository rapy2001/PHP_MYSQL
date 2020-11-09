<?php
    require_once("./session/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <div class = 'register box'>
            <h4 id = 'msg'></h4>
            <div class = 'box_1'>
                <form id = 'register_form' class = 'form'>
                    <h3>Register</h3>
                    <input type = 'text' id = 'username' placeholder = 'Your Username' autocomplete = 'off'/>
                    <input type = 'password' id = 'password' placeholder = 'Your Password' autocomplete = 'off'/>
                    <button class = 'btn' type = 'submit'>Register</button>
                </form>
            </div>
            <div class = 'box_2'>
                <h3>Game On</h3>
            </div>
        </div>
        <footer class = "footer">
            <h4>2020. Rajarshi Saha.</h4>
        </footer>
        <script type = 'text/javascript' src = '../public/JS/jquery.js'></script>
        <script type = 'text/javascript' src = '../public/JS/register.js'></script>
    </body>
</html>