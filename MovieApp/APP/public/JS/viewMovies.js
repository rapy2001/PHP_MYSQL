$(document).ready(function(){
    $("#msg").hide();
    function loadMovies(page_num){
        let data = JSON.stringify({page_num});
        $.ajax({
            url:"http://localhost/projects/MovieApp/API/getAllMovies.php",
            type:"POST",
            data:data,
            dataType:"JSON",
            beforesend:function(){
                $("#msg").html("Loading ....").show();
            },
            success:function(data){
                // console.log(data);
                if(data.flg == 1)
                {
                    let pageNum = $("#load_more_btn").data("page_num");
                    $("#load_more_btn").remove();
                    $.each(data.movies,function(key,movie){
                        let imageUrl = movie.imageUrl == "NO IMAGE" ? 'https://cdn.dribbble.com/users/730703/screenshots/13974652/media/27c7ba4aecea898d0a8260d2e59f4d85.jpg':movie.imageUrl;
                        $("#movies_div")
                        .append('<div class = "movie_card"><img src = "' + imageUrl + '" alt = "error" /><h4>Release: ' + movie.year + '</h4><h3>' + movie.rating + '<i class = "fa fa-star"></i></h3><h2>' + movie.name + '</h2><h4>' + movie.genre_name + '</h4><h3>' + movie.director +'</h3><p>'+ movie.description.substring(0,50) + '</p><a class = "btn" href = "viewMovie.php?id=' + movie.movie_id + '">View</a></div>');
                    });
                    $("#movies_div").append("<button class = 'btn' id = 'load_more_btn' data-page_num = " + data['pageNum'] + ">Load More</button>");
                }
                else if(data.flg == -2)
                {
                    $("#load_more_btn").remove();
                    $("#movies_div").append("<div class = 'empty'><h4>No Movies Available</h4></div>");
                }
                else if(data.flg == -1)
                {
                    $("#msg").html("No data Provided").show();
                }
            }
        });
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    }
    loadMovies(1);
    $(document).on("click","#load_more_btn",function(){
        let pageNum = $(this).data("page_num");
        loadMovies(pageNum);
    });
});