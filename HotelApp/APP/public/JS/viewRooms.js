$(document).ready(() => {
    $("#msg").text('').hide();

    const showMessage = (text) => {
        $("#msg").text(text).show();
    }

    const hideMessage = () => {
        setTimeout(() => {
            $("#msg").text('').hide();
        },2500)
        
    }

    const addRooms = (rooms) => {
        $("#rooms").html('');
        if(rooms.length > 0)
        {
            
            for(let i = 0; i<rooms.length; i++)
                {
                    // console.log(rooms);
                    $("#rooms").append(`
                        <div class = 'singleRoom'>
                            <h4>${rooms[i].price}</h4>
                            <div class = 'room_img_div'>
                                <img src = '${rooms[i].image_1}' alt = '${rooms[i].name}'/>
                            </div>
                            <div class = 'room_title_div'>
                               <h2>${rooms[i].name}</h2>
                            </div>
                        </div>
                    `);
                }
        }
        else
        {
            $("#rooms").append(`
                <div class = 'empty'>
                    <h4>No Rooms</h4>
                </div>
            `);
        }
    }
    const fetchRooms = () => {
        fetch('http://localhost/projects/HotelApp/API/getRooms.php')
        .then((response) => response.json())
        .then((data) => {
            if(data.flg === 1)
            {
                // $("#rooms").html('');
                // for(let i = 0; i<data.rooms.length; i++)
                // {
                //     $("#rooms").append(`
                //         <div class = 'singleRoom'>
                //             <h4>${data.rooms[i].price}</h4>
                //             <div class = 'room_img_div'>
                //                 <img src = '${data.rooms[i].image_1}' alt = '${data.rooms[i].name}'/>
                //             </div>
                //             <div class = 'room_title_div'>
                //                <h2>${data.rooms[i].name}</h2>
                //             </div>
                //         </div>
                //     `);
                // }
                addRooms(data.rooms);
            }
            else
            {
                console.log(data);
                showMessage('Internal Server Error');
                hideMessage();
            }
        })
        .catch((err) => {
            showMessage('No Response from the Server');
            hideMessage();
        })
    }

    fetchRooms();

    $("#search_form").on('submit',(e) => {
        e.preventDefault();
        let price = $("#price").val();
        let size = $("#size").val();
        let pets = document.querySelector('#pets').checked ? 1 : -1;
        let snacks = document.querySelector('#snacks').checked ? 1 : -1;
        let type = $("#type").val();
        let guests = $("#guests").val();
        
       
        if(price == '' || size == '')
        {
            console.log('hell');
            showMessage('Plese Enter price and size');
            hideMessage();
        }
        else
        {
            console.log('hell');
            if(type == 0)
                type = 1;
            if(guests == 0)
                guests = 1;
            let obj = JSON.stringify({price,size,pets,snacks,type,guests});
            console.log(obj);
            fetch('http://localhost/projects/HotelApp/API/searchRoom.php',{
                method:'POST',
                body:obj
            })
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                
                if(data.flg === 1)
                {
                    addRooms(data.rooms);
                }
                else
                {
                    
                    showMessage('Error while searching');
                    hideMessage();
                }
            })
            .catch((err) => {
                console.log(err.message);
                showMessage('No Response from the Server');
                hideMessage();
            })
        }
    })
})