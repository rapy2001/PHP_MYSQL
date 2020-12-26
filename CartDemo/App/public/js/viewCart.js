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
    const userId = $("#userId").val();
    let total = 0;
    const insertItem = (userId,productId) => {
        fetch("http://localhost/projects/CartDemo/API/insertCart.php",{
            method:'POST',
            body:JSON.stringify({userId,productId})
        })
        .then((response) => {
            return response.json()
        })
        .then(data => {
            if(data.flg === 1)
            {
                fetchCart();
            }
            else if(data.flg === 2)
            {
                showMessage('Max value Reached');
                hideMessage();
            }
            else
            {
                showMessage('Internal Server Error While adding the item to the Cart');
                hideMessage();
            }
        })
        .catch((err) => {
            showMessage('No Response from the Server');
            hideMessage();
        })
    }
    const removeItem = (userId,productId) => {
        // console.log(productId);
        fetch("http://localhost/projects/CartDemo/API/removeItem.php",{
            method:'POST',
            body:JSON.stringify({userId,productId})
        })
        .then((response) => {
            return response.json()
        })
        .then(data => {
            if(data.flg === 1)
            {
                fetchCart();
            }
            else
            {
                showMessage('Internal Server Error While removing the item from  the Cart');
                hideMessage();
            }
        })
        .catch((err) => {
            showMessage('No Response from the Server');
            hideMessage();
        })
    }
    const fetchCart = () => {
        fetch("http://localhost/projects/CartDemo/API/getCart.php",{
            method:'POST',
            body:JSON.stringify({userId})
        })
        .then((response) => response.json())
        .then((data) => {
            if(data.flg === 1)
            {
                $("#cart").html('');
                if(data.products.length > 0)
                {
                    let products = data.products;
                    total = 0;
                    for(let i = 0; i<products.length; i++)
                    {
                        total += parseFloat(products[i].price) * parseFloat(products[i].count);
                        $("#cart").append(`
                            <div id = 'cart_item_${products[i].product_id}' class = 'cartItem'>
                                <div class = 'cart_img'>
                                    <img src = '${products[i].image}' alt = ${[products[i].name]}/>
                                </div>
                                <div class = 'content'>
                                    <h3>${products[i].name}</h3>
                                    <h4>Rs. ${products[i].price}</h4>
                                    <h4>Availabele: ${products[i].quantity}</h4>
                                </div>
                                <div class = 'buttons_div'>
                                    <button data-id = '${products[i].product_id}' class = 'plus_btn'><i class = 'fa fa-plus'></i></button>
                                    <h4>${products[i].count}</h4>
                                    <button data-id = '${products[i].product_id}' class = 'minus_btn'><i class = 'fa fa-minus'></i></button>
                                </div>
                            <div>
                        `);
                    }
                    $("#total").text(`Total: Rs. ${total}`);
                }
                else
                {
                    $("#cart").html(`
                        <div class = 'empty'>
                            <h4>Your Cart is Empty</h4>
                        </div>
                    `);
                }
            }
            else
            {
                showMessage('Internal Server Error');
                hideMessage();
            }
        })
        .catch((err) => {
            showMessage("No Response from the Server");
            hideMessage();
        })
    }

    $(document).on("click",".plus_btn",(e) => {
        let productId = e.currentTarget.dataset.id;
        // console.log(productId);
        insertItem(userId,productId);
    })
    $(document).on("click",".minus_btn",(e) => {
        let productId = e.currentTarget.dataset.id;
        // console.log(productId);
        removeItem(userId,productId);
    })

    fetchCart();
});

