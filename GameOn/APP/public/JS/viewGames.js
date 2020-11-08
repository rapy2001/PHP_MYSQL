$(document).ready(function(){
    $("#msg").hide();
    $("#game_full_box").hide();
    $("#search_results").hide();
    function loadUpcomingGames()
    {
        $.ajax({
            url:"http://localhost/projects/GameOn/API/getUpcomingGames.php",
            type:"POST",
            dataType:"JSON",
            success:function(data)
            {
                // console.log(data);
                if(data.flg == 1)
                {
                    $("#upcoming_games").html('');
                    $("#upcoming_games").append('<h1>Upcoming Games</h1>');
                    if(data.games.length > 0)
                    {
                        $.each(data.games,function(key,game){
                            $('#upcoming_games').append(`
                                <div id = 'game_${game.game_id}' class = 'game_card' data-game_id = ${game.game_id}>
                                    <div>
                                        <h2>${game.name}</h2>
                                        <h4>Releasing On: ${game.game_date}</h4>
                                    </div>
                                    <div>
                                        <img src = '${game.imageUrl}' alt = '${game.name}'/>
                                    </div>
                                    <div>
                                        <h3>${game.category_name}</h3>
                                    </div>
                                </div>
                            `);
                        });
                    }
                    else
                    {
                        $('#upcoming_games').append(`
                            <div class = 'empty'>
                                <h4>No Upcoming Games ...</h4>
                            </div>
                        `);
                    }
                }   
                else
                {
                    $("#upcoming_games").append(`
                        <h2>Upcoming Games</h2>
                        <div>
                            <h4>Error Loading the Upcoming Games</h4>
                        </div>
                    `)
                }
            }
        });
        setTimeout(function(){
            $("#msg").html('').hide();
        },2500);
    }

    loadUpcomingGames();
    function loadCategoryGames(category,category_name)
    {
        $("#" + category_name).html('');
        $("#" + category_name).append(`<h1>${category_name}</h1>`);
        let obj = {category};
        let data = JSON.stringify(obj);
        $.ajax({
            url:"http://localhost/projects/GameOn/API/getCategoryGame.php",
            type:"POST",
            dataType:"JSON",
            data:data,
            success:function(data)
            {
                if(data.flg == 1)
                {
                    // $("#category_games").html('');
                    
                    
                    if(data.games.length > 0)
                    {
                        $.each(data.games,function(key,game){
                            $("#" + category_name).append(`
                                <div id = 'game_${game.game_id}' class = 'game_card' data-game_id = ${game.game_id}>
                                    <div>
                                        <h2>${game.name}</h2>
                                        <h4>Released On: ${game.game_date}</h4>
                                    </div>
                                    <div>
                                        <img src = '${game.imageUrl}' alt = '${game.name}'/>
                                    </div>
                                    <div>
                                        <h3>${game.category_name}</h3>
                                    </div>
                                </div>
                            `)
                        });
                    }
                    else
                    {
                        $("#" + category_name).append(`
                            <div class = 'empty'>
                                <h4>No Games Yet</h4>
                            </div>
                        `);
                    }
                    
                    
                }
                else
                {
                    $("#msg").html('Error while Loading the Games for this Category').show();
                }
            }
        });
        setTimeout(function(){
            $("#msg").html('').hide();
        },2500)
    }

    function loadGames()
    {
        $.ajax({
            url:"http://localhost/projects/GameOn/API/getCategories.php",
            type:"POST",
            dataType:"JSON",
            success:function(data)
            {
                if(data.flg == 1)
                {
                    $.each(data.categories,function(key,category){
                        $("#category_games").append("<div class = 'category_games_div' id = '" + category.category_name + "' >");
                        $("#category_games").append("</div>");
                        loadCategoryGames(category.category_id,category.category_name);
                    });
                }
                else
                {
                    $("#msg").html("Error while Loading the Games").show();
                }
            }
        });
        setTimeout(function(){
            $("#msg").html('').hide();
        },2500);
    }

    loadGames();
    $(document).on("click",'.game_card',function(){
        let gameId = $(this).data('game_id');
        let obj = {gameId};
        let data = JSON.stringify(obj);
        console.log(data);
        $.ajax({
            url:"http://localhost/projects/GameOn/API/getGameDetails.php",
            data:data,
            dataType:"JSON",
            type:"POST",
            success:function(data)
            {
                if(data.flg == 1)
                {
                    $("#game_full_box").show();
                    $("#game_full_box").html('');
                    $("#game_full_box").append(
                        `
                            <div>
                                <h1>${data.game.name}</h1>
                            </div>
                            <div>
                                <h4>${data.game.game_date}</h4>
                                <h4>${data.game.category_name}</h4>
                            </div>
                        `
                    )
                    $("#game_full_box").append(
                        "<div>"
                    )
                    for(let i = 0; i<data.platforms.length; i++)
                    {
                        $("#game_full_box").append(
                            "<h4>"+ data.platforms[i].platform_name + "</h4>"
                        );
                    }
                    $("#game_full_box").append(
                        "</div>"
                    );
                    $("#game_full_box").append(
                        `
                            <div>
                                ${data.game.description}
                            </div>
                        `
                    );
                    if(data.images.length > 0)
                    {
                        $.each(data.images,function(key,image){
                            $("#game_full_box").append(
                                `<img src = '${image.image}' alt = 'data.game.name'/>`
                            )
                        });
                    }
                    else
                    {
                        $("#game_full_box").append(`
                            <div>
                                <h4>No Images Provided</h4>
                            </div>
                        `);
                    }
                }
                else
                {
                    $("#msg").html('Error loading Game Details ...').show();
                }
            }
        });
        setTimeout(function(){
            $("#msg").html('').hide();
        },2500);
    });

    $("#search_term").on("keyup",function(){
        if($(this).val() != '')
        {
            let searchTerm = $(this).val();
            let obj = {searchTerm};
            let data = JSON.stringify(obj);
            $.ajax({
                url:"http://localhost/projects/GameOn/API/getSearchResults.php",
                type:"POST",
                dataType:"JSON",
                data:data,
                success:function(data)
                {
                    $("#search_results").show();
                    $("#search_results").html('');
                    $("#upcoming_games").hide();
                    $("#category_games").hide();
                    if(data.flg == 1)
                    {
                        $("#search_results").append(`
                            <h3>The following Games were found for "${searchTerm}"</h3>
                        `);
                        $.each(data.games,function(key,game){
                            $("#search_results").append(`
                                <div id = 'game_${game.game_id}' class = 'game_card' data-game_id = ${game.game_id}>
                                    <div>
                                        <h2>${game.name}</h2>
                                        <h4>Released On: ${game.game_date}</h4>
                                    </div>
                                    <div>
                                        <img src = '${game.imageUrl}' alt = '${game.name}'/>
                                    </div>
                                    <div>
                                        <h3>${game.category_name}</h3>
                                    </div>
                                </div>
                            `);
                        });
                    }
                    else
                    {
                        $("#msg").html('Internal Server Error').show();
                    }
                }
            });
        }
        else
        {
            $("#search_results").hide();
            $("#upcoming_games").show();
            $("#category_games").show();
        }
        setTimeout(function(){
            $("#msg").html('').hide();
        },2500);
        
    });
});