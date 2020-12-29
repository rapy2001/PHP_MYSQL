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

    $("#addRoom_form").on('submit',(e) => {
        e.preventDefault();

        let name = $("#name").val();
        let  primaryImage = $("#primaryImage").val();
        let image1 = $("#image1").val();
        let image2 = $("#image2").val();
        let image3 = $("#image3").val();
        let description = $("#description").val();
        let price = $("#price").val();
        let size = $("#size").val();
        let pets = document.querySelector('#pets').checked ? 1 : -1;
        let snacks = document.querySelector('#snacks').checked ? 1 : -1;
        let type = $("#type").val();
        let guests = $("#guests").val();
        // console.log(pets,snacks);
        if(name == '' || description == '')
        {
            showMessage('Name and Description can not be Empty');
            hideMessage();
        }
        else if(price <= 0)
        {
            showMessage('Price can\'t be Negative or Zero');
            hideMessage();
        }
        else if(size <= 0)
        {
            showMessage('Size can\'t be Negative or Zero');
            hideMessage();
        }
        else
        {
            fetch('http://localhost/projects/HotelApp/API/addRoom.php',{
                method:'POST',
                body:JSON.stringify({name,primaryImage,image1,image2,image3,description,price,size,pets,snacks,type,guests})
            })
            .then((response) => response.json())
            .then((data) => {
                // console.log(data);
                if(data.flg === 1)
                {
                    showMessage('Room Added');
                    hideMessage();
                    $("#addRoom_form").trigger('reset');
                    setTimeout(() => {
                        window.location.assign('./homepage.php');
                    },2800)
                }
                else
                {
                    showMessage('Internal Server Error. Please try again Later');
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