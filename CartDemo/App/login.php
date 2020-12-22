<?php
    require_once('./session/session.php');
    require_once('./partials/header.php');
    require_once('./partials/nav.php');
?>
        <div class = 'login box'>
            <h4 class = 'msg' id = 'msg'></h4>
            <div class = 'box_1'>
                <form id = 'login_form' class = 'form'>
                    <h3>Log In</h3>
                    <input
                        type = 'text'
                        id = 'username'
                        placeholder = 'Username'
                        autocomplete = 'off' 
                    />
                    <input
                        type = 'password'
                        id = 'password'
                        placeholder = 'Password'
                        autocomplete = 'off' 
                    />
                    <button type = 'submit' class = 'btn'>
                        Log In
                    </button>
                    <h4>Don't have an account ? Then kindly <a href = './register.php'>Register</a>.</h4>
                </form>
            </div>
            <div class = 'box_2'>
                <h3>Cart Demo</h3>
            </div>
        </div>
        <footer class = 'footer'>
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        <script type = 'text/javascript' src = './public/js/jquery.js'></script>
        <script type = 'text/javascript' src = './public/js/login.js'></script>
    </body>
</html>
