<?php
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <div>
            <h4 id = "msg"></h4>
            <form id = "add_category_form">
                <input type = "text" id = "name" placeholder = "Category Name" autocomplete = "off"/>
                <input type = "submit" value = "Add Category"/>
            </form>
        </div>
        <footer>
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        <script type = "text/javascript" src = "../public/JS/jquery.js"></script>
        <script type = "text/javascript" src = "../public/JS/addCategory.js"></script>
    </body>
</html>