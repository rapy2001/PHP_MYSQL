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

    $('#login_form').on('submit',(e) => {
        e.preventDefault();
        let username = $('#username').val();
        let password = $('#password').val();

        if(username == '' || password == '')
            showMessage('Username or Password can not be empty');
        else
        {
            fetch('http://localhost/projects/HotelApp/API/checkLogin.php',{
                method:'POST',
                body:JSON.stringify({username,password})
            })
            .then((response) => response.json())
            .then((data) => {
                try
                {
                    if(data.flg == 1)
                    {
                        // console.log(data);
                        showMessage('Login Successful');
                        hideMessage();
                        $('#register_form').trigger('reset');
                        window.location.assign(`./setLogin.php?username=${data.user.username}&userId=${data.user.user_id}`);
                    }
                    else if(data.flg == 2)
                    {
                        showMessage('Username does not  exists');
                        hideMessage();
                        $('#username').val('');
                    }
                    else if(data.flg == 3)
                    {
                        showMessage('Password is Wrong');
                        hideMessage();
                        $('#password').val('');
                    }
                    else
                    {
                        showMessage('Internal Server Error');
                        hideMessage();
                    }
                }
                catch(error)
                {
                    showMessage('JS Error');
                    hideMessage();
                }
                
            })
            .catch((err) => {
                showMessage('Failed to Log In. No Response from the Server');
                hideMessage();
            })
        }
    })
})