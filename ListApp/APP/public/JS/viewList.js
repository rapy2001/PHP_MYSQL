$(document).ready(function(){
    $("#msg").hide();
    $("#update_list_item_form").hide();
    function loadItems()
    {
        $.ajax({
            url:"http://localhost/projects/ListApp/API/getAllItems.php",
            type:"GET",
            dataType:"JSON",
            beforesend:function()
            {
                $("#msg").html("Loading ...").show();
            },
            success:function(data)
            {
                if(data.flg == 1)
                {
                    $("#list_items_div").html("");
                    if(data.items.length > 0)
                    {
                        $.each(data.items,function(key,item){
                            let className = '';
                            if(item.checked == 1)
                                className = 'checked';
                            $("#list_items_div").append(
                                "<div class = 'list_item' id = 'list_item_div_" + item.list_item_id + "'>" +
                                    "<div class = 'list_item_box_1'>" +
                                        "<h3 id = 'list_item_text_" + item.list_item_id + "' class = '" + className + "'>" + item.item_text + "</h3>" +
                                    "</div>" +
                                    "<div class = list_item_box_2>" +
                                        "<button data-id = '" + item.list_item_id + "' id = 'chk_btn'><i class = 'fa fa-check'></i></button>" +
                                        "<button data-id = '" + item.list_item_id + "' id = 'upd_btn'><i class = 'fa fa-pencil'></i></button>" +
                                        "<button data-id = '" + item.list_item_id + "' id = 'dlt_btn'><i class = 'fa fa-trash'></i></button>" +
                                    "</div>" +
                                "</div>"
                            );
                        });
                    }
                    else
                    {
                        $("#list_items_div").html("<h4>List is Empty</h4>");
                    }
                }
                else
                {
                    $("#msg").html("Failed to load List Items").show();
                }
            }
        });
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    }

    loadItems();
    $("#add_item_form").on("submit",function(e){
        e.preventDefault();
        let text = $("#text").val();
        if(text == '')
        {
            $("#msg").html("The Text can not be empty").show();
        }
        else
        {
            let obj = {text};
            let data = JSON.stringify(obj);
            $.ajax({
                url:"http://localhost/projects/ListApp/API/addListItem.php",
                type:"POST",
                data:data,
                dataType:"JSON",
                beforesend:function()
                {
                    $("#msg").html("Loading ...").show();
                },
                success:function(data)
                {
                    if(data.flg == 1)
                    {
                        $("#msg").html("Item added successfully").show();
                        $("#add_item_form").trigger("reset");
                        loadItems();
                    }
                    else
                    {
                        $("#msg").html("Item not added. Please try again");
                    }
                }
            });
        }
    });
    setTimeout(function(){
        $("#msg").html("").hide();
    },2500);

    $(document).on("click","#chk_btn",function(){
        let itemId = $(this).data('id');
        let obj = {itemId};
        let data = JSON.stringify(obj);
        $.ajax({
            url:"http://localhost/projects/ListApp/API/checkListItem.php",
            data:data,
            dataType:"JSON",
            type:"POST",
            beforesend:function()
            {
                $("#msg").html("Loading ...").show();
            },
            success:function(data)
            {
                // alert("hello");
                if(data.flg == 1)
                {
                    console.log(data);
                    $("#list_item_text_" + itemId).toggleClass("checked");
                    // $("#list_item_text_" + itemId).addClass("checked");
                }
                else
                {
                    $("#msg").html("Error while chekcing").show();
                }
            }
        });
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    });
    function loadItem(itemId)
    {
        let obj = {itemId};
        let data = JSON.stringify(obj);
        $.ajax({
            url:"http://localhost/projects/ListApp/API/getItem.php",
            data:data,
            dataType:"JSON",
            type:"POST",
            beforesend:function()
            {
                $("#msg").html("Loading ..").show();
            },
            success:function(data)
            {
                if(data.flg == 1)
                {
                    $("#upd_text").val(data.item.item_text);
                    $("#update_list_item_form").remove('#itemId');
                    $("#update_list_item_form").append("<input id = 'itemId' type = 'hidden' data-id = '" + data.item.list_item_id + "'/>");
                }
                else
                {
                    $("#msg").html("Error while getting the Item Data");
                }
            }
        });
    }

    $(document).on("click","#upd_btn",function(){
        $("#update_list_item_form").show();
        $("#add_item_form").hide();
        let itemId = $(this).data('id');
        loadItem(itemId);
        setTimeout(function(){
            $("#msg").hide();
        },2500);
    });

    $("#update_list_item_form").on("submit",function(e){
        e.preventDefault();
        let text = $("#upd_text").val();
        let itemId = $("#itemId").data('id');
        if(text == '' || itemId == '')
        {
            $("#msg").html("All fileds are Mandatory").show();
        }
        else
        {
            let obj = {text,itemId};
            let data = JSON.stringify(obj);
            $.ajax({
                url:"http://localhost/projects/ListApp/API/updateItem.php",
                data:data,
                dataType:"JSON",
                type:"POST",
                beforesend:function()
                {
                    $("#msg").html("Loading ...").show();
                },
                success:function(data)
                {   console.log(data);
                    if(data.flg == 1)
                    {
                        $("#update_list_item_form").trigger("reset").hide();
                        $("#add_item_form").show();
                        $("#msg").html("Item Updated Successfully").show();
                        $("#list_item_text_" + itemId).html(text);
                    }
                    else
                    {
                        $("#msg").html("Error Updating. Please try again later");
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").hide();
        },2500);
    });

    $(document).on("click",'#dlt_btn',function(){
        if(confirm('Item will be Removed. Proceed ?'))
        {
            let itemId = $(this).data('id');
            let obj = {itemId};
            let data = JSON.stringify(obj);
            $.ajax({
                url:"http://localhost/projects/ListApp/API/deleteItem.php",
                data:data,
                dataType:"JSON",
                type:"POST",
                beforesend:function()
                {
                    $("#msg").html("Loading ...").show();
                },
                success:function(data)
                {
                    console.log(data);
                    if(data.flg == 1)
                    {
                        $("#list_item_div_" + itemId).remove();
                        $("#msg").html("Item Removed from list").show();
                        let childs = $("#list_items_div").children();
                        if(childs.length == 0)
                        {
                            $("#list_items_div").append("<h4>Your List is Empty</h4>");
                        }
                    }
                    else
                    {
                        $("#msg").html("Item could not be deleted. Please try again").show();
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").hide();
        },2500);
    });
});