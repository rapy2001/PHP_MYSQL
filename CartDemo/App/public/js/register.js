$(document).ready(function() {
    const time = () => {
        setTimeout(() => {
            $('#msg').text('').hide(); 
        },2500)
    }
    const showMessage = (msg) => {
        $('#msg').text(msg).show();
    }
    $("#msg").hide();
    $('#register_form').on('submit',(e) => {
        e.preventDefault();
        let username = $('#username').val();
        let password = $('#password').val();
        let image = $('#image').value;
        // console.log(username,password);
        if(username == '' || password == '')
        {
            showMessage('Username and Password can not be empty')
            time();
        }
        else
        {
            let data = {username,password,image:image};
            data = JSON.stringify(data);
            // console.log(data);
            fetch('http://localhost/projects/CartDemo/API/addUser.php',{
                method:'POST',
                body:data
            })
            .then((response) => response.json())
            .then((data) => {
                if(data.flg == 1)
                {
                    showMessage('Registration Successfull');
                    setTimeout(() => {
                        window.location.assign('./homepage.php');
                    },3000);
                }
                else if(data.flg === 2)
                {
                    showMessage('Username alredy exists. Please try a different User name');
                    time();
                }
            })
            .catch((err) => {
                showMessage('No Response from the Server');
            })
        }
    })
});