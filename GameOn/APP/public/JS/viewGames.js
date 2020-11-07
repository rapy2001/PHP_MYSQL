$(document).ready(function(){
    $("#msg").hide();
    $("#game_full_box").hide();
    function loadUpcomingGames()
    {
        $.ajax({
            url:"http://localhost/projects/GameOn/API/getUpcomingGames.php",
            type:"POST",
            dataType:"JSON",
            success:function(data)
            {
                console.log(data);
                if(data.flg == 1)
                {
                    $("#upcoming_games").html('');
                    $("#upcoming_games").append('<h2>Upcoming Games</h2>');
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
                            <div>
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

    $(document).on("click",'.game_card',function(){
        let gameId = $(this).data('game_id');
        let obj = {gameId};
        let data = JSON.stringify(obj);
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
});