$(document).ready(function(){
    $("#logout_msg").hide();
    $("#logout_btn").on("click",function(){
        $.ajax({
            url:"http://localhost/projects/BirthdayApp/API/logout.php",
            type:"POST",
            dataType:"JSON",
            success:function(data){
                console.log(data);
                if(data.flg == 1)
                {
                    $("#logout_msg").html("Log Out Successfull").show();
                    setTimeout(function(){
                        window.location.reload();
                    },3000);
                }
            }
        });
        setTimeout(function(){
            $("#logout_msg").hide(); 
        },2500);
    });
    $("#seed_btn").on("click",function(){
        $.ajax({
            url:"http://localhost/projects/BirthdayApp/API/seed.php",
            type:"GET",
            dataType:"JSON",
            success:function(data){
                if(data.flg == 1)
                {
                    $("#logout_msg").html("Database seeded successfully").show();
                }
            }
        });
        setTimeout(function(){
            $("#logout_msg").hide(); 
        },2500);
    });
});