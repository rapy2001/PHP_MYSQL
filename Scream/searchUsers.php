<?php
    require_once("./includes/connection.php");
    require_once("./includes/session.php");
    require_once("./includes/header.php");
    require_once("./includes/loader.php");
    require_once("./includes/nav.php");

    if(!empty($_SESSION['user_id']))
    {
        ?>
        <div class = "search_users">
            <h1>Search Users</h1>
            <div class = "search_div">
                <input type ="text" placeholder = "User Name" id = "search" autocomplete = "off" class = "search_box"/>
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
    <script src = "./public/index.js"></script>
    <script>
        $(document).ready(function(){
            $('#search_results').hide();
            $(document).on("keyup","#search",function(){
                $('#search_results').html('');
                let searchTerm = $(this).val();
                // console.log(searchTerm);
                if(searchTerm != '')
                {  
                    $.ajax({
                        url:'getSearchResults.php',
                        type:"POST",
                        data:{searchTerm:searchTerm},
                        success:function(data){
                            
                            $('#search_results').html(data).show();
                        }
                    });
                }
                
            });
        });
    </script>
    </body>
</html>