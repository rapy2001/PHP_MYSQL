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
                    $("#show_categories_div").html("");
                    $.each(data.categories,function(key,category){
                        $("#show_categories_div").append(
                            "<h4 id = 'category' data-id = '" + category.category_id + "'>" + category.category_name + "<button id = 'dlt_btn' data-id = '" + category.category_id + "'>" + "Delete</button></h4>"
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

    $(document).on("click","#dlt_btn",function(){
        if(confirm("Category will be deleted. Proceed ?"))
        {
            let categoryId = $(this).data('id');
            let obj = {categoryId};
            let data = JSON.stringify(obj);
            $.ajax({
                url:"http://localhost/projects/MenuApp/API/deleteCategory.php",
                type:"POST",
                data:data,
                dataType:"JSON",
                beforesend:function()
                {
                    $("#msg").html("Loading ...").show();
                },
                success:function(data){
                    console.log(data);
                    if(data.flg == 1)
                    {
                        $("#msg").html("Category deleted successfully").show();
                        loadCategories();
                    }
                    else
                    {
                        $("#msg").html("Category could not be deleted").show();
                    }
                }
            });
            setTimeout(function(){
                $("#msg").html("").hide();
            },2500);
        }
        
    });
});