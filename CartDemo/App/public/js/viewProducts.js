$(document).ready(() => {
    $("#msg").text('').hide();
    let isLoggedIn = false;
    let userId = $("#userId").val();
    isLoggedIn = (userId === '') ? false : true;
    const hideMessage = () => {
        setTimeout(() => {
            $("#msg").text('').hide();
        },2500)
    }
    const showMessage = (text) => {
        $("#msg").text(text).show();
    }
    const fetchProducts = () => {
        fetch(`http://localhost/projects/CartDemo/API/getProducts.php?userId=${userId}`)
        .then((response) => response.json())
        .then((data) => {
            if(data.flg === 1)
            {
                
                if(data.products.length > 0)
                {
                    $("#viewProducts_box").html('');
                    for(let i = 0; i<data.products.length; i++)
                    {
                        let product = data.products[i];
                        // console.log(product);
                        $("#viewProducts_box").append(`
                            <div class = 'product' id = 'product_${product.product_id}'>
                                <div class = 'product_img_box'>
                                    <img src = ${product.image} alt = ${product.name}/>
                                </div>
                                <h2>${product.name}</h2>
                                <div class = 'price_quantity'>
                                    <h4>Rs. ${product.price}</h4>
                                    <h4>Available: ${product.quantity}</h4>
                                </div>
                            </div>
                        `)
                        if(isLoggedIn)
                        {
                            if(product['status'] === 0)
                            {
                                if(product['quantity'] > 0)
                                {
                                    $(`#product_${product.product_id}`).append(`
                                    <div class = 'product_btn_box'>
                                        <button id = 'add_cart_${product.product_id}' data-id = ${product.product_id} class = 'btn'>
                                            Add to Cart
                                        </button>
                                    </div>
                                `)
                                }
                            }
                            else
                            {
                                $(`#product_${product.product_id}`).append(`
                                    <h4 class = 'added'>Added to Cart</h4>
                                `);
                            }
                        }
                    }
                }
            }
            else
            {
                showMessage('Error while loading the Products');
                hideMessage();
            }
        })
    }
    fetchProducts();

    $(document).on("click",'.btn',(e) => {
        let productId = e.target.dataset.id;
        let obj = JSON.stringify({userId,productId});
        // console.log(productId);
        
        fetch("http://localhost/projects/CartDemo/API/insertCart.php",{
            method:'POST',
            body:obj
        })
        .then((response) => response.json())
        .then((data) => {
            if(data.flg === 1)
            {
                showMessage('Item added to Cart Successfully');
                hideMessage();
                // $(`#add_cart_${productId}`).remove();
                // $(`#product_${productId}`).append(`
                //     <button class = 'btn'>Added to Cart</button>
                // `);
                fetchProducts();
            }
            else if(data.flg === 2)
            {
                showMessage('Max Amount reached');
                hideMessage();
            }
            else
            {
                showMessage('Internal Server Error');
                hideMessage();
            }
        })
        .catch((err) => {
            showMessage('No Response from the Server');
            hideMessage();
        })
    })
})