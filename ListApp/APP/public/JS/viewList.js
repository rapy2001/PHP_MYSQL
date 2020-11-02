$(document).ready(function(){
    $("#msg").hide();
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
                            $("#list_items_div").append(
                                "<div>" +
                                    "<div>" +
                                        "<h4>" + item.item_text + "</h4>" +
                                    "<div>" +
                                    "<div>" +
                                        "<button id = 'chk_btn'>Check</button>" +
                                        "<button id = 'upd_btn'>Update</button>" +
                                        "<button id = 'dlt_btn'>Delete</button>" +
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
});