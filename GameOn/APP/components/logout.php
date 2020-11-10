<?php
    require_once("./session/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
    $_SESSION = array();
    header("Refresh:3;url='./homepage.php'");
?>
    <div class = 'logout'>
        <div class = 'empty'>
            <h4>You have Logged Out Successfully</h4>
        </div>
    </div>
<?php
    require_once("./partials/footer.php");
?>