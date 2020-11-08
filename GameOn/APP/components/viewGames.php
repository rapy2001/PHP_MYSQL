<?php
    require_once('./partials/header.php');
    require_once('./partials/nav.php');
?>
        <div id = 'game_full_container'>
            <div id = 'game_full_box'>

            </div>
        </div>
        <div class = "viewGames">
            <h4 id = 'msg'></h4>
            <div id = 'viewGames_container'>
                <h1>Our Games</h1>
                <div class = "search_form_div">
                    <form class = 'newForm'>
                        <input type = 'text' id = 'search_term' placeholder = 'Search a Game' autocomplete = 'off'/>
                    </form>
                    
                </div>
                
                <div id = 'upcoming_games'>
                    
                </div>
                <div id = 'category_games'>
                </div>
                <div id = 'search_results'>
                </div>
            </div>
            
        </div>
        <footer class = "footer">
            <h4>2020. Rajarshi Saha.</h4>
        </footer>
        <script type = 'text/javascript' src = '../public/JS/jquery.js'></script>
        <script type = 'text/javascript' src = '../public/JS/viewGames.js'></script>
    </body>
</html>