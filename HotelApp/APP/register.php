<?php
    require_once('./partials/header.php');
    require_once('./partials/nav.php');
?>
    <div class = 'register box'>
        <h4 class = 'msg' id = 'msg'></h4>
        <div class = 'box_1'>
            <form class = 'form' id = 'register_form'>
                <h3>Register</h3>
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
                <input 
                    type = 'text'
                    id = 'image'
                    placeholder = 'Your Image  Url'
                    autocomplete = 'off'
                />
                <button type = 'submit' class = 'btn'>
                    Register
                </button>
                <h4>Already have an Account ? Then <a href = './login.php'>Log In</a></h4>
            </form>
        </div>
        <div class = 'box_2'>
            <h3>Hotel App</h3>
        </div>
    </div>
    </body>
    <footer class = 'footer'>
        <h4>2020. Rajarshi Saha</h4>
    </footer>
    <script type = 'text/javascript' src = './public/js/jquery.js'></script>
    <script type = 'text/javascript' src = './public/js/register.js'></script>
</html>