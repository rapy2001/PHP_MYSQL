$(document).ready(function(){
    $("#msg").hide();
    $("#add_category_form").on("submit",function(e){
        e.preventDefault();
        let categoryName = $("#name").val();
        if(categoryName == '')
        {
            $("#msg").html("All fields are necessary").show();
        }
        else
        {
            let obj = {categoryName};
            let data = JSON.stringify(obj);
            $.ajax({
                url:"http://localhost/projects/MenuApp/API/addCategory.php",
                type:"POST",
                data:data,
                dataType:"JSON",
                beforesend:function()
                {
                    $("#msg").html("Loading ...").show();
                    $("#add_category_form").trigger("reset");
                },
                success:function(data){
                    if(data.flg == 1)
                    {
                        $("#msg").html("Category added successfully").show();
                        $("#add_category_form").trigger("reset");
                        setTimeout(function(){
                            window.location.assign("./addItem.php");
                        },3500);
                    }
                    else
                    {
                        $("#msg").html("Error while adding the category").show();
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    });
});