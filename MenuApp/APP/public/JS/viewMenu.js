$(document).ready(function(){
    $("#msg").hide();
    $("#update_item_form_div").hide();
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
                    $("#empty_msg").remove();
                    if(data.items.length > 0)
                    {
                        $.each(data.items,function(key,item){
                            $("#items_div").append(
                                "<div id = 'item_card_" + item.item_id + "'>" +
                                    "<div>" +
                                        "<img src = '" + item.imageUrl + "' alt = 'error' />" + 
                                    "<div>" +
                                    "<div>" +
                                        "<div>" +
                                            "<h3 id = 'name_" + item.item_id + "'>" +
                                                item.name +  
                                            "</h3>" +
                                            "<h3 id = 'price_" + item.item_id + "'>" +
                                                item.price + 
                                            "</h3>" +
                                        "</div>" +
                                        "<div>" +
                                            "<p id = 'description_" + item.item_id + "'>" + item.description + "</p>" +
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
                        $("#items_div").html("");
                        $("#items_div").append("<h4 id = 'empty_msg'>Menu is Empty</h4>");
                    }
                    
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

    function loadItemData(itemId)
    {
        let obj = {itemId};
        let data = JSON.stringify(obj);
        $.ajax({
            url:"http://localhost/projects/MenuApp/API/getItem.php",
            type:"POST",
            dataType:"JSON",
            data:data,
            beforesend:function()
            {
                $("#msg").html("Loading ...").show();
            },
            success:function(data)
            {
                if(data.flg == 1)
                {
                    $("#name").val(data.item.name);
                    $("#price").val(data.item.price);
                    $("#description").val(data.item.description);
                    $("#update_item_form").append("<input id = 'itemId' type = 'hidden' value = '" + data.item.item_id + "' />")
                }
                else
                {
                    $("#msg").html("Error while Loading data").show();
                }
            }
        });
    }

    $(document).on("click","#upd_btn",function(){
        let itemId = $(this).data('id');
        $("#update_item_form_div").show();
        loadItemData(itemId);
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    });

    $("#update_item_form").on("submit",function(e){
        // alert("hello");
        e.preventDefault();
        let name = $("#name").val();
        let price = $("#price").val();
        let description = $("#description").val();
        let itemId = $("#itemId").val();
        if(name === '' || price == '' || description == '')
        {
            $("#msg").html("All fields are neccessary").show();
        }
        else
        {
            let obj = {itemId,name,price,description};
            let data = JSON.stringify(obj);
            $.ajax({
                url:"http://localhost/projects/MenuApp/API/updateItem.php",
                dataType:"JSON",
                type:"POST",
                data:data,
                beforesend:function()
                {
                    $("#msg").html("Loading ...").show();
                },
                success:function(data)
                {
                    console.log(data);
                    if(data.flg == 1)
                    {
                        $("#msg").html("Item updated successfully").show();
                        $("#update_item_form").trigger("reset");
                        $("#update_item_form_div").hide();
                        $("#name_" + itemId).html(name);
                        $("#price_" + itemId).html(price);
                        $("#description_" + itemId).html(description);
                    }
                    else
                    {
                        $("#msg").html("Error updating. Please try again later ..").show();
                        $("#update_item_form").trigger("reset");
                        $("#update_item_form_div").hide();
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    });

    $(document).on("click","#dlt_btn",function(){
        // alert("hello");
        if(confirm("Item will be removed. Proceed ? "))
        {
            let itemId = $(this).data('id');
            let obj = {itemId};
            let data = JSON.stringify(obj);
            $.ajax({
                url:"http://localhost/projects/MenuApp/API/deleteItem.php",
                type:"POST",
                data:data,
                dataType:"JSON",
                beforesend:function()
                {
                    $("#msg").html("Loading ...").show();
                },
                success:function(data)
                {
                    console.log(data);
                    if(data.flg == 1)
                    {
                        // $("#item_card_" + itemId).remove();
                        loadItems(-1);
                        $("#msg").html("Menu Item removed Successfully").show();
                    }
                    else
                    {
                        $("#msg").html("Error while removing").show();
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    });
});