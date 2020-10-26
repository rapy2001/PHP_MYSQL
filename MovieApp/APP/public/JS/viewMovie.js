$(document).ready(function(){
    $("#msg").hide();
    $("#rvw_msg").hide();
    let movieId = $("#movie_id").val();
    let userId = $("#user_id").val();
    let data = JSON.stringify({movieId});
    function loadMovieData()
    {
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
                    "</h3><h4>" + data.movie.genre_name + "</h4><p>" + data.movie.description +
                    "</div>"
                )
            }
        });
    }
    loadMovieData();
    function loadReviews(page_num)
    {
        let obj = {movieId,page_num};
        let data = JSON.stringify(obj);
        $.ajax({
            url:"http://localhost/projects/MovieApp/API/getReviews.php",
            type:"POST",
            dataType:"JSON",
            data:data,
            beforesend:function(){
                $("#rvw_msg").html("Loading ...").show();
            },
            success:function(data){
                if(data.flg == 1)
                {
                    $("#rvw_ld_mr_btn").remove();
                    $.each(data.reviews,function(key, review){
                        if(userId == review.user_id)
                        {
                            $("#reviews_div").append(
                                "<div id=" + review.review_id + ">" + 
                                "<h3>" + review.rating + "</h3>" +
                                "<h2>" + review.username + "</h2>" +
                                "<p>" + review.reviewText + "</p>" +
                                "<button id = 'review_delete_btn' data-rvw_id=" + review.review_id + ">" +
                                "Delete</button>" + 
                                "<button id = 'review_update_btn' data-rvw_id=" + review.review_id + ">" +
                                "Update</button></div>");
                        }
                        else
                        {
                            $("#reviews_div").append(
                                "<div id=" + review.review_id + ">" + 
                                "<h3>" + review.rating + "</h3>" +
                                "<h2>" + review.username + "</h2>" +
                                "<p>" + review.reviewText + "</p>" +
                                "</div>");
                        }
                        
                    });
                    $("#reviews_div").append("<button id = 'rvw_ld_mr_btn' data-page_num = " + data.page_num + ">Load More</button>");
                }
                else if(data.flg == -1)
                {
                    $("#rvw_msg").html("Enough data not provided").show();
                }
                else if(data.flg == -2)
                {
                    $("#rvw_ld_mr_btn").remove();
                    $("#reviews_div").append("<h4 id = 'empty' >No reviews</h4>");
                }
            }
        });
        setTimeout(function(){
            $("#msg").html("").hide();
            $("#rvw_msg").html("").hide();
        },2500);
    }
    loadReviews(1);
    function checkReviewStatus()
    {
        let obj = {movieId,userId};
        let data = JSON.stringify(obj);
        $.ajax({
            url:"http://localhost/projects/MovieApp/API/checkReviewStatus.php",
            type:"POST",
            dataType:"JSON",
            data:data,
            beforesend:function(){
                $("#msg").html("Loading ..").show();
            },
            success:function(data){
                // console.log(data);
                if(data.flg == 1)
                {
                    $("#add_review_btn").hide();
                }
                else if(data.flg == 0)
                {
                    $("#add_review_btn").show();
                }
                
            }
        });
    }
    checkReviewStatus();
    $(document).on("click","#rvw_ld_mr_btn",function(){
        let page_num = $(this).data("page_num");
        loadReviews(page_num);
    });
    $("#review_form_div").hide();
    $("#add_review_btn").on("click",function(){
        $("#review_form_div").show();
    });
    $("#add_review_form").on("submit",function(e){
        e.preventDefault();
        let reviewText = $("#reviewText").val();
        let rating = $("#rating").val();
        if(reviewText == '' || rating == '')
        {
            $("#msg").html("All fields are neccessary").show();
        }
        else
        {
            let userId = $("#user_id").val();
            let obj = {reviewText,rating,userId,movieId};
            let data = JSON.stringify(obj);
            $.ajax({
                url:"http://localhost/projects/MovieApp/API/addReview.php",
                type:"POST",
                dataType:"JSON",
                data:data,
                beforesend:function(){
                    $("#msg").html("Loading ..").show();
                },
                success:function(data){
                    // console.log(data);
                    if(data.flg == 1)
                    {
                        $("#msg").html("Review added successfully").show();
                        // $("#empty").remove();
                        // $("#reviews_div").append(
                        //     "<div>" + 
                        //     "<h3>" + data.review.rating + "</h3>" +
                        //     "<h2>" + data.review.username + "</h2>" +
                        //     "<p>" + data.review.reviewText + "</p>" +
                        //     "</div>");
                        $("#review_form_div").hide();
                        checkReviewStatus();
                        loadMovieData();
                        loadReviews();
                    }
                    else if(data.flg == -1)
                    {
                        $("#msg").html("All fileds are required").show();
                    }
                    else if(data.flg == -2)
                    {
                        $("#msg").html("Internal server Error").show();
                    }
                    else if(data.flg == -3)
                    {
                        $("#msg").html("Review could not be loaded").show();
                    }
                    else if(data.flg == -4)
                    {
                        $("#msg").html("You have already added an Review").show();
                        $("#review_form_div").hide();
                    }
                    else if(data.flg == -5)
                    {
                        $("#msg").html("Server Error").show();
                    }
                }
            });
        }
        setTimeout(function(){
            $("#msg").html("").hide();
            $("#rvw_msg").html("").hide();
        },2500);
    });
    $(document).on("click","#review_delete_btn",function(){
        let reviewId = $(this).data("rvw_id");
        let movieId = $("#movie_id").val();
        let obj = {reviewId,movieId};
        let data = JSON.stringify(obj);
        $.ajax({
            url:"http://localhost/projects/MovieApp/API/deleteReview.php",
            type:"POST",
            dataType:"JSON",
            data:data,
            beforesend:function(){
                $("#msg").html("Loading ..").show();
            },
            success:function(data){
                console.log(data);
                if(data.flg == 1)
                {
                    let slc = "#" + reviewId;
                    $(slc).remove();
                    loadMovieData();
                    checkReviewStatus();
                }
                else if(data.flg == -2)
                {
                    $("#msg").html("Error while deleting the Review").show();
                }
                else if(data.flg == -1)
                {
                    $("#msg").html("Enough data was not provided").show();
                }
                else if(data.flg == -3)
                {
                    $("#msg").html("Internal Server Error").show();
                }
            }
        });
        setTimeout(function(){
            $("#msg").html("").hide();
            $("#rvw_msg").html("").hide();
        },2500);
        
    });
    $("#update_review_form_div").hide();
        $(document).on("click","#review_update_btn",function(){
            let reviewId = $(this).data("rvw_id");
            let obj = {reviewId};
            let data = JSON.stringify(obj);
            console.log(data);
            $.ajax({
                url:"http://localhost/projects/MovieApp/API/getReview.php",
                type:"POST",
                dataType:"JSON",
                data:data,
                beforesend:function(){
                    $("#msg").html("Loading ..").show();
                },
                success:function(data){
                    console.log(data);
                    if(data.flg == 1)
                    {
                        $("#update_review_form_div").show();
                        $("#upd_rvw_hid").remove();
                        $("#update_review_form").append("<input id = 'upd_rvw_hid' type = 'hidden' value = '" + reviewId + "' />");
                        $("#update_reviewText").val(data.review.reviewText);
                        $("#update_rating").val(data.review.rating);
                    }
                    else if(data.flg == -1)
                    {
                        $("#upd_msg").html("Enough data not provided").show();
                        $("#update_review_form").hide();
                    }
                    else if(data.flg == -2)
                    {
                        $("#upd_msg").html("Could not get the data").show();
                        $("#update_review_form").hide();
                    }
                }
            });
            setTimeout(function(){
                $("#upd_msg").html("").hide();
            },2500);
        });

        $("#update_review_form").on("submit",function(e){
            e.preventDefault();
            let reviewText = $("#update_reviewText").val();
            let rating = $("#update_rating").val();
            let reviewId = $("#upd_rvw_hid").val();
            let obj = {reviewText,rating,reviewId,movieId};
            let data = JSON.stringify(obj);
            console.log(data);
            if(reviewText == '' || rating == '')
            {
                $("#upd_msg").html("All fields are neccessary").show();
            }
            else
            {
                $.ajax({
                    url:"http://localhost/projects/MovieApp/API/updateReview.php",
                    type:"POST",
                    dataType:"JSON",
                    data:data,
                    beforesend:function(){
                        $("#upd_msg").html("Loading ...").show();
                    },
                    success:function(data){
                        console.log(data);
                        if(data.flg == 1)
                        {
                            $("#update_review_form_div").hide();
                            $("#upd_msg").html("Review Updated").show();
                            let selec = "#" + $("#upd_rvw_hid").val();
                            $(selec).html("<h3>" + data.review.rating + "</h3>" +
                            "<h2>" + data.review.username + "</h2>" +
                            "<p>" + data.review.reviewText + "</p>" +
                            "<button id = 'review_delete_btn' data-rvw_id=" + data.review.review_id + ">" +
                            "Delete</button>" + 
                            "<button id = 'review_update_btn' data-rvw_id=" + data.review.review_id + ">" +
                            "Update</button>");
                            loadMovieData();
                        }
                        else if(data.flg == -1)
                        {
                            $("#upd_msg").html("Enough data not provided").show();
                        }
                        else if(data.flg == -2)
                        {
                            $("#upd_msg").html("Review could not be Updated").show();
                        }
                        else if(data.flg == -3)
                        {
                            $("#upd_msg").html("Could not get Review").show();
                        }
                    }
                });
            }
            setTimeout(function(){
                $("#upd_msg").html("").hide();
            },2500);
        });
});