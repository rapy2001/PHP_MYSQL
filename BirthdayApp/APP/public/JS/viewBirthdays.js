$(document).ready(function(){
    $("#msg").hide();
    function loadBirthdays(num)
    {
        let userId = $("#userId").val();
        let obj = {userId,num};
        let data = JSON.stringify(obj);
        $.ajax({
            url:"http://localhost/projects/BirthdayApp/API/getBirthdays.php",
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
                    $("#loadMoreBtn").remove();
                    $.each(data.birthdays,function(key,birthday){
                        $("#birthdays_div").append(
                            "<div class = 'birthday_card'>" + "<div class = 'birthday_card_1'><img src = '" 
                            + birthday['imageUrl'] + "' alt = 'error' /></div>" +
                            "<div class = 'birthday_card_2'>" + "<h2>" + birthday['person_name'] + "</h2><h4>Age: " + birthday['age'] +"</h4></div>" 
                            + "</div>"
                        );
                    });
                    $("#birthdays_div").append("<button id = 'loadMoreBtn' data-num = '" + data.pageNum + "'>Load More</button>")
                }
                else if(data.flg == -2)
                {
                    $("#loadMoreBtn").remove();
                    $("#birthdays_div").append("<h4>No More Birthdays for Today</h4>");
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
    
});