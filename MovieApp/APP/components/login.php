<?php
    
    require_once("../../API/Includes/connection.php");
    require_once("../../API/Includes/session.php");
    require_once("./partials/header.php");
    require_once("./partials/nav.php");
?>
        <h4 id = "msg" class = "msg"></h4>
        <div class = "login box">
            <div class = "box_1">
                <form id = "login_form" class = "form">
                    <h3>Log In</h3>
                    <input type = "text" placeholder = "Username" name = "username" autocomplete = "off" id = "username"/>
                    <input type = "password" placeholder = "Password" name = "password" autocomplete = "off" id = "password" />
                    <input type = "submit" name = "submit" id = "submit"/>
                    <h4>Don't have an account ? Then <a href = "./register.php">Register</a></h4>
                </form>
            </div>
            <div class = "box_2">

            </div>
            
        </div>
        <footer class = "footer">
            <h4>2020. Rajarshi Saha.</h4>
        </footer>
        <script type = "text/javascript" src = "../public/JS/JQUERY/jquery.js"></script>
        <!-- <script type = "text/javascript" src = "../public/JS/login.js"></script> -->
        <script type = "text/javascript" src = "../public/JS/seed.js"></script>
        <script>
            $(document).ready(function(){
                $("#msg").hide();
                $("#login_form").on("submit",function(e){
                    e.preventDefault();
                    let username = $("#username").val();
                    let password = $("#password").val();
                    let data = {username,password}
                    let userData = JSON.stringify(data);
                    $.ajax({
                        url:"http://localhost/projects/MovieApp/API/login.php",
                        type:"POST",
                        dataType:"JSON",
                        data:userData,
                        beforesend:function(){
                            $("#msg").html("Loading ...").show();
                        },
                        success:function(data)
                        {
                            if(data.flg == 1)
                            {
                                $("#login_form").trigger("reset");
                                $("#msg").html("Log In Successful").show();
                                

                            }
                            else if(data.flg == -2)
                            {
                                $("#login_form").trigger("reset");
                                $("#msg").html("No Username exists. Please Register").show();
                            }
                            else if(data.flg == -3)
                            {
                                $("#password").val("");
                                $("#msg").html("Password is Wrong. Please Rennter the password").show();
                            }
                            else if(data.flg == -1)
                            {
                                $("#msg").html("All fileds are neccessary").show();
                            }
                        }
                    });
                    setTimeout(function(){
                        $("#msg").hide();
                    },2500);
                });
            });
        </script>
    </body>
</html>

<?php
    mysqli_close($conn);
?>
