<?php
    require_once("../../API/includes/connection.php");
    require_once("../../API/includes/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
    // echo date('yy-m-d');
?>

        <div class = "viewBirthdays">
            <h4 id = "msg" class = "msg"></h4>
            <input type = "hidden" id = "userId" value = "<?php echo $_SESSION['user_id']; ?>"/>
            <!-- <div></div> -->
            <div id = "birthdays_div">
                <h1>Todays's Birthdays</h1>
            </div>
        </div>
        <footer class = "footer">
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        <script type = "text/javascript" src = "../public/JS/jquery.js"></script>
        <script type = "text/javascript" src = "../public/JS/logout.js"></script>
        <script type = "text/javascript" src = "../public/JS/viewBirthdays.js"></script>
    </body>
</html>