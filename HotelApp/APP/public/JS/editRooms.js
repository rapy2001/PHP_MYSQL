$(document).ready(() => {
    $("#msg").text('').hide();

    const showMessage = (text) => {
        $("#msg").text(text).show();
    }

    const hideMessage = () => {
        setTimeout(() => {
            $("#msg").text('').hide();
        },2500);
    }

    $("#edit_room_extra_form").hide();
    const fetchRooms = () =>
    {
        fetch('http://localhost/projects/HotelApp/API/getRooms.php')
        .then((response) => response.json())
        .then((data) => {
            
            if(data.flg === 1)
            {
                $("#table_body").html('')
                if(data.rooms.length > 0)
                {
                    let rooms = data.rooms;
                    for(let i = 0; i<rooms.length; i++)
                    {
                        $("#table_body").append(`
                            <tr>
                                <td>${rooms[i].name}</td>
                                <td>${rooms[i].description.substr(0,50)} ...</td>
                                <td>${rooms[i].price}</td>
                                <td>${rooms[i].size}</td>
                                <td>${rooms[i].pets_allowed}</td>
                                <td>${rooms[i].free_snacks}</td>
                                <td id = 'extraBtn' data-id = '${rooms[i].room_id}'>Add Extra</td>
                            </tr>
                        `);
                    }
                    
                }
                else
                {
                    $("#table_body").append('<tr>No Rooms</tr>');
                }
            }
        })
        .catch((err) => {
            showMessage('Internal Serve Error');
            hideMessage();
        })
    }
    fetchRooms();

    $(document).on('click','#extraBtn',(e) => {
        $("#edit_room_extra_form").show();
        $("#roomId").val(e.target.dataset.id);
    })

    $('#cut').on('click',() => {
        $("#edit_room_extra_form").hide();
    })

    $('#extra_form').on('submit',(e) => {
        e.preventDefault();
        let feature = $("#extra_feature").val();
        let roomId = $("#roomId").val();
        if(feature == '')
        {
            showMessage('Please Enter an Extra Feature');
            hideMessage();
        }
        else
        {
            fetch('http://localhost/projects/HotelApp/API/addFeature.php',{
                method:'POST',
                body:JSON.stringify({feature,roomId})
            })
            .then((response) => response.json())
            .then((data) => {
                if(data.flg === 1)
                {
                    showMessage('Feature Added');
                    hideMessage();
                    $('#edit_room_extra_form').trigger('reset');
                    $("#edit_room_extra_form").hide();
                }
                else
                {
                    showMessage('Internal Server Error');
                    hideMessage();
                }
            })
            .catch((err) => {
                showMessage('No Response from the Server');
                hideMessage();
            })
        }
    })
})