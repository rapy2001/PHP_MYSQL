$(document).ready(function(){
    $("#msg").text('').hide();
    const showMessage = (text) => {
        $("#msg").text(text).show();
    }
    const hideMessage = () => {
        setTimeout(() => {
            $("#msg").text('').hide();
        },2500)
    }

    const fetchCart = () => {
        
    }
});

