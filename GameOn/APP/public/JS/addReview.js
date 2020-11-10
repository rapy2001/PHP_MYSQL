$(document).ready(function(){
    $("#msg").hide();
    let url = window.location.href;
    let obj = new URL(url);
    let gameId = obj.searchParams.get('gameId');
    // console.log(gameId);
    $("#add_review_form").on("submit",function(e){
        e.preventDefault();
        let reviewText = $("#reviewText").val();
        let userId = $("#userId").val();
        let rating = $("#rating").val();
        if(reviewText == '')
        {
            $("#msg").html("No Review Provided").show();
        }
        else if(gameId == '')
        {
            $("#msg").html("No Game chosen").show();
        }
        else if(userId == '')
        {
            $("#msg").html("Please Log In to add a Review").show();
        }
        else if(rating == '')
        {
            $("#msg").html("No Rating was provided").show();
        }
        else
        {
            let obj = {gameId,reviewText,userId,rating};
            let data = JSON.stringify(obj);
            $.ajax({
                url:"http://localhost/projects/GameOn/API/addReview.php",
                type:"POST",
                dataType:"JSON",
                data:data,
                success:function(data)
                {
                    if(data.flg == 1)
                    {
                        $("#msg").html("Review added successfully").show();
                        $("#add_review_form").trigger("reset");
                        setTimeout(function(){
                            window.location.assign("viewGames.php");
                        },3500)
                    }
                    else
                    {
                        $("#msg").html("Internal Server Error").show();
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    });
});