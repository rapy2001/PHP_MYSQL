$(document).ready(() => {
    $('#msg').text('').hide();
    const showMessage = (text) => {
        $('#msg').text(text).show();
    }
    const hideMessage = () => {
        setTimeout(() => {
            $('#msg').text('').hide();
        },2500)
    }

    $('#register_form').on('submit',(e) => {
        e.preventDefault();
        let username = $('#username').val();
        let password = $('#password').val();
        let image = $('#image').val();

        if(username == '' || password == '')
            showMessage('Username or Password can not be empty');
        else
        {
            fetch('http://localhost/projects/HotelApp/API/addUser.php',{
                method:'POST',
                body:JSON.stringify({username,password,image})
            })
            .then((response) => response.json())
            .then((data) => {
                if(data.flg == 1)
                {
                    showMessage('Registartion Successful');
                    hideMessage();
                    $('#register_form').trigger('reset');
                    setTimeout(() => {
                        window.location.assign('./homepage.php');
                    },2800)
                }
                else if(data.flg == 2)
                {
                    showMessage('Username Already exists. Please try a different username');
                    hideMessage();
                    $('#username').val('');
                }
                else
                {
                    showMessage('Internal Server Error');
                    hideMessage();
                }
            })
            .catch((err) => {
                showMessage('Failed to Register. No Response from the Server');
                hideMessage();
            })
        }
    })
})