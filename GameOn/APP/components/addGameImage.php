<?php
    require_once("./session/session.php");
    require_once('./partials/header.php');
    require_once('./partials/nav.php');
    if(!empty($_SESSION['username']) && $_SESSION['username'] == 'Admin')
    {
?>
        <div class = 'addGameImage'>
            <h4 id = 'msg'></h4>
            <form id = 'add_image_form' class = 'form'>
                <h3>Add Game Image (Max 5)</h3>
                <input type = 'file' id = 'image' name = 'image'/>
                <button class = 'btn' type = 'submit'>Add Image</button>
             </form>
             <div id = 'image_div'>
                <h1>Uploaded Images</h1>
             </div>  
        </div>
<?php
    }
    else
    {
?>
        <div>
            <div>
                <h4>Only Administrator can Access this Page</h4>
            </div>
        </div>
<?php 
    }
?>
        <footer class = "footer">
            <h4>2020. Rajarshi Saha.</h4>
        </footer>
        <script type = 'text/javascript' src = '../public/JS/jquery.js'></script>
        <script type = 'text/javascript' src = '../public/JS/addGameImage.js'></script>
    </body>
</html>