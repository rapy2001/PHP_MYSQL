$(document).ready(function(){
    $("#msg").hide();

    function loadCategories()
    {
        $.ajax({
            url:"http://localhost/projects/GameOn/API/getCategories.php",
            type:"POST",
            dataType:"JSON",
            beforesend:function()
            {
                $("#msg").html('Loading ...').hide();
            },
            success:function(data)
            {
                if(data.flg == 1)
                {
                    $.each(data.categories,function(key,category){
                        $("#category").html();
                        $("#category").append(
                            `<option value = '${category.category_id}'>${category.category_name}</option>`
                        );
                    });
                }
            }
        });
        setTimeout(function(){
            $("#msg").html('').hide();
        },2500)
    }
    loadCategories();
    $("#add_game_form").on('submit',function(e){
        e.preventDefault();
        let gameName = $("#gameName");
        let gameDate = $("#gameDate");
        let gameDescription = $("#gameDescription");
        if(gameName == '' || gameDate == '' || gameDescription == '')
        {
            $("#msg").html('All fields are necessary').show();
        }
        else
        {

        }
        setTimeout(function(){
            $("#msg").html('').hide();
        },2500)
    });
});