<?php
    require_once("../../API/Includes/connection.php");
    require_once("../../API/Includes/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <?php
            if(!empty($_GET['id']))
            {
        ?>
                <h4 id = "msg"></h4>
                <input type = "hidden" id = "movie_id" value = "<?php echo $_GET['id']; ?>"/>
                <div id = "movie_div">

                </div>
                <input type = "hidden" value = "<?php echo empty($_SESSION['user_id']) ? -1 : $_SESSION['user_id']; ?>" id = "user_id" placeholder = "Your Rating"/>
                <div id = "review_form_div">
                    <form id = "add_review_form">
                        <textarea id = "reviewText">
                            "Your Review"
                        </textarea>
                        <input type = "number" min = "0" step = "0.5" id = "rating"/>
                        <input type = "submit" id = "submit"/>
                    </form>
                </div>
                <div id = "update_review_form_div">
                    <form id = "update_review_form">
                        <textarea id = "update_reviewText">
                            "Your Review"
                        </textarea>
                        <input type = "number" min = "0" step = "0.5" id = "update_rating"/>
                        <input type = "submit" id = "submit" value = "update"/>
                    </form>
                    <h4 id = "upd_msg"></h4>
                </div>
                <div id = "reviews_div">
                    <h4 id = "rvw_msg"></h4>
                    <h1>Reviews</h1>
                    <?php
                        if(!empty($_SESSION['user_id']))
                        {
                    ?>
                            <button id= "add_review_btn">Add a Review</button>
                    <?php
                        }
                    ?>
                    
                </div>
        <?php
            }
            else
            {
        ?>
                <div>
                    <h4>No Data was Provieded</h4>
                </div>
        <?php
            }
        ?>
    </body>
    <script type = "text/javascript" src = "../public/JS/JQUERY/jquery.js"></script>
    <script type = "text/javascript" src = "../public/JS/viewMovie.js"></script>
    <script type = "text/javascript" src = "../public/JS/seed.js"></script>
</html>

<?php
    mysqli_close($conn);
?>
