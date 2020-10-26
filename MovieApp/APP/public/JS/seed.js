$(document).ready(function(){
    $("#seed").on("click",function(){
        $("body").append("<h4 id = 'seed_msg'></h4>");
        $("#seed_msg").hide();
        $.ajax({
            url:"http://localhost/projects/MovieApp/API/seed.php",
            type:"POST",
            dataType:"JSON",
            success:function(data){
                if(data.flg == 1)
                {
                    $("#seed_msg").html("Database seeded Successfully").show();
                }
                else if(data.flg == -1)
                {
                    $("#seed_msg").html("Error while deleting the users").show();
                }
                else if(data.flg == -2)
                {
                    $("#seed_msg").html("Error while deleting the reviews").show();
                }
                else if(data.flg == -3)
                {
                    $("#seed_msg").html("Error while deleting the movies").show();
                }
            }
        });
        setTimeout(function(){
            $("#seed_msg").hide();
        },2500);
    });
    
});

$("#brgr").on("click",function(){
    $(".nav_box_2").addClass("slide");
});

$(".nav_cut").on("click",function(){
    $(".nav_box_2").removeClass("slide");
});