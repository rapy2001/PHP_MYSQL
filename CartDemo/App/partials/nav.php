<nav class = 'nav'>
    <div class = 'nav_box_1'>
        <a href = "./homepage.php">Cart Demo</a>
    </div>
    <div class = 'nav_box_2'>
        <a href = './register.php'>Register</a>
        <a href = './viewProducts.php'>View Products</a>
        <?php
            if(!empty($_SESSION['username']))
            {
                if($_SESSION['username'] == 'Admin')
                {
        ?>
                    <a href = './addProduct.php'>Add a Product</a>
        <?php
                }
        ?>
                <a href = './logout.php'>Log Out ( <?php echo $_SESSION['username'];?> )</a>
        <?php
            } 
            else
            {
        ?>
                <a href = './login.php'>Log In</a>
        <?php
            }
        ?>
    </div>
</nav>