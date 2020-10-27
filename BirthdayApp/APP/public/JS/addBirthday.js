$(document).ready(function(){
    $("#msg").hide();
    $("#add_birthday_form").on("submit",function(e){
        e.preventDefault();
        let name = $("#name").val();
        let birthday = $("#birthday").val();
        if(name == '' || birthday == '')
        {
            $("#msg").html("All fields are neccessary").show();
        }
        else
        {
            let formData = new FormData(this);
            $.ajax({
                url:"http://localhost/projects/BirthdayApp/API/addBirthday.php",
                type:"POST",
                dataType:"JSON",
                data:formData,
                processData:false,
                contentType:false,
                beforesend:function(){
                    $("#msg").html("Loading ...").show();
                },
                success:function(data){
                    console.log(data);
                    if(data.flg == 1)
                    {
                        $("#msg").html("Birthday added Successfully").show();
                        $("#add_birthday_form").trigger("reset");
                    }
                    else if(data.flg == -1)
                    {
                        $("#msg").html("Enough data was not provided").show();
                    }
                    else if(data.flg == -2)
                    {
                        $("#msg").html("The name already exists").show();
                    }
                    else if(data.flg == -3)
                    {
                        $("#msg").html("Internal Server Error").show();
                    }
                    else if(data.flg == -4)
                    {
                        $("#msg").html("File size should be maximum of 5 MB").show();
                    }
                    else if(data.flg == -5)
                    {
                        $("#msg").html("Could not upload Image").show();
                    }
                    else if(data.flg == -6)
                    {
                        $("#msg").html("Please Upload an Image File").show();
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").hide();
        },2500);
    });
});