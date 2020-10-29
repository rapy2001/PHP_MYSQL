$(document).ready(function(){
    $("#msg").hide();
    function loadTrips(page_num)
    {
        let obj = {page_num};
        let data = JSON.stringify(obj);
        $.ajax({
            url:"http://localhost/projects/TripsApp/API/getTrips.php",
            type:"POST",
            data:data,
            beforesend:function(){
                $("#msg").html("Loading ...").show();
            },
            success:function(data){
                console.log(data);
                if(data.flg == 1)
                {
                    
                    if(data.trips.length > 0)
                    {
                        $.each(data.trips,function(key,trip){
                            $("#viewTrips_div").append("<div>" +
                                "<div id = 'trip_card' data-id = '" + trip.trip_id + "'>" +
                                    "<img src = '" + trip.trip_image + "' alt = 'error'/>" +
                                "</div>" +
                                "<div>" +
                                    "<div>" +
                                        "<h3>" + trip.trip_name + "</h3>" +
                                        "<h4>" +trip.trip_price+ "</h4>" +
                                    "</div>" +
                                    "<div>" +
                                        "<p>" + trip.trip_description +"</p>" +
                                    "</div>" +
                                    "<div>" +
                                        "<button id = 'not_btn' data-id = '" + trip.trip_id + "'>Not Interested</button>" +
                                    "</div>" +
                                "</div>" +
                            "</div>");
                        });
                        $("#viewTrips_div").append("<button id = 'loadMore_btn' data-page_num = '" + data.pageNum + "'>Load More</button>")
                    }
                    else
                    {
                        $("#loadMore_btn").remove();
                        $("#viewTrips_div").append("<h4>No More Trips</h4>");
                    }
                }
            }
        });
    }
    loadTrips(1);
    $(document).on("click","#loadMore_btn",function(){
        // alert("hello");
        let num = $(this).data("page_num");
        loadTrips(num);
    });
});