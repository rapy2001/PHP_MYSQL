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
        fetch('http://localhost/projects/CartDemo/API/getProducts.php')
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
                            $(`#product_${product.product_id}`).append(`
                                <div class = 'product_btn_box'>
                                    <button class = 'btn'>
                                        Add to Cart
                                    </button>
                                </div>
                               
                            `)
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
})