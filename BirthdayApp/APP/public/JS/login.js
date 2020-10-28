$(document).ready(function(){
    $("#msg").hide();
    $("#login_form").on("submit",function(e){
        e.preventDefault();
        let username = $("#username").val();
        let password = $("#password").val();
        if(username == '' || password == '')
        {
            $("#msg").html("All fields are neccessary").show();
        }
        else
        {
            let obj = {username,password};
            let data = JSON.stringify(obj);
            $.ajax({
                url:"http://localhost/projects/BirthdayApp/API/login.php",
                type:"POST",
                dataType:"JSON",
                data:data,
                beforesend:function()
                {
                    $("#msg").html("Loading ..").show();
                },
                success:function(data){
                    console.log(data);
                    if(data.flg == 1)
                    {
                        $("#msg").html("Log In Successfull").show();
                        $("#login_form").trigger("reset");
                        setTimeout(function(){
                            window.location.assign("./viewBirthdays.php");
                        },2500);
                    }
                    else if(data.flg == -1)
                    {
                        $("#msg").html("Enough data not provieded").show();
                    }
                    else if(data.flg == -2)
                    {
                        $("#msg").html("Username does not exists").show();
                        $("#username").val("");
                        setTimeout(function(){
                            window.location.assign("../register.php");
                        },2500);
                    }
                    else if(data.flg == -3)
                    {
                        $("#msg").html("Password is Wrong").show();
                        $("#password").val("");
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    });
});