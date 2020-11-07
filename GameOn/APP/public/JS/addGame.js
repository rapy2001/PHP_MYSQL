$(document).ready(function(){
    $("#msg").hide();
    let globalPlatforms = '';
    function loadCategories()
    {
        $.ajax({
            url:"http://localhost/projects/GameOn/API/getCategories.php",
            type:"POST",
            dataType:"JSON",
            beforesend:function()
            {
                $("#msg").html('Loading Categories ...').show();
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
                else
                {
                    $("#msg").html('Failed to Load Categories').show();
                }
            }
        });
        setTimeout(function(){
            $("#msg").html('').hide();
        },2500)
    }
    loadCategories();

    function loadPlatforms()
    {
        $.ajax({
            url:"http://localhost/projects/GameOn/API/getPlatforms.php",
            dataType:"JSON",
            type:"POST",
            beforesend:function()
            {
                $("#msg").html('Loading Platforms ...').show();
            },
            success:function(data)
            {
                if(data.flg == 1)
                {
                    globalPlatforms = data.platforms;
                    $.each(data.platforms,function(key, platform){
                        $('#add_game_form').append(
                            `
                                <label for = 'platform_${platform.platform_id}'>${platform.platform_name}</label>
                                <input type = 'checkbox' value = '${platform.platform_id}' id = 'platform_${platform.platform_id}'/>
                            `
                        )
                    });
                }
                else
                {
                    $("#msg").html('Error while Loading the Platforms').show();
                }
            }
        });
        setTimeout(function(){
            $("#msg").html('').hide();
        },2500);
    }

    loadPlatforms();
    $("#add_game_form").on('submit',function(e){
        e.preventDefault();
        let gameName = $("#gameName").val();
        let gameDate = $("#gameDate").val();
        let gameDescription = $("#gameDescription").val();
        let gameCategory = $("#category").val();
        let dataPlatforms = [];
        for(let i = 0; i<globalPlatforms.length; i++)
        {
            let selector_1 = 'platform_' + globalPlatforms[i].platform_id;
            let selector_2 = '#platform_' + globalPlatforms[i].platform_id;
            if(document.getElementById(selector_1).checked)
            {
                dataPlatforms.push($(selector_2).val());
            }
                
        }
        // console.log(dataPlatforms);
        if(gameName == '' || gameDate == '' || gameDescription == '')
        {
            $("#msg").html('All fields are necessary').show();
        }
        else
        {
            let obj = {gameName,gameDate,gameDescription,gameCategory,dataPlatforms};
            // console.log(obj);s
            let data =JSON.stringify(obj);
            $.ajax({
                url:"http://localhost/projects/GameOn/API/addGame.php",
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
                        $("#msg").html('Game added successfully').show();
                        $("#add_game_form").trigger('reset');
                        setTimeout(function(){
                            window.location.assign(`./addGameImage.php?gameId=${data.id}`);
                        },3500);
                    }
                    else if(data.flg == -2)
                    {
                        $("#msg").html('The Game Name already exists. Please try a different name').show();
                    }
                    else
                    {
                        $("#msg").html('Internal Server Error. Please try again').show();
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").html('').hide();
        },2500)
    });
});