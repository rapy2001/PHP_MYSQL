<?php
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <div class = "box addItem">
            <h4 id = "msg"></h4>
            <div class = "box_1">
                <form id = 'add_item_form' class = "form">
                    <input type = "text" name = "name" id = "name" placeholder = "Item Name" autocomplete = "off" />
                    <input type = "number" name = "price" id = "price" placeholder = "Item Price" autocomplete = "off" />
                    <textarea name = 'description' id = 'description'>
                        Menu Item Description
                    </textarea>
                    <h4><label for = 'categoryId'>Select a Category</label></h4>
                    <select id = "categoryId" name = 'categoryId'>
                    </select>
                    <h4><label for = 'image'>Menu Item Image</label></h4>
                    <input type = "file" name = 'image' id = 'image'/>
                    <input type = "submit" value = 'Add Item'/>
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
        <script type = "text/javascript" src = "../public/JS/addItem.js"></script>
    </body>
</html>