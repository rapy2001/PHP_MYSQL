<?php
    require_once("./session/session.php");
    require_once('./partials/header.php');
    require_once('./partials/nav.php');
    if(!empty($_SESSION['username']) && $_SESSION['username'] == 'Admin')
    {
?>
       <div class = "categories">
            <h4 id = 'msg'></h4>
            <h1>Categories</h1>
            <div class = "category_box">
                <form id = 'category_form' class = "newForm">
                    <input type = 'text' id = 'categoryText' placeholder = 'New Category Name' autocomplete = 'off'/>
                    <button type = 'submit'>Add Category</button>
                </form>
                <div id = 'update_category_div'>
                    <form id = 'update_category_form' class = "newForm">
                        <input type = 'text' id = 'updatedCategoryText' placeholder = 'Updated Category Name' autocomplete = 'off'/>
                        <input type = 'hidden' id = 'hiddenCategory' />
                        <button type = 'submit'>Update Category</button>
                    </form>
                    <button id = 'cancel_update'>Cancel Update</button>
                </div>
                <div id = 'category_div'>

                </div>
            </div>
        </div>
<?php
    }
    else
    {
?>
        <div class = 'empty_box'>
            <div class = 'empty'>
                <h4>Only Administrator can Access this Page</h4>
            </div>
        </div>
<?php
    }
?>
        
        <footer class = "footer">
            <h4>2020. Rajarshi Saha.</h4>
            <script type = 'text/javascript' src = '../public/JS/jquery.js'></script>
            <script type = 'text/javascript' src = '../public/JS/categories.js'></script>
        </footer>
    </body>
</html>