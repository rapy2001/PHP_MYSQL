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
                        <div>
                            <img src = '${data.room.primary_image}' alt = '${data.room.name}'/>
                        </div>
                        <h2>${data.room.name}</h2>
                    </div>
                    <div>
                        <img src = '${data.room.image_1}' alt = '${data.room.name}'/>
                        <img src = '${data.room.image_2}' alt = '${data.room.name}'/>
                        <img src = '${data.room.image_3}' alt = '${data.room.name}'/>
                    </div>
                    <div>
                        <div>
                            <p>
                                ${data.room.description}
                            </p>
                        </div>
                        <div>
                            <h4>$ ${data.room.price}</h4>
                            <h4>${data.room.size} SQ FOOT</h4>
                            <h4>${data.room.pets_allowed == 1 ? 'Yes' : 'No'}</h4>
                            <h4>${data.room.free_snacks == 1 ? 'Yes' : 'No'}</h4>
                            <h4>${data.room.type === 1 ? 'Family' : data.room.type === 2 ? 'Single' : 'Two'}</h4>
                            <h4>Guests: ${data.room.guests}</h4>
                        </div>
                        <div id = 'extras'></div>
                        <div id = 'reviews'>
                            <div id = 'reviewsBox'></div>
                        </div>
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
            // $('#reviewsBox').html('');
            if(data.flg == 1)
            {
                console.log('hello');
                if(data.reviews.length > 0)
                {
                    flg = 1;
                    for(let i = 0; i<data.reviews.length; i++)
                    {
                        $('#reviewsBox').append(`
                            <div>
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
});