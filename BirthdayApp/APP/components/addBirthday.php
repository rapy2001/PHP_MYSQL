<?php
    require_once("../../API/includes/connection.php");
    require_once("../../API/includes/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <div class = "add_birthday box">
            <h4 id = "msg" class = "msg"></h4>
            <div class = "box_1">
                <form id = "add_birthday_form" class = "form">
                    <h3>Add a Birthday</h3>
                    <input type = "text" placeholder = "Person 's Name" name = "name" aitocomplete = "off" id = "name" autocomplete = "off"/>
                    <input type = "text" placeholder = "Person 's Birthday (yyyy-mm-dd)" name = "birthday" aitocomplete = "off" id = "birthday" autocomplete = "off"/>
                    <input type = "file" name = "image" id = "image"/>
                    <input type = "hidden" id = "userId" value = "<?php echo $_SESSION['user_id']; ?>" name = "userId"/>
                    <input type = "submit" name = "submit" value = "submit"/>
                </form>
            </div>
            <div class = "box_2">
                <h3>Birthday App</h3>
            </div>
            
        </div>
        <footer class = "footer">
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        <script type = "text/javascript" src = "../public/JS/jquery.js"></script>
        <script type = "text/javascript" src = "../public/JS/logout.js"></script>
        <script type = "text/javascript" src = "../public/JS/addBirthday.js"></script>
    </body>
</html>