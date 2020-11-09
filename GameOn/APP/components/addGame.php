<?php
    require_once("./session/session.php");
    require_once('./partials/header.php');
    require_once('./partials/nav.php');
    if(!empty($_SESSION['username']) && $_SESSION['username'] == 'Admin')
    {
?>
        <div class = "box addGame">
            <h4 id = 'msg'></h4>
            <div class = 'box_1'>
                <form id = 'add_game_form' class = 'form'>
                    <h3>Add a Game</h3>
                    <input type = 'text' id = 'gameName' placeholder = 'Game Name' autocomplete = 'off'/>
                    <input type = 'date' id = 'gameDate'/>
                    <textarea id = 'gameDescription'>
                        Game Description
                    </textarea>
                    <h4>
                        <label for = 'category'>
                            Select Category
                        </label>
                    </h4>
                    <select id = 'category'>
                    </select>
                   
                </form>
            </div>
            <div class = 'box_2'>
                <h3>Game On</h3>
            </div>
        </div>
<?php
    }
    else
    {
?>
        <div class = 'empty_box'>
            <div class = 'empty'>
                <h4>Only Administrator can Access this page</h4>
            </div>
        </div>
<?php
    }
?>
        <footer class = "footer">
            <h4>2020. Rajarshi Saha.</h4>
        </footer>
        <script type = 'text/javascript' src = '../public/JS/jquery.js'></script>
        <script type = 'text/javascript' src = '../public/JS/addGame.js'></script>
    </body>
</html>