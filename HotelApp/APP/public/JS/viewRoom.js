$(document).ready(() => {
    $('#msg').text('').hide();
    const showMessage = (text) => {
        $('#msg').text(text).show();
    }
    const hideMessage = () => {
        $('#msg').text('').hide();
    }

    const fetchRoom = () => {
        let roomId = $('#roomId').val();
        fetch('http://localhost/projects/HotelApp/API/getRoom.php',{
            method:'POST',
            body:JSON.stringify({roomId})
        })
        .then((response) => response.json())
        .then((data) => {
            if(data.flg === 1)
            {
                $('#container').append(`
                    <div>
                        <div>
                            <img src = '${data.room.primary_image}' alt = '${data.room.name}'/>
                        </div>
                        <h2>${data.room.name}</h2>
                    </div>
                    <div>
                        <img src = '${data.room.image_1}' alt = '${data.room.name}'/>
                        <img src = '${data.room.image_2}' alt = '${data.room.name}'/>
                        <img src = '${data.room.image_3}' alt = '${data.room.name}'/>
                    </div>
                    <div>
                        <div>
                            <p>
                                ${data.room.description}
                            </p>
                        </div>
                        <div>
                            <h4>$ ${data.room.price}</h4>
                            <h4>${data.room.size} SQ FOOT</h4>
                            <h4>${data.room.pets_allowed == 1 ? 'Yes' : 'No'}</h4>
                            <h4>${data.room.free_snacks == 1 ? 'Yes' : 'No'}</h4>
                            <h4>${data.room.type === 1 ? 'Family' : data.room.type === 2 ? 'Single' : 'Two'}</h4>
                            <h4>Guests: ${data.room.guests}</h4>
                        </div>
                        <div id = 'extras'></div>
                    </div>
                `);

               if(data.extras.length > 0)
               {
                   for(let i = 0; i<data.extras.length; i++)
                   {
                       $('#extras').append(`<h4>${data.extras[i]}</h4>`);
                   }
               }
               else
               {
                   $('#extras').append('<h4>No Extras Provided</h4>');
               }
            }
            else
            {
                showMessage('Failed to Load Room Details');
                hideMessage();
            }
        })
        .catch((err) => {
            showMessage('No Response from the Server');
        })
    }
    fetchRoom();
});