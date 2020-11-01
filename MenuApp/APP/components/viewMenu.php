<?php
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <div>
            <h4 id = "msg"></h4>
            <div>
                <div id = 'update_item_form_div'>
                    <form id = 'update_item_form'>
                        <input type = "text" name = "name" id = "name" placeholder = "Item Name" autocomplete = "off" />
                        <input type = "number" name = "price" id = "price" placeholder = "Item Price" autocomplete = "off" />
                        <textarea name = 'description' id = 'description'>
                            Menu Item Description
                        </textarea>
                        <input type = "submit" value = "Update"/>
                    </form>
                </div>
                <h1>Our Menu</h1>
                <div id = 'category_div'>
                </div>
                <div id = 'items_div'>
                </div>
            </div>
        </div>
        <footer class = "footer">
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        <script type = "text/javascript" src = "../public/JS/jquery.js"></script>
        <script type = "text/javascript" src = "../public/JS/viewMenu.js"></script>
    </body>
</html>