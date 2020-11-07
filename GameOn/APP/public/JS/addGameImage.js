$(document).ready(function(){
    let url = window.location.href;
    let obj = new URL(url);
    let gameId = obj.searchParams.get('gameId');
    $("#msg").html('').hide();
    $("#image_div").hide();
    $("#add_image_form").remove('#gameId');
    $("#add_image_form").append(`<input type = 'hidden' value = '${gameId}' name = 'gameId' id = 'gameId'/>`);
    $("#add_image_form").on('submit',function(e){
        e.preventDefault();
        let gameId = $("#gameId").val();
        let image = $("#image").val();
        if(gameId == '' || image == '')
        {
            $("#msg").html('All fields are neccessary').show();
        }
        else
        {
            let data = new FormData(this);
            $.ajax({
                url:"http://localhost/projects/GameOn/API/addGameImage.php",
                type:"POST",
                data:data,
                processData:false,
                contentType:false,
                dataType:"JSON",
                beforesend:function()
                {
                    $("#msg").html('Loading ...').show();
                },
                success:function(data)
                {
                    if(data.flg == 1)
                    {
                        $("#msg").html('Image added Successfully').show();
                        $("#image_div").show();
                        // $("#image_div").html('');
                        $("#image_div").append(
                            `  <div id = 'image_box_${data.imageId}'>
                                    <img id = 'image_${data.imageId}'src = '${data.relative}' alt = 'Game Image'/>
                                    <button id = 'delete_btn' data-image_id = ${data.imageId}>Delete</button>
                                </div>
                            `
                        )
                        // $("#image_div").append(`<img id = 'image_${data.imageId}'src = '${data.relative}' alt = 'Game Image'/>`);
                        // $("#image_div").append(`<button id = 'delete_btn' data-image_id = ${data.imageId}>Delete</button>`);
                        $("#add_image_form").trigger('reset');
                    }
                    else if(data.flg == -1)
                    {
                        $("#msg").html('Enough Data not provided').show();
                    }
                    else if(data.flg == -2)
                    {
                        $("#msg").html('Please Upload an Image File').show();
                    }
                    else if(data.flg == -3)
                    {
                        $("#msg").html('Max File SIze Allowed is 5 MB').show();
                    }
                    else if(data.flg == -4)
                    {
                        $("#msg").html('Could not get Game Name').show();
                    }
                    else if(data.flg == -5)
                    {
                        $("#msg").html('Error While Inserting').show();
                    }
                    else if(data.flg == -6)
                    {
                        $("#msg").html('Error Uploading').show();
                    }
                    else if(data.flg == -7)
                    {
                        $("#msg").html('Internal Server Error').show();
                    }
                    else if(data.flg == -8)
                    {
                        $("#msg").html('Max 5 Images can be Uploaded').show();
                        $("#add_image_form").trigger('reset');
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").html('').hide();
        },2500)
    });

    $(document).on("click","#delete_btn",function(){
        // console.log('hello');
        let imageId = $(this).data('image_id');
        if(imageId == '')
        {
            $("#msg").html('Enough data not available').show();
        }
        else
        {
            let obj = {imageId};
            let data = JSON.stringify(obj);
            $.ajax({
                url:"http://localhost/projects/GameOn/API/deleteGameImage.php",
                data:data,
                dataType:"JSON",
                type:"POST",
                beforesend:function()
                {
                    $("#msg").html('Loading ...').show();
                },
                success:function(data)
                {
                    // console.log(data);
                    if(data.flg == 1)
                    {
                        $("#msg").html("Image Delete Successfully");
                        // $("#image_" + imageId).remove();
                        $("#image_box_" + imageId).remove();
                        // $("#image_div").hide();
                    }
                    else
                    {
                        $("#msg").html('Error while deleting the Image');
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").html('').hide();
        },2500);
    });
});