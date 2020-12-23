<?php
    require_once("./session/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
    if(empty($_SESSION['userId']))
    {
?>
        <div class = 'empty'>
            <h4>Please Log In to View Your Cart</h4>
        </div>
<?php
    }
    else
    {
?>
            <div class = 'viewCart'>
                <h4 class = 'msg' id = 'msg'></h4>
                <div class = 'userDashboard'>
                </div>
                <div class = 'cartBox'>
                    <h1>CART</h1>
                    <div class = 'cart'>
                    </div>
                </div>
            </div>
            <footer class = 'footer'>
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        <script type = 'text/javascript' src = './public/js/jquery.js'></script>
        <script type = 'text/javascript' src = './public/js/viewCart.js'></script>
    </body>
</html>
<?php
    }
?>