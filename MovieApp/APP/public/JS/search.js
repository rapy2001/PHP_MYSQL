$(document).ready(function(){
    $("#search_results").hide();
    $("#search").on("keyup",function(){
        let searchTerm = $(this).val();
        if(searchTerm == '')
        {
            $("#search_results").html("").hide();
        }
        else
        {
            let obj = {searchTerm};
            let data = JSON.stringify(obj);
            console.log(data);
            $.ajax({
                url:"http://localhost/projects/MovieApp/API/search.php",
                type:"POST",
                dataType:"JSON",
                data:data,
                beforesend:function()
                {
                    $("#search_results").show();
                    $("#msg").html("Loading ...");
                },
                success:function(data){
                    console.log(data);
                    $("#search_results").show();
                    if(data.flg == 1)
                    {
                        $("#msg").remove();
                        $("#search_results").html("");
                        $("#search_results").append("<h3>Results for ' " + searchTerm + " '</h3>");
                        $.each(data.movies,function(key,movie){
                            let imageUrl = movie.imageUrl == "NO IMAGE" ? 'https://cdn.dribbble.com/users/730703/screenshots/13974652/media/27c7ba4aecea898d0a8260d2e59f4d85.jpg':movie.imageUrl;
                            $("#search_results")
                            .append('<div><img src = "' + imageUrl + '" alt = "error" /><h4>' + movie.year + '</h4><h3>' + movie.rating + '</h3><h2>' + movie.name + '</h2><h4>' + movie.genre_name + '</h4><h3>' + movie.director +'</h3><p>'+ movie.description.substring(0,50) + '</p><a href = "viewMovie.php?id=' + movie.movie_id + '">View</a></div>');
                        });
                    }
                    else if(data.flg == -1)
                    {
                        $("#msg").html("Enough data not provided");
                    }
                    else if(data.flg == -2)
                    {
                        $("#msg").remove();
                        $("#search_results").append("<h3>No Results for ' " + searchTerm + " '</h3>");
                    }
                }
            });
        }
    });
});