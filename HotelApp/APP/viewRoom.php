<?php
    require_once('./partials/header.php');
    require_once('./session/session.php');
    require_once('./partials/nav.php');
    
    if(empty($_GET['id']))
    {
?>
        <div class = 'empty'>
            <h4>No Room Selected</h4>
        </div>
<?php
    }
    else
    {
?>
        <div>
            <h4 class = 'msg' id = 'msg'></h4>
            <input type = 'hidden' id = 'roomId' value = '<?php echo $_GET['id']; ?>'/>
            <div id = 'container'>
            </div>
        </div>
        <footer class = 'footer'>
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        </body>
    <script type = 'text/javascript' src = './public/js/jquery.js'></script>
    <script type = 'text/javascript' src = './public/js/viewRoom.js'></script>
</html>
<?php
    }
?>


