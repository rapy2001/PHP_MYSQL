<?php
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <div class = "addCategory box">
            <h4 id = "msg"></h4>
            <div class = "box_1">
                <form id = "add_category_form" class = "form">
                    <h3>Add a Category</h3>
                    <input type = "text" id = "name" placeholder = "Category Name" autocomplete = "off"/>
                    <input type = "submit" value = "Add Category"/>
                </form>
            </div>
            <div class = "box_2">
                <h3>Menu App</h3>
            </div>
           
        </div>
        <footer class = "footer">
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        <script type = "text/javascript" src = "../public/JS/jquery.js"></script>
        <script type = "text/javascript" src = "../public/JS/addCategory.js"></script>
    </body>
</html>