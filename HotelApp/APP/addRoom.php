<?php
    require_once('./partials/header.php');
    require_once('./partials/nav.php');
?>
            <div class = 'addRoom box'>
                <h4 class = 'msg' id = 'msg'></h4>
                <div class = 'box_1'>
                    <form id = 'addRoom_form' class = 'form'>
                        <h3>Add a Room</h3>
                        <input
                            type = 'text'
                            placeholder = 'Room Name'
                            id = 'name'
                            autocomplete = 'off' 
                        />
                        <input
                            type = 'text'
                            placeholder = 'Primary Image'
                            id = 'primaryImage'
                            autocomplete = 'off' 
                        />
                        <input
                            type = 'text'
                            placeholder = 'Image 1'
                            id = 'image1'
                            autocomplete = 'off' 
                        />
                        <input
                            type = 'text'
                            placeholder = 'Image 2'
                            id = 'image2'
                            autocomplete = 'off' 
                        />
                        <input
                            type = 'text'
                            placeholder = 'Image 3'
                            id = 'image3'
                            autocomplete = 'off' 
                        />
                        <input
                            type = 'text'
                            placeholder = 'description'
                            id = 'description'
                            autocomplete = 'off' 
                        />
                        <label>Price: </label>
                        <input
                            type = 'number'
                            id = 'price'
                            min = '0.0'
                            step = '0.01'
                        />
                        <label>Size (In Square Feet): </label>
                        
                        <input
                            type = 'number'
                            id = 'size'
                            min = '0.0'
                            step = '0.01'
                        />
                        <label>
                            Pets Allowed:
                        </label>
                        
                        <input
                            type = 'checkbox'
                            id = 'pets'
                        />
                        <label>
                            Free Snacks:
                        </label>
                        <input
                            type = 'checkbox'
                            id = 'snacks'
                        />
                        <button class = 'btn' type = 'submit'>Add Room</button>
                    </form>
                </div>
                <div class = 'box_2'>
                    <h3>Hotel App</h3>
                </div>
            </div>
        </body>
    <footer class = 'footer'>
        <h4>2020. Rajarshi Saha</h4>
    </footer>
    <script type = 'text/javascript' src = './public/js/jquery.js'></script>
    <script type = 'text/javascript' src = './public/js/addRoom.js'></script>
</html>