<?php
    require_once("../../API/includes/connection.php");
    require_once("../../API/includes/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <div>
            <h4 id = "msg"></h4>
            <form id = "add_birthday_form">
                <input type = "text" placeholder = "Person 's Name" name = "name" aitocomplete = "off" id = "name"/>
                <input type = "text" placeholder = "Person 's Birthday (yyyy-mm-dd)" name = "birthday" aitocomplete = "off" id = "birthday"/>
                <input type = "file" name = "image" id = "image"/>
                <input type = "submit" name = "submit" value = "submit"/>
            </form>
        </div>
        <footer>
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        <script type = "text/javascript" src = "../public/JS/jquery.js"></script>
        <script type = "text/javascript" src = "../public/JS/logout.js"></script>
        <script type = "text/javascript" src = "../public/JS/addBirthday.js"></script>
    </body>
</html>