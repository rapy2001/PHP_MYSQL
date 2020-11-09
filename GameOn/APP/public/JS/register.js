$(document).ready(function(){
    $("#msg").hide();
    $("#register_form").on("submit",function(e){
        e.preventDefault();
        let username = $("#username").val();
        let password = $("#password").val();
        if(username == '' || password == '')
        {
            $("#msg").html("All fields are Mandatroy").show();
        }
        else
        {
            let obj = {username,password};
            let data = JSON.stringify(obj);
            $.ajax({
                url:"http://localhost/projects/GameOn/API/register.php",
                data:data,
                dataType:"JSON",
                type:"POST",
                success:function(data)
                {
                    if(data.flg == 1)
                    {
                        $("#msg").html("Registration Successfull").show();
                        $("#register_form").trigger("reset");
                        setTimeout(function(){
                            window.location.assign("./homepage.php");
                        },3500);
                    }
                    else if(data.flg == 2)
                    {
                        $("#msg").html("The Username already exists, please try a different Username").show();
                        $("#username").val("");
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
        },3500);
    });
});