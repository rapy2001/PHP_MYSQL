<?php
    require_once("./session/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
<?php
    if(!empty($_SESSION['user_id']))
    {
?>
<?php
        if(!empty($_GET['gameId']))
        {
?>
            <div class = 'addReview box'>
                <h4 id = 'msg'></h4>
                <div class = 'box_1'>
                    <form class = 'form' id = 'add_review_form'>
                        <h3>Add a Review</h3>
                        <input type = 'text' id = 'reviewText' placeholder = 'Your Review' autocomplete = 'off'/>
                        <input type = 'number' id = 'rating' step = '0.1' min = '0.0'/>
                        <input type = 'hidden' id = 'userId' value = '<?php echo $_SESSION['user_id']; ?>'/>
                        <button class = 'btn' type = 'submit'>Add Review</button>
                    </form>
                </div>
                <div class = 'box_2'>
                    <h3>Game On</h3>
                </div>
            </div>
<?php
        }
        else
        {
?>
            <div class = 'empty_box'>
                <div class = 'empty'>
                    <h4>No Game chosen</h4>
                </div>
            </div>
<?php
        }
?>
<?php
    }
    else
    {
?>
        <div class = 'empty_box'>
            <div class = 'empty'>
                <h4>Please Log In to add a Review</h4>
            </div>
        </div>
<?php
    }
?>

        <footer class = "footer">
            <h4>2020. Rajarshi Saha.</h4>
        </footer>
        <script type = 'text/javascript' src = '../public/JS/jquery.js'></script>
        <script type = 'text/javascript' src = '../public/JS/addReview.js'></script>
    </body>
</html>