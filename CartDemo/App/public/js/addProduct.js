$(document).ready(() => {
    $("#msg").text('').hide();
    const hideMessage = () => {
        setTimeout(() => {
            $("#msg").text('').hide();
        },2500)
    }
    const showMessage = (text) => {
        $("#msg").text(text).show();
    }

    $("#add_product_form").on('submit',(e) => {
        e.preventDefault();
        // console.log($("#add_product_form"));
        let name = $('#name').val();
        let price = $('#price').val();
        let quantity = $('#quantity').val();
        let image = $('#image').val();
        if(name == '' || price == '' || quantity == '')
        {
            showMessage('Name, Price or Quantity fields can not be empty');
            hideMessage();
        }
        else if(price <= 0)
        {
            showMessage('Price can not be Negative or Zero');
            hideMessage();
        }
        else if(quantity <= 0)
        {
            showMessage('Quatity can not be Zero or Negative');
        }
        else
        {
            fetch('http://localhost/projects/CartDemo/API/addProduct.php',{
                method:'POST',
                body:JSON.stringify({name,price,quantity,image})
            })
            .then((response) => response.json())
            .then((data) => {
                if(data.flg == 1)
                {
                    showMessage('Product added');
                    hideMessage();
                    $("#add_product_form").trigger('reset');
                    setTimeout(() => {
                        window.location.assign('./homepage.php');
                    },3000)
                }
                else
                {
                    showMessage('Internal Server Error');
                    hideMessage();
                }
            })
            .catch((err) => {
                showMessage(err.message);
                hideMessage();
            })
        }
    })
})