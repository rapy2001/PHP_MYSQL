<?php
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <div>
            <div>
                <h4 id = 'msg'></h4>
                <div>
                    <form id = 'add_item_form'>
                        <input type = 'text' name = 'text' id = 'text' placeholder = 'List Text' autocomplete = 'off'/>
                        <input type = 'submit' value = 'Add to List'/>
                    </form>
                </div>
                <div id = 'list_items_div'>
                </div>
            </div>
        </div>
        <footer>
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        <script type = 'text/javascript' src = '../public/JS/jquery.js'></script>
        <script type = 'text/javascript' src = '../public/JS/viewList.js'></script>
    </body>
</html>

<!-- <div>
    <div>
        <h4></h4>
    <div>
    <div>
        <button id = 'chk_btn'>Check</button>
        <button id = 'upd_btn'>Update</button>
        <button id = 'dlt_btn'>Delete</button>
    </div>
</div> -->