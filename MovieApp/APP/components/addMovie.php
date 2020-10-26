<?php
    require_once("../../API/Includes/connection.php");
    require_once("../../API/Includes/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
    if(!empty($_SESSION['username']) && $_SESSION['username'] == 'Admin')
    {
?>
        <h4 id = "msg" class = "msg"></h4>
        <div id = "main_form_div" class = "add_movie box">
            <div class = "box_1">
                <form id = "add_movie_form" class = "form">
                    <h3>Add a Movie</h3>
                    <input type = "text" name = "movie_name" placeholder = "Movie Name" autocomplete =  "off" id = "name"/>
                    <input type = "text" name = "year" placeholder = "Movie Release Date (yyyy-mm-dd)" autocomplete =  "off" id = "year"/>
                    <textarea name = "description" value = "Movie Description" autocomplete = "off" id = "description"></textarea>
                    <select name = "genre" value = "1" id = "genre">
                        <option name = "adv" value = "1">Adventure</option>
                        <option name = "act" value = "2">Action</option>
                        <option name = "hor" value = "3">Horror</option>
                        <option name = "rom" value = "4">Romance</option>
                        <option name = "mys" value = "5">Mystery</option>
                    </select>
                    <input type = "text" name = "director" placeholder = "Movie Director Name" autocomplete =  "off" id = "director"/>
                    <input type = "submit" value = "submit" id = "submit_btn"/>
                </form>
            </div>
            <div class = "box_2">

            </div>
            
        </div>
        <div id = "image_form_div" class = "box">
            <div class = "box_1">
                <form id = "image_form" class = "form">
                    <h3>Add a Movie Image</h3>
                    <input type = "file" name = "image" id = "image"/>
                    <input type = "hidden" id = "movie_id" name = "id"/>
                    <input type = "submit" value = "submit" id = "image_submit_btn"/>
                </form>
            </div>

            <div id = "img_div" class = "img_div box_2">
            
            </div>
        </div>
<?php
    }
    else
    {
?>
        <div class = "empty">
            <h4>Please Log In as Admin to add a Movie</h4>
        </div>
<?php
    }
?>
        <footer class = "footer">
            <h4>2020. Rajarshi Saha.</h4>
        </footer>
        <script type = "text/javascript" src = "../public/JS/JQUERY/jquery.js"></script>
        <script type = "text/javascript" src = "../public/JS/addMovie.js"></script>
        <script type = "text/javascript" src = "../public/JS/seed.js"></script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>
