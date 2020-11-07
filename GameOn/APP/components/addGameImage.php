<?php
    require_once('./partials/header.php');
    require_once('./partials/nav.php');
?>
        <div>
            <h4 id = 'msg'></h4>
            <form id = 'add_image_form'>
                <h3>Add Game Image (Max 5)</h3>
                <input type = 'file' id = 'image' name = 'image'/>
                <button type = 'submit'>Add Image</button>
             </form>
             <div id = 'image_div'>
             </div>  
        </div>
        <footer>
            <h4>2020. Rajarshi Saha.</h4>
        </footer>
        <script type = 'text/javascript' src = '../public/JS/jquery.js'></script>
        <script type = 'text/javascript' src = '../public/JS/addGameImage.js'></script>
    </body>
</html>