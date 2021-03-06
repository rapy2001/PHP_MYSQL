<?php
    require_once('./partials/header.php');
    require_once('./session/session.php');
    require_once('./partials/nav.php');
?>
        <div class = 'viewRooms'>
            <h4 class = 'msg' id = 'msg'></h4>
            <div class = 'searach_box'>
                <h1>Search a Room</h1>
                <form  id ='search_form'>
                    <div class = 'unit'>
                        <label>
                            Select Room Type:
                        </label>
                        <select value = '1' id = 'type'>
                            <option value = '0'>--TYPE--</option>
                            <option value = '1'>Family</option>
                            <option value = '2'>Single</option>
                            <option value = '3'>Double</option>
                        </select>
                    </div>
                    <div class = 'unit'>
                        <label>
                            Select Number of Guests:
                        </label>
                        <select value = '1' id = 'guests'>
                            <option value = '0'>--Guests--</option>
                            <option value = '1'>1</option>
                            <option value = '2'>2</option>
                            <option value = '3'>3</option>
                            <option value = '4'>4</option>
                            <option value = '5'>5</option>
                            <option value = '6'>6</option>
                        </select>
                    </div>
                    <div class = 'unit'>
                        <label>
                            Price:
                        </label>
                        <input 
                            type = 'number'
                            id = 'price' 
                        />
                    </div>
                    <div class = 'unit'>
                        <label>Room Size:</label>
                        <input 
                            type = 'number'
                            id = 'size' 
                        />
                    </div>
                    <div class = 'unit'>
                        <label>
                                Free Snacks:
                        </label>
                        <input
                            type = 'checkbox'
                            id = 'snacks'
                        />
                    </div>
                    <div class = 'unit'>
                        <label>
                                Pets Allowed:
                        </label>
                        <input
                            type = 'checkbox'
                            id = 'pets'
                        />
                    </div>
                    <button type = 'submit' class = 'btn'>Search</button>
                </form>
            </div>

            <div class = 'rooms_box'>
                <h1>Our Rooms</h1>
                <div id = 'rooms'>
                </div>
            </div>
        </div>
    </body>
    <footer class = 'footer'>
        <h4>2020. Rajarshi Saha</h4>
    </footer>
    <script type = 'text/javascript' src = './public/js/jquery.js'></script>
    <script type = 'text/javascript' src = './public/js/viewRooms.js'></script>
</html>