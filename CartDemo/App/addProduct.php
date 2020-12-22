<?php
    require_once('./session/session.php');
    require_once('./partials/header.php');
    require_once('./partials/nav.php');
?>
        <div id = 'add_product' class = 'box'>
            <h4 class = 'msg' id = 'msg'></h4>
            <div class = 'box_1'>
                <form id = 'add_product_form' class = 'form'>
                    <h3>Add a Product</h3>
                    <input
                        type = 'text'
                        id = 'name'
                        placeholder = 'Product Name'
                        autoComplete = 'off' 
                    />
                    <input
                        type = 'number'
                        id = 'price'
                        placeholder = 'Price'
                        autoComplete = 'off' 
                        min = '0'
                        step = '0.25'
                    />
                    <input
                        type = 'number'
                        id = 'quantity'
                        placeholder = 'Quantity'
                        autoComplete = 'off' 
                    />
                    <input
                        type = 'text'
                        id = 'image'
                        placeholder = 'Product Image'
                        autoComplete = 'off' 
                    />
                    <button class = 'btn' type = 'submit'>Add Product</button>
                </form>
            </div>
            <div class = 'box_2'>
                <h3>Cart Demo</h3>
            </div>
        </div>
        
        <footer class = 'footer'>
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        <script type = 'text/javascript' src = './public/js/jquery.js'></script>
        <script type = 'text/javascript' src = './public/js/addProduct.js'></script>
    </body>
</html>