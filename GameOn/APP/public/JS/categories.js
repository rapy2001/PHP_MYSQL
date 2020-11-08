$(document).ready(function(){
    $("#msg").hide();
    // $("#update_category_form").hide();
    $("#update_category_div").hide();
    function loadCategories()
    {
        $.ajax({
            url:"http://localhost/projects/GameOn/API/getCategories.php",
            type:"POST",
            dataType:"JSON",
            success:function(data)
            {
                $("#category_div").html('');
                if(data.flg == 1)
                {
                    if(data.categories.length > 0)
                    {
                        $.each(data.categories,function(key,category){
                            $("#category_div").append(`
                                <div class = 'category_card' id = 'category_card_${category.category_id}'>
                                    <h4>${category.category_name}</h4>
                                    <div>
                                        <button id = 'dlt_btn' data-category_id = '${category.category_id}'>Delete</button>
                                        <button id = 'upd_btn' data-category_id = '${category.category_id}'>Update</button>
                                    </div>
                                </div>
                            `);
                        });
                    }
                    else
                    {
                        $("#category_div").append('<h1>No Categories Yet</h1>');
                    }
                }
                else
                {
                    $("#msg").html('Error while Loading the categories').show();
                }
            }
        });
        setTimeout(function(){
            $("#msg").html('').hide();
        },2500);
    }

    loadCategories();

    $(document).on('click','#dlt_btn',function(){
        if(confirm('Category and the Games Under it will be Removed. Proceed ?'))
        {
            $("#update_category_form").trigger("reset");
            $("#update_category_div").hide();
            $("#category_form").show();
            let categoryId = $(this).data('category_id');
            let obj = {categoryId};
            let data = JSON.stringify(obj);
            $.ajax({
                url:"http://localhost/projects/GameOn/API/deleteCategory.php",
                type:"POST",
                dataType:"JSON",
                data:data,
                success:function(data)
                {
                    if(data.flg == 1)
                    {
                        $("#msg").html('Category removed successfully').show();
                        $("#category_card_" + categoryId).remove();
                    }
                    else
                    {
                        $("#msg").html('Category could not removed. Please try again.').show();
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").html('').hide();
        },2500);
    });

    $("#category_form").on('submit',function(e){
        
        e.preventDefault();
        let categoryText = $("#categoryText").val();
        let obj = {categoryText};
        let data = JSON.stringify(obj);
        if(categoryText == '')
        {
            $("#msg").html('No Category was given').show();
        }
        else
        {
            $.ajax({
                url:"http://localhost/projects/GameOn/API/addCategory.php",
                type:"POST",
                dataType:"JSON",
                data:data,
                success:function(data)
                {
                    // console.log(data);
                    if(data.flg == 1)
                    {
                        $("#category_form").trigger('reset');
                        $("#msg").html('Category Added').show();
                        loadCategories();
                    }
                    else if(data.flg == 2)
                    {
                        $("#msg").html('Category already exists. Please enter a different category').show();
                        $("#category_form").trigger('reset');
                    }
                    else
                    {
                        $("#msg").html('Internal Server Error').show();
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").html('').hide();
        },2500);
    });
    function getCategory(categoryId)
    {
        let obj = {categoryId};
        let data = JSON.stringify(obj);
        $.ajax({
            url:"http://localhost/projects/GameOn/API/getCategory.php",
            data:data,
            type:"POST",
            dataType:"JSON",
            success:function(data)
            {
                // console.log(data);
                if(data.flg == 1)
                {
                    $("#updatedCategoryText").val(data.category.category_name);
                    $("#hiddenCategory").val(data.category.category_id);
                }
                else
                {
                    $("#msg").html('Failed to Load Category').show();
                }
            }
        });
        setTimeout(function(){
            $("#msg").html('').hide();
        },2500);
    }
    $(document).on("click","#upd_btn",function(){
        let categoryId = $(this).data('category_id');
        getCategory(categoryId);
        $("#update_category_div").show();
        $("#category_form").hide();
    });

    $(document).on("submit","#update_category_form",function(e){
        e.preventDefault();
        let updatedCategoryText = $("#updatedCategoryText").val();
        let categoryId = $("#hiddenCategory").val();
        if(updatedCategoryText == '')
        {
            $("#msg").html('No Text was provied for Updating the Category').show();
        }
        else
        {
            let obj = {updatedCategoryText,categoryId};
            let data = JSON.stringify(obj);
            // console.log(data);
            $.ajax({
                url:"http://localhost/projects/GameOn/API/updateCategory.php",
                data:data,
                dataType:"JSON",
                type:"POST",
                success:function(data)
                {
                    if(data.flg == 1)
                    {
                        $("#msg").html('Category Updated Successfully').show();
                        loadCategories();
                        $("#update_category_form").trigger("reset");
                        $("#update_category_div").hide();
                        $("#category_form").show();
                    }
                    else if(data.flg == 2)
                    {
                        $("#msg").html('The given Category already exists. Please try a different Category Name').show();
                    }
                    else
                    {
                        $("#msg").html('Internal Server Error').show();
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").html('').hide();
        },2500);
    });

    $("#cancel_update").on("click",function(){
        $("#update_category_form").trigger("reset");
        $("#update_category_div").hide();
        $("#category_form").show();
    });
});