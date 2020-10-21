$(document).ready(function(){
    $("#msg").hide();
    $("#img_div").hide();
    $("#form").on("submit",function(e){
        
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url:"http://localhost/projects/Upload/upload.php",
            type:"POST",
            data:formData,
            processData:false,
            contentType:false,
            dataType:"JSON",
            success:function(data){
                if(data.flg == 1)
                {
                    $("#msg").text("Image Uploaded successfully").show();
                    $("#img_div").show();
                    $("#img_div").append("<h1>Your Uploaded Image</h1>");
                    $("#img_div").append('<div class = "img_box"><img src = "' + data.path + '" alt = "error"/></div>');
                    $("#img_div").append('<button id = "delete_btn" data-path = ' + data.path + '>Delete</button>');
                }
                else if(data.flg == -1)
                {
                    $("#msg").text("Please Upload an Image File").show();
                    
                }
                else if(data.flg == -2)
                {
                    $("#msg").text("Please Upload an Image File of size not more than 10 MB").show();
                }
                else if(data.flg == -3)
                {
                    $("#msg").text("Internal Server Error. Please try again later").show();
                }
                setTimeout(function(){
                    $("#msg").hide();
                },2500);
                $("#image").val("");
            }
        });
    });
    $(document).on("click","#delete_btn",function(){
        let path = $(this).data("path");
        $.ajax({
            url:"http://localhost/projects/Upload/deleteUpload.php",
            type:"POST",
            data:{path:path},
            dataType:"JSON",
            success:function(data){
                if(data.flg == 1)
                {
                    $("#msg").text("Image deleted Successfully").show();
                    $("#img_div").html("").hide();
                }
                else
                {
                    $("#msg").text("Error while deleting the Image").show();
                }
                setTimeout(function(){
                    $("#msg").hide();
                },2500);
            }
        });
    });
});