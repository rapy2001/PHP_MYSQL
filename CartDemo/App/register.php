<?php
    require_once('./partials/header.php');
    require_once('./partials/nav.php');
?>
        <div class = 'box register'>
            <h4 id = 'msg' class = 'msg'></h4>
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
                        placeholder = 'Password'
                        id = 'password'
                        autocomplete = 'off' 
                    />
                    <input
                        type = 'text'
                        id = 'image'
                        placeholder = 'Image Url'
                        autocomplete = 'off' 
                    />
                    <button class = 'btn' type = 'submit'>
                        Register
                    </button>
                    <h4>Already have an account ? Then <a href = './login.php'>Log In</a></h4>
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
        <script type = 'text/javascript' src = './public/js/register.js'></script>
    </body>
</html>