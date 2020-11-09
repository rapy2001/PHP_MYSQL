$(document).ready(function(){
    $("#msg").hide();
    $("#login_form").on("submit",function(e){
        e.preventDefault();
        let username = $("#username").val();
        let password = $("#password").val();
        if(username == '' || password == '')
        {
            $("#msg").html("All fields are Mandatory").show();
        }
        else
        {
            let obj = {username,password};
            let data = JSON.stringify(obj);
            $.ajax({
                url:"http://localhost/projects/GameOn/API/login.php",
                data:data,
                dataType:"JSON",
                type:"POST",
                success:function(data)
                {
                    if(data.flg == 1)
                    {
                        $("#msg").html("Login Successfull").show();
                        $("#login_form").trigger("reset");
                        setTimeout(function(){
                            window.location.assign("./viewGames.php");
                        },3500);
                    }
                    else if(data.flg == 2)
                    {
                        $("#msg").html("Username does not Exists. Please Register").show();
                        $("#login_form").trigger("reset");
                        setTimeout(function(){
                            window.location.assign("./register.php");
                        },3500);
                    }
                    else if(data.flg == 3)
                    {
                        $("#msg").html("The Password is Wrong. Please Reenter");
                        $("#password").val("");
                    }
                    else
                    {
                        $("#msg").html("Internal Server Error").show();
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    });
});