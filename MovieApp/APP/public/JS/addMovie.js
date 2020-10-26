$(document).ready(function(){
    $("#msg").hide();
    $("#image_form_div").hide();


    $("#add_movie_form").on("submit",function(e){
        e.preventDefault()
        let name = $("#name").val();
        let description = $("#description").val();
        let year = $("#year").val();
        let director = $("#director").val();
        let genre = $("#genre").val();
        if(name == '' || description == '' || year == '' || director == '')
        {
            $("#msg").html("All Fields are required").addClass("error").show();
        }
        else
        {
            let formData = {
                name,
                description,
                year,
                director,
                genre
            };
            let data = JSON.stringify(formData);
            $.ajax({
                url:"http://localhost/projects/MovieApp/API/addMovie.php",
                type:"POST",
                dataType:"JSON",
                data:data,
                beforesend:function(){
                    $("#msg").html("Loading ..").addClass("process").show();
                },
                success:function(data){
                    // console.log(data);
                    $("#add_movie_form").trigger("reset");
                    if(data.flg == 1)
                    {
                        // $("#msg").class("");
                        $("#msg").html("Movie Added successfully").addClass("success").show();
                        $("#main_form_div").hide();
                        $("#image_form_div").show();
                        $("#movie_id").val(data.movie_id);
                    }
                    else if(data.flg == -1)
                    {
                        $("#msg").html("All Fields are mandatory").addClass("error").show();
                    }
                    else if(data.flg == -2)
                    {
                        $("#msg").html("The Movie Name already exists").addClass("error").show();
                    }
                    else if(data.flg == -3)
                    {
                        $("#msg").html("Movie could not be added").addClass("error").show();
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").hide();
        },2500);
    });


    $("#image_form").on("submit",function(e){
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url:"http://localhost/projects/MovieApp/API/addMovieImage.php",
            type:"POST",
            dataType:"JSON",
            data:formData,
            processData:false,
            contentType:false,
            beforesend:function()
            {
                $("#msg").html("Loading ..").addClass("process").show();
            },
            success:function(data){
                // console.log(data);
                if(data.flg == 1)
                {
                    $("#msg").html("Image Uploaded Successfully").addClass("success").show();
                    $("#image").val("");
                    $("#img_div").show();
                    $("#img_div").append("<h1>Your Uploaded Image</h1>");
                    $("#img_div").append('<div class = "img_box"><img src = "' + data.path + '" alt = "error"/></div>');
                    $("#img_div").append('<button id = "delete_btn" class = "btn" data-path = ' + data.path + '>Delete</button>');
                }
                else if(data.flg == -1)
                {
                    $("#msg").html("Only Image FIles are allowed").addClass("error").show();
                }
                else if(data.flg == -2)
                {
                    $("#msg").html("File size should not be greater than 5 MB").addClass("error").show();
                }
                else if(data.flg == -3)
                {
                    $("#msg").html("Error while uploading the Image").addClass("error").show();
                }
                else if(data.flg == -4)
                {
                    $("#msg").html("Enough data not Provided").addClass("error").show();
                }
                else if(data.flg == -5)
                {
                    $("#msg").html("Image could not be Updated").addClass("error").show();
                }
            }
        });
        setTimeout(function(){
            $("#msg").hide();
        },2500);
    });

    $(document).on("click","#delete_btn",function(){
        // alert("hello");
        let path = $(this).data("path");
        let data = {path};
        data = JSON.stringify(data);
        // console.log(path);
        $.ajax({
            url:"http://localhost/projects/MovieApp/API/deleteMovieImage.php",
            type:"POST",
            data:data,
            dataType:"JSON",
            success:function(data){
                // alert("hello");
                console.log(data);
                if(data.flg == 1)
                {
                    $("#msg").html("Image deleted Successfully").addClass("success").show();
                    $("#img_div").html("").hide();
                }
                else
                {
                    $("#msg").html("Error while deleting the Image").addClass("error").show();
                }
                
            }
        });
        setTimeout(function(){
            $("#msg").hide();
        },2500);
    });
});