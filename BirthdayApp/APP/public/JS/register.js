$(document).ready(function(){
    $("#msg").hide();
    $("#register_form").on("submit",function(e){
        e.preventDefault();
        let username = $("#username").val();
        let password = $("#password").val();
        if(username == '' || password == '')
        {
            $("#msg").html("All fields are neccessary").show();
        }
        else
        {
            let formData = new FormData(this);
            $.ajax({
                url:"http://localhost/projects/BirthdayApp/API/register.php",
                type:"POST",
                dataType:"JSON",
                data:formData,
                processData:false,
                contentType:false,
                beforesend:function(){
                    $("#msg").html("Loading ...").show();
                },
                success:function(data){
                    // console.log(data);
                    if(data.flg == 1)
                    {
                        $("#msg").html("Registration Successful").show();
                        $("#register_form").trigger("reset");
                    }
                    else if(data.flg == -1)
                    {
                        $("#msg").html("Enough Data not provided").show();
                    }
                    else if(data.flg == -2)
                    {
                        $("#msg").html("Could not save data. Please try again").show();
                    }
                    else if(data.flg == -3)
                    {
                        $("#msg").html("Please upload an Image File").show();
                        $("#image").val("");
                    }
                    else if(data.flg == -4)
                    {
                        $("#msg").html("Please upload an Image File").show();
                        $("#image").val("");
                    }
                    else if(data.flg == -5)
                    {
                        $("#msg").html("Image size should be at most 5 MB").show();
                        $("#image").val("");
                    }
                    else if(data.flg == -6)
                    {
                        $("#msg").html("Internal Server Error").show();
                    }
                    else if(data.flg == -7)
                    {
                        $("#msg").html("Username already exists. Please try a different username").show();
                        $("#username").val("");
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    });
});