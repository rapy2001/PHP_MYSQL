$(document).ready(() => {
    $('#msg').text('').hide();
    $('#review_box').hide();
    const showMessage = (text) => {
        $('#msg').text(text).show();
    }
    const hideMessage = () => {
        $('#msg').text('').hide();
    }
    const userId = parseInt($('#userId').val());
    const roomId = parseInt($('#roomId').val());
    const fetchRoom = async () => {
        
        await fetch('http://localhost/projects/HotelApp/API/getRoom.php',{
            method:'POST',
            body:JSON.stringify({roomId})
        })
        .then((response) => response.json())
        .then((data) => {
            if(data.flg === 1)
            {
                 $('#container').append(`
                    <div id = 'roomContainer'>
                        <img src = '${data.room.primary_image}' alt = '${data.room.name}'/>
                        <div>
                            <h2>${data.room.name}</h2>
                        </div>
                    </div>
                    <div class = 'imagesBox'>
                        <img src = '${data.room.image_1}' alt = '${data.room.name}'/>
                        <img src = '${data.room.image_2}' alt = '${data.room.name}'/>
                        <img src = '${data.room.image_3}' alt = '${data.room.name}'/>
                    </div>
                    <div class = 'des_ext'>
                        <div>
                            <h2>Description</h2>
                            <p>
                                ${data.room.description}
                            </p>
                        </div>
                        <div>
                            <h2>About</h2>
                            <h4>Price: <b>$ ${data.room.price}</b></h4>
                            <h4>Size: <b>${data.room.size} SQ FOOT</b></h4>
                            <h4>Pets Allowed: <b>${data.room.pets_allowed == 1 ? 'Yes' : 'No'}</b></h4>
                            <h4>Free Snacks: <b>${data.room.free_snacks == 1 ? 'Yes' : 'No'}</b></h4>
                            <h4>Room Type: <b>${data.room.type === 1 ? 'Family' : data.room.type === 2 ? 'Single' : 'Two'}</b></h4>
                            <h4>Guests: <b>${data.room.guests}</b></h4>
                        </div>
                    </div>
                    <div id = 'extras'></div>
                    <div id = 'reviews'>
                        <div id = 'reviewsBox'></div>
                    </div>   
                `);

               if(data.extras.length > 0)
               {
                   for(let i = 0; i<data.extras.length; i++)
                   {
                       $('#extras').append(`<h4>${data.extras[i]}</h4>`);
                   }
               }
               else
               {
                   $('#extras').append('<h4>No Extras Provided</h4>');
               }
               console.log(userId != -1);
               if(userId != -1)
               {
                   $('#reviews').append(`
                        <button id = 'addReviewBtn'>Add Review</button>
                   `)

               }
            }
            else
            {
                showMessage('Failed to Load Room Details');
                hideMessage();
            }
        })
        .catch((err) => {
            showMessage('No Response from the Server');
        })
    }
    
    let page = 1;
    let flg = 0;
    const fetchReviews = () => {
        fetch(`http://localhost/projects/HotelApp/API/getReviews.php?id=${roomId}`,{
            method:'POST',
            body:JSON.stringify({roomId,page})
        })
        .then((res) => res.json())
        .then((data) => {
            if(page == 1)
                $('#reviewsBox').html('');
            if(data.flg == 1)
            {
                // console.log('hello');
                if(data.reviews.length > 0)
                {
                    if(page == 1)
                    {
                        $('#ratingDiv').remove();
                        $('#reviewsBox').append(`
                            <div id = 'ratingDiv'>
                                <h2>${data.rating}</h2>
                            </div>
                        `);
                    }
                    flg = 1;
                    for(let i = 0; i<data.reviews.length; i++)
                    {
                        $('#reviewsBox').append(`
                            <div id = 'singleReview_${data.reviews[i].review_id}'>
                                <div>
                                    <img src = '${data.reviews[i].username}'/>
                                </div>
                                <div>
                                    <h3>${data.reviews[i].rating}</h3>
                                    <p>
                                        ${data.reviews[i].review}
                                    </p>
                                </div>
                            </div>
                        `)
                        if(data.reviews[i].user_id == userId)
                        {
                            $(`#singleReview_${data.reviews[i].review_id}`).append(`
                                <div>
                                    <button id = 'dlt' data-id = '${data.reviews[i].review_id}'>Delete</button>
                                    <button id = 'upd' data-id = '${data.reviews[i].review_id}'>Update</button>
                                </div>
                            `)
                        }
                    }
                    page += 1;
                    $('#ld_mr').remove();
                    $('#reviewsBox').append(`
                        <button id = 'ld_mr'>Load More</button>
                    `)

                }
                else
                {
                    $('#ld_mr').remove();
                    if(flg == 0)
                        $('#reviewsBox').append(`
                            <div>
                                <h4>No Reviews Yet</h4>
                            </div>
                        `)
                    else
                        $('#reviewsBox').append(`
                            <div>
                                <h4>No more Reviews</h4>
                            </div>
                        `)
                }
            }
            else
            {
                $('#reviewsBox').append(`
                        <div>
                            <h4>No Reviews Yet</h4>
                        </div>
                `)
                showMessage('Failed to load Reviews');
                hideMessage();
            }
        })
        .catch((err) => {
            $('#reviewsBox').html('');
            $('#reviewBox').append(`
                        <div>
                            <h4>No Reviews Yet</h4>
                        </div>
                `)
            showMessage('No Response from the Server');
            hideMessage();
        })
    }

    const loadData = async () => {
        await fetchRoom();
        fetchReviews();
    }

    loadData();
    $(document).on('click','#ld_mr',(e) => {
        fetchReviews();
    })
    
    $('#cut').on('click', () => {
        $('#review_box').hide();
    })
    $(document).on('click','#addReviewBtn',() => {
        $('#review_box').show();
    })
    $('#reviewForm').on('submit',(e) => {
        e.preventDefault();
        let review = $('#review').val();
        let rating = $('#rating').val();
        if(review == '')
        {
            showMessage('Please enter a Review');
            hideMessage();
        }
        else if(rating < 0)
        {
            showMessage('The rating can\'t be less than 0');
            hideMessage();
        }
        else
        {
            fetch('http://localhost/projects/HotelApp/API/addReview.php',{
                method:'POST',
                body:JSON.stringify({review,rating,userId,roomId})
            })
            .then((res) => res.json())
            .then((data) => {
                if(data.flg == 1)
                {
                    $('#reviewForm').trigger('reset');
                    showMessage('Review Added');
                    hideMessage();
                    $('#review_box').hide();
                    page = 1;
                    fetchReviews();
                }
                else
                {
                    showMessage('Internal Server Error. Please try again');
                }
            })
            .catch((err) => {
                showMessage('No Response from the Server. Please try again');
                hideMessage();
            })
        }
    })
    $(document).on('click','#dlt',(e) => {
        if(confirm('Are you sure ? '))
        {
            let reviewId = e.target.dataset.id;
            // let userId = parseInt($('#userId').val());
            fetch('http://localhost/projects/HotelApp/API/deleteReview.php',{
                method:'POST',
                body:JSON.stringify({reviewId,userId})
            })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                if(data.flg == 1)
                {
                    showMessage('Review Deleted Successfully');
                    hideMessage();
                    page = 1;
                    fetchReviews();
                }
                else if(data.flg == 2)
                {
                    showMessage('You are not authorized to delete this Review');
                    hideMessage();
                }
                else
                {
                    showMessage('Internal Server Error. Please try again later');
                    hideMessage();
                }
            })
            .catch((err) => {
                showMessage('No Response from the Server. Please try again later');
                hideMessage();
            })
        }
    })
    
    $(document).on('click','#upd',(e) => {
        let reviewId = e.target.dataset.id;
    })
});

