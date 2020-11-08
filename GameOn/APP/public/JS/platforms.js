$(document).ready(function(){
    $("#msg").hide();
    $("#update_platform_div").hide();
    function loadPlatforms()
    {
        $("#platforms_div").html("");
        $.ajax({
            url:"http://localhost/projects/GameOn/API/getPlatforms.php",
            type:"POST",
            dataType:"JSON",
            success:function(data)
            {
                // console.log(data);
                if(data.flg == 1)
                {
                    if(data.platforms.length > 0)
                    {
                        $.each(data.platforms,function(key,platform){
                            $("#platforms_div").append(`
                                <div id = 'platform_${platform.platform_id}'>
                                    <h4>${platform.platform_name}</h4>
                                    <div>
                                        <button id = 'upd_btn' data-platform_id = '${platform.platform_id}'>Update</button>
                                        <button id = 'dlt_btn' data-platform_id = '${platform.platform_id}'>Delete</button>
                                    </div>
                                </div>
                            `);
                        });
                    }
                    else
                    {
                        $("#platforms_div").append(`
                            <div class = 'empty'>
                                <h4>No Platforms yet ...</h4>
                            </div>
                        `);
                    }
                }
                else
                {
                    $("#msg").html("Failed to Load the Platforms").show();
                }
            }
        });
        setTimeout(function(){
            $("#msg").html('').hide();
        },2500);
    }
    loadPlatforms();

    $(document).on("click","#dlt_btn",function(){
        if(confirm("The Platform will be removed. Proceed ?"))
        {
            let platformId = $(this).data('platform_id');

            if(platformId == '')
            {
                $("#msg").html("Enough data not provided").show();
            }
            else
            {
                let obj = {platformId};
                let data = JSON.stringify(obj);

                $.ajax({
                    url:"http://localhost/projects/GameOn/API/deletePlatform.php",
                    data:data,
                    dataType:"JSON",
                    type:"POST",
                    success:function(data)
                    {
                        if(data.flg == 1)
                        {
                            $("#msg").html("The Platform was removed successfully").show();
                            $("#platform_" + platformId).remove();
                            if($("#platforms_div").children().length == 0)
                            {
                                $("#platforms_div").append(`
                                    <div class = 'empty'>
                                        <h4>No Platforms yet</h4>
                                    </div>
                                `);
                            }

                        }
                        else
                        {
                            $("#msg").html("Error while deleteing the platform").show();
                        }
                    }
                });
            }
            setTimeout(function(){
                $("#msg").html("").hide();
            },2500);
        }
    });


    //handle add Platform form

    $("#add_platform_form").on("submit",function(e){
        e.preventDefault();

        let platformText = $("#platformText").val();

        if(platformText == '')
        {
            $("#msg").html("No Platform provided").show();
        }
        else
        {
            let obj = {platformText};
            let data = JSON.stringify(obj);
            $.ajax({
                url:"http://localhost/projects/GameOn/API/addPlatform.php",
                type:"POST",
                data:data,
                dataType:"JSON",
                success:function(data)
                {
                    if(data.flg == 1)
                    {
                        $("#add_platform_form").trigger("reset");
                        $("#msg").html("The Platform was added successfully").show();
                        loadPlatforms();
                    }
                    else if(data.flg == 2)
                    {
                        $("#msg").html("The Platform already exists. Please try a different platform").show();
                        $("#add_paltform_form").trigger("reset");
                    }
                    else
                    {
                        $("#msg").html("Internal Server Error");
                    }
                }
            });
            
        }
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    });

    //function to load Platforms

    function loadPlatform(platformId)
    {
        let obj = {platformId};
        let data = JSON.stringify(obj);
        $.ajax({
            url:"http://localhost/projects/GameOn/API/getPlatform.php",
            data:data,
            dataType:"JSON",
            type:"POST",
            success:function(data)
            {
                if(data.flg == 1)
                {
                    $("#updatedPlatformText").val(data.platform.platform_name);
                    $("#hiddenPlatformId").val(data.platform.platform_id);
                }
                else
                {
                    $("#msg").html("Failed to load Platform").show();
                    $("#update_platform_div").hide();
                }
            }
        })
        setTimeout(function(){
            $("#msg").html("").hide();
        },2500);
    }

    //show Update Div

    $(document).on("click","#upd_btn",function(){
        $("#update_platform_div").show();
        $("#add_platform_div").hide();
        let platformId = $(this).data("platform_id");
        loadPlatform(platformId);
    });

    //Handle Update Form

    $("#update_platform_form").on("submit",function(e){
        e.preventDefault();
        let updatedPlatformText = $("#updatedPlatformText").val();
        let platformId = $("#hiddenPlatformId").val();
        if(updatedPlatformText == '')
        {
            $("#msg").html("No new Value was Provided").show();
        }
        else
        {
            let obj = {updatedPlatformText,platformId};
            let data = JSON.stringify(obj);

            $.ajax({
                url:"http://localhost/projects/GameOn/API/updatePlatform.php",
                data:data,
                dataType:"JSON",
                type:"POST",
                success:function(data)
                {
                    // console.log(data);
                    if(data.flg == 1)
                    {
                        $("#update_platform_form").trigger("reset");
                        $("#add_platform_div").show();
                        $("#update_platform_div").hide();
                        $("#msg").html("Platform Updated successfully").show();
                        loadPlatforms();
                    }
                    else if(data.flg == 2)
                    {
                        $("#msg").html("The platform already exists. Please try a different platform").show();
                        $("#update_platform_form").trigger("reset");
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

    $("#cancel_update").on("click",function(){
        $("#update_platform_form").trigger("reset");
        $("#update_platform_div").hide();
        $("#add_platform_div").show();
    });
});