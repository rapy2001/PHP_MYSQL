<?php
    require_once('./session/session.php');
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <div class = 'viewProducts'>
            <h4 class = 'msg' id = 'msg'></h4>
            <input id = 'userId' type = 'hidden' value = '<?php echo empty($_SESSION['username']) ? '': $_SESSION['userId'];?>' />
            <h1>Products</h1>
            <div id = 'viewProducts_box'>
                <div class = 'empty'>
                    <h4>No Products Available</h4>
                </div>
            </div>
        </div>
        <footer class = 'footer'>
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        <script type = 'text/javascript' src = './public/js/jquery.js'></script>
        <script type = 'text/javascript' src = './public/js/viewProducts.js'></script>
    </body>
</html>