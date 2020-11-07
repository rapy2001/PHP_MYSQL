<?php
    require_once('./partials/header.php');
    require_once('./partials/nav.php');
?>
        <div>
            <h4 id = 'msg'></h4>
            <form id = 'add_game_form'>
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
                <button type = 'submit'>Add Game</button>
            </form>
        </div>
        <footer>
            <h4>2020. Rajarshi Saha.</h4>
        </footer>
        <script type = 'text/javascript' src = '../public/JS/jquery.js'></script>
        <script type = 'text/javascript' src = '../public/JS/addGame.js'></script>
    </body>
</html>