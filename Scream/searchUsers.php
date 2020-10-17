<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/loader.php");
    require_once("./includes/nav.php");

    if(!empty($_SESSION['user_id']))
    {
        ?>
        <div>
            <h1>Search Users</h1>
            <div>
                <input type ="text" placeholder = "User Name" id = "search" autocomplete = "off"/>
            </div>
            <div id = "search_results">
            </div>
        </div>
        <?php
    }
    else
    {
        ?>
        <div>
            <h4>Please Log In to get Search Results</h4>
        </div>
        <?php
    }
?>
    <footer>
        <a href = "about.php">2020. Rajarshi Saha</a>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $(document).on("keyup","#search",function(){
                let searchTerm = $(this).val();
                $.ajax({
                    url:'getSearchResults.php',
                    type:"POST",
                    data:{searchTerm:searchTerm},
                    success:function(data){
                        $('#search_results').html(data);
                    }
                });
            });
        });
    </script>
    </body>
</html>