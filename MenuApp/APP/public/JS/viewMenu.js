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
                    $("#category_div").append(
                        "<button id = 'category_btn' data-id = '-1'>All</button>"
                    );
                    $.each(data.categories,function(key,category){
                        $("#category_div").append(
                            "<button id = 'category_btn' data-id = '" + category.category_id + "'>" + category.category_name + "</button>"
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
    function loadItems(categoryId)
    {
        let obj = {categoryId};
        let data = JSON.stringify(obj);
        $.ajax({
            url:"http://localhost/projects/MenuApp/API/getItems.php",
            type:"POST",
            data:data,
            dataType:"JSON",
            beforesend:function()
            {
                $("#msg").html("Loading Items ...").show();
            },
            success:function(data)
            {
                // console.log(data);
                if(data.flg == 1)
                {
                    $.each(data.items,function(key,item){
                        $("#items_div").append(
                            "<div>" +
                            "<div>" +
                                "<img src = '" + item.imageUrl + "' alt = 'error' />" + 
                            "<div>" +
                            "<div>" +
                                "<div>" +
                                    "<h3>" +
                                        item.name +  
                                    "</h3>" +
                                    "<h3>" +
                                        item.price + 
                                    "</h3>" +
                                "</div>" +
                                "<div>" +
                                    "<p>" + item.description + "</p>" +
                                "</div>" +
                                "<div>" +
                                    "<button id = 'upd_btn' data-id = '" + item.item_id + "'>" + "Update</button>" +
                                    "<button id = 'dlt_btn' data-id = '" + item.item_id + "'>" + "Delete</button>" +
                                "</div>" +
                            "</div>" +
                        "</div>"
                        )
                    });
                }
                else
                {
                    $("#msg").html("Failed to load the Menu Items").show();
                }
            }
        });
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    }

    loadItems(-1);
    $(document).on("click","#category_btn",function(){
        let categoryId = $(this).data('id');
        console.log(categoryId);
        $("#items_div").html("");
        loadItems(categoryId);
    });
});