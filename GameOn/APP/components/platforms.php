<?php
    require_once("./session/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
    if(!empty($_SESSION['username']) && $_SESSION['username'] == 'Admin')
    {
?>
        <div class = 'categories'>
            <h4 id = 'msg'></h4>
            <h1>Game Platforms</h1>
            <div id = 'add_platform_box' class = 'category_box'>
                <div id = 'add_platform_div'>
                    <form id = 'add_platform_form' class = 'newForm'>
                        <input type = "text" id = 'platformText' placeholder = "New Platform Name" autocomplete = "off"/>
                        <button type = "submit">Add Platform</button>
                    </form>
                </div>
                
                <div id = 'update_platform_div'>
                    <form id = 'update_platform_form' class = 'newForm'>
                        <input type = "text" plaeholder = "Updated Platform Text" id = 'updatedPlatformText' autocomplete = 'off'/>
                        <input type = "hidden" id = 'hiddenPlatformId'/>
                        <button type = "submit">Update Platform</button>
                    </form>
                    <button id = 'cancel_update'>Cancel Update</button>
                </div>
                <div id = 'platforms_div'>
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
                <h4>Only Administrator can access this Page</h4>
            </div>
        </div>
<?php
    }
?>
        <footer class = "footer">
            <h4>2020. Rajarshi Saha.</h4>
        </footer>
        <script type = 'text/javascript' src = '../public/JS/jquery.js'></script>
        <script type = 'text/javascript' src = '../public/JS/platforms.js'></script>
    </body>
</html>