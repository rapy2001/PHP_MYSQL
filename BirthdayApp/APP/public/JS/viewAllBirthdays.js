$(document).ready(function(){
    $("#msg").hide();
    function loadBirthdays(num)
    {
        let userId = $("#userId").val();
        let obj = {userId,num};
        let data = JSON.stringify(obj);
        $.ajax({
            url:"http://localhost/projects/BirthdayApp/API/getAllBirthdays.php",
            type:"POST",
            dataType:"JSON",
            data:data,
            beforesend:function(){
                $("#msg").html("Loading ...").show();
            },
            success:function(data){
                console.log(data);
                if(data.flg == 1)
                {
                    $("#userData").append("<div class = 'user_card'><img src = '" + data.userData['imageUrl'] + "' alt = 'error'/>" + 
                    "<div><h1>" + data.userData['username'] +  "</div>" +
                    "</div>");
                    $("#loadMoreBtn").remove();
                    $.each(data.birthdays,function(key,birthday){
                        $("#birthdays_div").append(
                            "<div class = 'birthday_card viewAll' id = '" + birthday['birthday_id'] +"'>" + "<div class = 'birthday_card_1'><img src = '" 
                            + birthday['imageUrl'] + "' alt = 'error' /><h1>" + birthday['person_name'] + "</h1><h4>Age:" + birthday['age'] + " </h4></div>" +
                            "<div class = 'birthday_card_2'><button id = 'delete_btn' data-id = " + birthday['birthday_id']+">Delete</button>" + "</div>" +
                            "</div>"
                        );
                    });
                    $("#birthdays_div").append("<button id = 'loadMoreBtn' data-num = '" + data.pageNum + "'>Load More</button>")
                }
                else if(data.flg == -2)
                {
                    $("#userData").html("<div class = 'user_card'><img src = '" + data.userData['imageUrl'] + "' alt = 'error'/>" + 
                    "<div><h1>" + data.userData['username'] +  "</div>" +
                    "</div>");
                    $("#loadMoreBtn").remove();
                    $("#birthdays_div").append("<h4>No More Birthdays</h4>");
                }
            }
        });
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    }
    loadBirthdays(1);
    $(document).on("click","#loadMoreBtn",function(){
        let num = $(this).data("num");
        loadBirthdays(num);
    });
    $(document).on("click","#delete_btn",function(){
        if(confirm("Are you sure you want to delete this Birthday ?"));
        let id = $(this).data('id');
        let obj = {id};
        let data = JSON.stringify(obj);
        $.ajax({
            url:"http://localhost/projects/BirthdayApp/API/deleteBirthday.php",
            dataType:"JSON",
            data:data,
            type:"POST",
            beforesend:function(){
                $("#msg").html("Loading ...").show();
            },
            success:function(data){
                console.log(data);
                if(data.flg == 1)
                {
                    $("#" + id).remove();
                    $("#msg").html("Birthday removed successfully").show();
                    $("#birthdays_div").html("<h1>All Birthdays</h1>");
                    loadBirthdays(1);
                }
                else if(data.flg == -1)
                {
                    $("#msg").html("Enough data not provided").show();
                }
                else if(data.flg == -2)
                {
                    $("#msg").html("Internal Server Error").show();
                }
            }
        });
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    });
});