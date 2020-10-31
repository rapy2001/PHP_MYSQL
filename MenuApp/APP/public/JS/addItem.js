$(document).ready(function(){
    $("#msg").hide();

    function loadCategories()
    {
        $.ajax({
            url:"http://localhost/projects/MenuApp/API/getCategories.php",
            type:"GET",
            dataType:"JSON",
            beforesend:function()
            {
                $("#msg").html("Loading Categories ...").show();
            },
            success:function(data){
                if(data.flg == 1)
                {
                    $.each(data.categories,function(key,category){
                        $("#categoryId").append(
                            "<option value = '" + category.category_id +"'>" + category.category_name + "</option>"
                        );
                    });
                    
                }
                else
                {
                    $("#msg").html("Failed to load categories").show();
                }
            }
        });
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    }

    loadCategories();
    $("#add_item_form").on("submit",function(e){
        e.preventDefault();
        let name = $("#name").val();
        let price = $("#price").val();
        let description = $("#description").val();
        let categoryId = $("#categoryId").val();
        if(name == '' || price == '' || description == '' || categoryId == '')
        {
            $("#msg").html("All fields are mandatory").show();
        }
        else
        {
            let formData = new FormData(this);
            $.ajax({
                url:"http://localhost/projects/MenuApp/API/addItem.php",
                type:"POST",
                data:formData,
                dataType:"JSON",
                processData:false,
                contentType:false,
                beforesend:function()
                {
                    $("#msg").html("Loading ...").show();
                },
                success:function(data){
                    // console.log(data);
                    if(data.flg == 1)
                    {
                        $("#msg").html("Item added successfully").show();
                        $("#add_item_form").trigger("reset");
                        setTimeout(function(){
                            window.location.assign("./homepage.php");
                        },3000);
                    }
                    else if(data.flg == -1)
                    {
                        $("#msg").html("Enough data not provided").show();
                    }
                    else if(data.flg == -2)
                    {
                        $("#msg").html("Error connecting ...").show();
                    }
                    else if(data.flg == -3)
                    {
                        $("#msg").html("Error Inserting").show();
                    }
                    else if(data.flg == -4)
                    {
                        $("#msg").html("Please upload an image file").show();
                        $("#image").val("");
                    }
                    else if(data.flg == -5)
                    {
                        $("#msg").html("Max file size is 5 MB").show();
                    }
                    else if(data.flg == -6)
                    {
                        $("#msg").html("Error uploading").show();
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    });
});