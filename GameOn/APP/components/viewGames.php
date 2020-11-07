<?php
    require_once('./partials/header.php');
    require_once('./partials/nav.php');
?>
        <div>
            <h4 id = 'msg'></h4>
            <div>
                <input type = 'text' id = 'search_term' placeholder = 'Search a Game' autocomplete = 'off'/>
            </div>
            <div id = 'game_full_box'>
            </div>
            <div id = 'upcoming_games'>
                
            </div>
            <div id = 'category_games'>
            </div>
            <div id = 'search_results'>
            </div>
        </div>
        <footer class = "footer">
            <h4>2020. Rajarshi Saha.</h4>
        </footer>
        <script type = 'text/javascript' src = '../public/JS/jquery.js'></script>
        <script type = 'text/javascript' src = '../public/JS/viewGames.js'></script>
    </body>
</html>