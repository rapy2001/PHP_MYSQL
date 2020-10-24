$(document).ready(function(){
    $("#msg").hide();
    let movieId = $("#movie_id").val();
    let data = JSON.stringify({movieId});
    $.ajax({
        url:"http://localhost/projects/MovieApp/API/getMovie.php",
        type:"POST",
        data:data,
        dataType:"JSON",
        beforesend:function(){
            $("#msg").html("Loading ...").show();
        },
        success:function(data){
            // console.log(data);
            let imageUrl = data.movie.imageUrl == "NO IMAGE" ? 'https://cdn.dribbble.com/users/730703/screenshots/13974652/media/27c7ba4aecea898d0a8260d2e59f4d85.jpg' : data.movie.imageUrl;
            $("#movie_div").html(
                "<div><img src = '" + imageUrl + "' alt = 'error'/></div>" +
                "<div><h1>" + data.movie.name + "</h1>" +
                "<h3>year:" + data.movie.year +
                "</h3><h4>rating:" + data.movie.rating +
                "</h4><h3>director:" + data.movie.director +  
                "</h3><p>" + data.movie.description +
                "</div>"
            )
        }
    });
    setTimeout(function(){
        $("#msg").html("").hide();
    },2500);
});