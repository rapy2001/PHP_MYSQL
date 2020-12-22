$(document).ready(() => {
    $("#msg").text("").hide();
    const showMessage = (text) => {
        $("#msg").text(text).show();
    }
    const hideMessage = () => {
        setTimeout(function(){
            $("#msg").text("").hide();
        },2500)
    }
    $("#login_form").on("submit",function(e){
        e.preventDefault();
        let username = $("#username").val();
        let password = $("#password").val();
        if(username == "" || password == "")
        {
            showMessage("All fields are Necessary");
            hideMessage();
        }
        else
        {
            let data = JSON.stringify({username,password});
            fetch("http://localhost/projects/CartDemo/API/login.php",{
                method:"POST",
                body:data
            })
            .then((response) => response.json())
            .then((data) => {
                if(data.flg === 1)
                {
                    showMessage("Logged In Successfully");
                    hideMessage();
                    $("#login_form").trigger("reset");
                    setTimeout(() => {
                        window.location.assign(`./setUser.php?username=${data.user.username}&userId=${data.user.user_id}`);
                    }, 2600);
                }
                else if(data.flg === 2)
                {
                    showMessage("Password is Wrong");
                    hideMessage();
                    $("#password").val("");
                }
                else if(data.flg === 3)
                {
                    showMessage("Username does not exists. Please Register");
                    $("#login_form").trigger("reset");
                    hideMessage();
                    $("#password").val("");
                    setTimeout(function(){
                        window.location.assign("./register.php");
                    },3000)
                }
                else
                {
                    showMessage("Internal Server Error");
                    hideMessage();
                }
            })
            .catch(function(err) {
                showMessage("No Response from the Server");
                hideMessage();
            })
        }
    })
})