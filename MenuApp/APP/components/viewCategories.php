<?php
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <div class = "categories">
            <h4 id = "msg"></h4>
            <h1>Categories</h1>
            <div id = "show_categories_div">

            </div>
            <a id = "btn" href = "./addCategory.php">Add a Category</a>
        </div>
        <footer class = "footer">
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        <script type = "text/javascript" src = "../public/JS/jquery.js"></script>
        <script type = "text/javascript" src = "../public/JS/viewCategories.js"></script>
    </body>
</html>