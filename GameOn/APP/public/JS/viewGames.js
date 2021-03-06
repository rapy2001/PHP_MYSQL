$(document).ready(function(){
    $("#msg").hide();
    $("#game_full_container").hide();
    // $("#game_full_box").hide();
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
        // console.log(data);
        $.ajax({
            url:"http://localhost/projects/GameOn/API/getGameDetails.php",
            data:data,
            dataType:"JSON",
            type:"POST",
            success:function(data)
            {
                // console.log(data);
                $('body').css("overflow-y","hidden");
                if(data.flg == 1)
                {
                    $(".viewGames").toggleClass("fade");
                    $("#game_full_container").show();
                    // $("#game_full_box").show();
                    $("#game_full_box").html('');
                    $("#game_full_box").append(
                        `
                            <div>
                                <h2>${data.game.name}</h2>
                            </div>
                            <div>
                                <h4>${data.game.game_date}</h4>
                                <h4>${data.game.category_name}</h4>
                            </div>
                        `
                    )
                    $("#game_full_box").append(
                        "<div id = 'platform_box'>"
                    )
                    for(let i = 0; i<data.platforms.length; i++)
                    {
                        let icon = '';
                        
                        $("#platform_box").append(
                            "<h4>"+ data.platforms[i].platform_name + "</h4>"
                        );
                    }
                    $("#game_full_box").append(
                        "</div>"
                    );
                    $("#game_full_box").append(
                        `
                            <div id = 'description_box'>
                                <p>
                                    ${data.game.description}
                                </p>
                                
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
                    let userId = $("#userId").val();
                    if(userId !=  '')
                    {
                        $("#game_full_box").append(`
                            <a class = 'btn' href = "./addReview.php?gameId='${data.game.game_id}'">Add a Review</a>
                        `);
                    }
                    else
                    {
                        $("#game_full_box").append(`
                            <div class = 'empty'>
                                <h4>Please Log In to add a Review</h4>
                            </div>
                        `);
                    }
                    $("#game_full_box").append(`
                        <div id = 'review_show_box'>
                            
                        </div>
                    `);
                    $("#game_full_box").append(`<input type = 'hidden' value = '${data.game.game_id}' id = 'gameId' />`);
                    $("#game_full_box").append(`
                        <button id = 'load_review_btn' data-page = '1'>Load Reviews</button>
                    `);
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

    $("#game_cut").click(function(){
        $("#game_full_container").hide();
        $(".viewGames").toggleClass("fade");
        $('body').css("overflow-y","auto");
    });


    $(document).on("click","#load_review_btn",function(){
        let page = $(this).data('page');
        let gameId = $("#gameId").val();
        if(page == '' || gameId == '')
        {
            $("#msg").html("Enough data not available").show();
        }
        else
        {
            let obj = {page,gameId};
            let data = JSON.stringify(obj);
            $.ajax({
                url:"http://localhost/projects/GameOn/API/loadReviews.php",
                type:"POST",
                dataType:"JSON",
                data:data,
                success:function(data)
                {
                    if(data.flg == 1)
                    {
                        $("#load_review_btn").remove();
                        if(data.reviews.length > 0)
                        {
                            $.each(data.reviews,function(key,review){
                                $("#review_show_box").append(`
                                    <div class = 'review_card' id = 'review_${review.review_id}'>
                                        <div>
                                            <h3>${review.rating}</h3>
                                            <h4>${review.reviewText}</h4>
                                            <h5>By: ${review.username}</h5>
                                        </div>
                                    </div>
                                `);
                                let userId = $("#userId").val();
                                if(userId !== '')
                                {
                                    $("review_" + userId).append(`
                                        <div class = 'rvw_dlt_upd_div'>
                                            <button id = 'upd_btn' data-rvw_id = '${review.review_id}'>Update</button>
                                            <button id = 'dlt_btn' data-rvw_id = '${review.review_id}'>Delete</button>
                                        </div>
                                    `);
                                }
                            });
                            $("#game_full_box").append(`
                                <button id = 'load_review_btn' data-page = '${data.page}'>Load Reviews</button>
                            `);
                        }
                        else
                        {
                            $("#review_show_box").append(`
                                <div class = 'empty'>
                                    <h4>No More Reviews</h4>
                                </div>
                            `);
                        }
                        
                    }
                    else
                    {
                        $("#msg").html("Failed to Load Reviews").show();
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    });
});