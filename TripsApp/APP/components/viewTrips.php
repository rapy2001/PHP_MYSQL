<?php
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <h4 class = "msg"></h4>
        <div id = "update_form_div">
            <form id = "update_form">
                <input type = "text" placeholder = "Trip Name" id = "trip_name" autocomplete = "off" name = "trip_name" />
                <input type = "number" id = "trip_price" name = "trip_price"/>
                <textarea name = 'trip_description' id = 'trip_description'>
                </textarea>
                <input type = "submit" value = "submit"/>
            </form>
        </div>
        <div id = "viewTrips_div">
            <h1>Trips</h1>
        </div>
        <footer>
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        <script type = "text/javascript" src = "../public/JS/jquery.js"></script>
        <script type = "text/javascript" src = "../public/JS/viewTrips.js"></script>
    </body>
</html>