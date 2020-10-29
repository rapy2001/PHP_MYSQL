<?php
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
<div>
    <h4 id = "msg"></h4>
    <form id = "addTrip_form">
        <input type = "text" name = "trip_name" placeholder = "Trip Name" autocomplete = "off" id = "trip_name"/>
        <input type = "number" name = "trip_price" placeholder = "Trip Price" autocomplete = "off" id = "trip_price"/>
        <textarea name = "trip_description" id = "trip_description" autocmplete = "off">
        </textarea>
        <input type = "file" name = "image" name = "image"/>
        <input type = "submit" name = "submit" />
    </form>
</div>
        <footer>
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        <script type = "text/javascript" src = "../public/JS/jquery.js"></script>
        <script type = "text/javascript" src = "../public/JS/addTrip.js"></script>
    </body>
</html>