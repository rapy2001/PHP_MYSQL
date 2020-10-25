$(document).ready(function(){
    $("#msg").hide();
    $("#register_form").on("submit",function(e){
        e.preventDefault();
        let username = $("#username").val();
        let password = $("#password").val();
        if(username == '' || password == '')
        {
            $("#msg").html("All fileds are required").show();
        }
        else
        {
            let data = {username,password};
            let userData = JSON.stringify(data);
            
            $.ajax({
                url:"http://localhost/projects/MovieApp/API/register.php",
                type:"POST",
                dataType:"JSON",
                data:userData,
                beforesend:function(){
                    $("#msg").html("Loading ...").show();
                },
                success:function(data){
                    // console.log(data);
                    if(data.flg == 1)
                    {
                        $("#register_form").trigger("reset");
                        $("#msg").html("Registration Successful").show();
                    }
                    else if(data.flg == -1)
                    {
                        $("#msg").html("All data was not provided").show();
                    }
                    else if(data.flg == -2)
                    {   
                        $("#register_form").trigger("reset");
                        $("#msg").html("The username already exists").show();
                    }
                    else if(data.flg == -3)
                    {
                        $("#msg").html("Internal Server Error. Please try again").show();
                    }
                }
            });
            setTimeout(function(){
                $("#msg").hide();
            },2500);
        }
    });
});