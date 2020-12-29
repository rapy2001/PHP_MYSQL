<?php
    require_once('./partials/header.php');
    require_once('./partials/nav.php');
?>
        <div class = 'editRooms'>
            <h1>Rooms</h1>
            <h4 class = 'msg' id = 'msg'></h4>
            <div id = 'edit_room_extra_form'>
                <div>
                    <h4 id = 'cut'><i class = 'fa fa-times'></i></h4>
                </div>
                <div>
                    <form id = 'extra_form'>
                        <input
                            type = 'hidden'
                            id = 'roomId' 
                        />
                        <input
                            type = 'text'
                            placeholder = 'Extra Feature Name'
                            id = 'extra_feature' 
                        />
                        <button type = 'submit'>Add Feature</button>
                    </form>
                </div>
            </div>
            <div class = 'table_box'>
                <table id = 'table'>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Size</th>
                            <th>Pets Allowed</th>
                            <th>Free Snacks</th>
                        </tr>
                        <tbody id = 'table_body'>
                        </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </body>
    <footer class = 'footer'>
        <h4>2020. Rajarshi Saha</h4>
    </footer>
    <script type = 'text/javascript' src = './public/js/jquery.js'></script>
    <script type = 'text/javascript' src = './public/js/editRooms.js'></script>
</html>