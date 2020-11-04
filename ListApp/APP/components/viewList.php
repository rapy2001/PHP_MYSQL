<?php
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <div class = "list">
            <div class = "list_container">
                <h1>Your List</h1>
                <h4 id = 'msg'></h4>
                <div class = "list_form_div">
                    <form id = 'add_item_form' class = "form">
                        <input type = 'text' name = 'text' id = 'text' placeholder = 'List Text' autocomplete = 'off'/>
                        <input type = 'submit' value = 'Add to List'/>
                    </form>
                    <form id = 'update_list_item_form' class = "form">
                        <input type = 'text' name = 'upd_text' id = 'upd_text' placeholder = 'List Text' autocomplete = 'off'/>
                        <input type = 'submit' value = 'Update'/>
                    </form>
                </div>
                <div id = 'list_items_div'>
                </div>
            </div>
        </div>
        <footer class = "footer">
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        <script type = 'text/javascript' src = '../public/JS/jquery.js'></script>
        <script type = 'text/javascript' src = '../public/JS/viewList.js'></script>
    </body>
</html>

