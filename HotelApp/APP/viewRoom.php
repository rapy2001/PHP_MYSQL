<?php
    require_once('./partials/header.php');
    require_once('./session/session.php');
    require_once('./partials/nav.php');
    
    if(empty($_GET['id']))
    {
?>
        <div class = 'empty'>
            <h4>No Room Selected</h4>
        </div>
<?php
    }
    else
    {
?>
        <div>
            <h4 class = 'msg' id = 'msg'></h4>
            <input type = 'hidden' id = 'roomId' value = '<?php echo $_GET['id']; ?>'/>
            <input type = 'hidden' id = 'userId' value = "<?php echo empty($_SESSION['user_id']) ? -1 : $_SESSION['user_id']; ?>" />
            <div id = 'container'>
            </div>
            <div id = 'review_box'>
                <div>
                    <h4 id = 'cut'><i class = 'fa fa-times'></i></h4>
                </div>
                <form class = 'form' id = 'reviewForm'>
                    <h3>Add a Review</h3>
                    <input 
                        type = 'text' 
                        id = 'review' 
                        placeholder = 'Your Review'
                        autocomplete = 'off' 
                    />
                    <label>Your Rating:</label>
                    <input 
                        type = 'number' 
                        id = 'rating' 
                        min = '0'
                        step = '0.01'
                        max = '5.0'
                    />
                    <button class = 'btn' type = 'submit'>Add Review</button>
                </form>
            </div>
            <div id = 'upd_review_box'>
                <div>
                    <h4 id = 'rvwCut'><i class = 'fa fa-times'></i></h4>
                </div>
                <form class = 'form' id = 'updReviewForm'>
                    <h3>Update Review</h3>
                    <input 
                        type = 'hidden' 
                        id = 'reviewId' 
                    />
                    <input 
                        type = 'text' 
                        placeholder = 'Your Review' 
                        id = 'updReview'
                        autocomplete = 'off'
                    />
                    <input 
                        type = 'number'
                        min = '0'
                        step = '0.01' 
                        id = 'updRating'
                        max = '5.0'
                    />
                    <button type = 'submit' class = 'btn' >Update Review</button>
                </form>
            </div>
        </div>
        <footer class = 'footer'>
            <h4>2020. Rajarshi Saha</h4>
        </footer>
        </body>
    <script type = 'text/javascript' src = './public/js/jquery.js'></script>
    <script type = 'text/javascript' src = './public/js/viewRoom.js'></script>
</html>
<?php
    }
?>


