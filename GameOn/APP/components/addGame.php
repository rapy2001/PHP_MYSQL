<?php
    require_once('./partials/header.php');
    require_once('./partials/nav.php');
?>
        <div>
            <h4 id = 'msg'></h4>
            <form id = 'add_game_form'>
                <input type = 'text' id = 'gameName' placeholder = 'Game Name' autocomplete = 'off'/>
                <input type = 'date' id = 'gameDate'/>
                <textarea id = 'description'>
                    Game Description
                </textarea>
                <select id = 'category'>
                </select>
            </form>
        </div>
        <footer>
            <h4>2020. Rajarshi Saha.</h4>
        </footer>
        <script type = 'text/javascript' src = '../public/JS/jquery.js'></script>
        <script type = 'text/javascript' src = '../public/JS/addGame.js'></script>
    </body>
</html>