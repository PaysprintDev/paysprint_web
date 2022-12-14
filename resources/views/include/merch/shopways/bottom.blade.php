    <!-- back to top start -->
    <a href="javascript:void(0)" class="scroll" id="top">
        <span><i class="fa fa-angle-double-up"></i></span>
    </a>
    <!-- back to top end -->



    <div class="mm-fullscreen-bg"></div>
    <!-- jquery -->


    <script src="{{ asset('shopassets/js/modernizr-2.8.3.min.js') }}"></script>
    <script src="{{ asset('shopassets/js/jquery-3.6.0.min.js') }}"></script>
    <!-- bootstrap -->
    <script src="{{ asset('shopassets/js/bootstrap.min.js') }}"></script>
    <!-- popper -->
    <script src="{{ asset('shopassets/js/popper.min.js') }}"></script>
    <!-- fontawesome -->
    <script src="{{ asset('shopassets/js/fontawesome.min.js') }}"></script>
    <!-- owl carousal -->
    <script src="{{ asset('shopassets/js/owl.carousel.min.js') }}"></script>
    <!-- swiper -->
    <script src="{{ asset('shopassets/js/swiper.min.js') }}"></script>
    <!-- custom -->
    <script src="{{ asset('shopassets/js/custom.js') }}"></script>

    <script src="{{ asset('js/country-state-select.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"
        integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"
        integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script language="javascript">
        populateCountries("country", "state");
    </script>


    @guest

        <script>
            async function addCart(productId, userId) {

                messageAlert('failed', 'Oops', 'You have to login first');

            }
            async function addWishlist(productId, userId) {

                messageAlert('failed', 'Oops', 'You have to login first');

            }
        </script>

    @endguest


    @auth



        <script>
            const baseUrl = "{{ route('home') }}/api/v1/shop";
            let config, route, data;
            const headers = {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            };



            async function addCart(productId, userId) {

                try {



                    $('.modalspinner' + productId).removeClass('disp-0');
                    $('.carty' + productId).addClass('disp-0');

                    data = new FormData();

                    data.append('productId', productId);
                    data.append('userId', userId);
                    data.append('quantity', $('#quantity' + productId).val());



                    headers.Authorization = "Bearer {{ Auth::user()->api_token }}"

                    route = `${baseUrl}/product/addtocart`;


                    config = {
                        method: 'post',
                        headers: headers,
                        url: route,
                        data: data
                    };


                    const response = await axios(config);

                    $('.modalspinner' + productId).addClass('disp-0');
                    $('.carty' + productId).removeClass('disp-0');



                    await loadCart(userId);

                    messageAlert('success', `${response.statusText}`, `${response.data.message}`);


                } catch (error) {

                    $('.modalspinner' + productId).addClass('disp-0');
                    $('.carty' + productId).removeClass('disp-0');

                    if (error.response) {

                        messageAlert('failed', `${error.response.statusText}`, `${error.response.data.message}`);

                    } else {

                        messageAlert('failed', 'Oops', `${error.message}`);


                    }

                }

            }
            async function addWishlist(productId, userId) {

                try {

                    $('.modalspinner' + productId).removeClass('disp-0');
                    $('.wishes' + productId).addClass('disp-0');

                    data = new FormData();

                    data.append('productId', productId);
                    data.append('userId', userId);

                    headers.Authorization = "Bearer {{ Auth::user()->api_token }}"

                    route = `${baseUrl}/product/addtowishlist`;


                    config = {
                        method: 'post',
                        headers: headers,
                        url: route,
                        data: data
                    };


                    const response = await axios(config);

                    $('.modalspinner' + productId).addClass('disp-0');
                    $('.wishes' + productId).removeClass('disp-0');


                    var wishCount = Number($('#wish-total').text()) + 1;

                    $('#wish-total').text(wishCount);


                    messageAlert('success', `${response.statusText}`, `${response.data.message}`);

                } catch (error) {

                    $('.modalspinner' + productId).addClass('disp-0');
                    $('.wishes' + productId).removeClass('disp-0');

                    if (error.response) {

                        messageAlert('failed', `${error.response.statusText}`, `${error.response.data.message}`);

                    } else {

                        messageAlert('failed', 'Oops', `${error.message}`);


                    }

                }




            }



            // Load Cart Information
            async function loadCart(userId) {

                try {

                    $('#cartRec').html('');

                    data = new FormData();

                    data.append('userId', userId);

                    headers.Authorization = "Bearer {{ Auth::user()->api_token }}"

                    route = `${baseUrl}/product/loadmycart?userId=${userId}`;


                    config = {
                        method: 'get',
                        headers: headers,
                        url: route,
                        data: data
                    };

                    const response = await axios(config);


                    console.log(response);

                    var cartNo = response.data.data.length;

                    $('#cart-total').text(cartNo);

                    var totalCost = 0;
                    var itemResult = "";
                    var subInfo = "";

                    if (cartNo > 0) {
                        for (let i = 0; i < response.data.data.length; i++) {
                            const element = response.data.data[i];

                            itemResult += `
                        <li class="cart-item">
                            <div class="cart-img">
                               <a href="javascript:void(0)">
                                   <img src="${element.productImage}" alt="cart-image" class="img-fluid">
                               </a>
                           </div>

                           <div class="cart-title">
                               <h6><a href="javascript:void(0)">${element.productName}</a></h6>
                               <div class="cart-pro-info">
                                   <div class="cart-qty-price">
                                       <span class="quantity">${element.quantity} x </span>
                                       <span
                                           class="price-box"> ${response.data.merchant.currencySymbol+''+element.price.toLocaleString()}</span>
                                       <hr>
                                       <span
                                           class="price-box"> ${response.data.merchant.currencySymbol+''+Number(element.price * element.quantity).toLocaleString()}</span>
                                   </div>
                                   <div class="delete-item-cart">
                                       <a href="javascript:void(0)" onclick="deleteFromCart('${element.id}')"><i
                                               class="icon-trash icons"></i></a>
                                   </div>
                               </div>
                           </div>


                        </li>
                        `;


                            totalCost += Number(element.price * element.quantity);

                        }

                        subInfo = `<li class="subtotal-info">
                   <div class="subtotal-titles">
                       <h6>Sub total:</h6>
                       <span
                           class="subtotal-price"> ${response.data.merchant.currencySymbol+''+totalCost.toLocaleString()}</span>
                   </div>
               </li>
               <li class="mini-cart-btns">
                   <div class="cart-btns">

                       <a href="/product/checkout?store=${response.data.merchant.businessname}"
                           class="btn btn-style1">Checkout</a>
                   </div>
               </li>`;
                    } else {
                        itemResult = `<li class="cart-item">
                       <h4 class="text-center">No item in cart</h4>
                   </li>`;

                        subInfo = ``;

                    }

                    // <a href="/product/cart?store=${response.data.merchant.businessname}"
                    //        class="btn btn-style1">View cart</a>



                    $('#cartRec').html(`
                        <a href="javascript:void(0)" class="shopping-cart-close"><i class="ion-close-round"></i></a>
                        <div class="cart-item-title">
                            <p>
                                <span class="cart-count-desc">There are</span>
                                <span class="cart-count-item bigcounter">${cartNo}</span>
                                <span class="cart-count-desc">Products</span>
                            </p>
                        </div>

                        <ul class="cart-item-loop">${itemResult}</ul>

                        <ul class="subtotal-title-area">
               ${subInfo}
           </ul>

                    `);


                } catch (error) {

                    if (error.response) {

                        messageAlert('failed', `${error.response.statusText}`, `${error.response.data.message}`);

                    } else {

                        messageAlert('failed', 'Oops', `${error.message}`);


                    }
                }
            }


            async function changeDeliveryOption(merchantId, currencySymbol) {


                try {
                    $('.storeDetails').addClass('disp-0');
                    $('.instoreAddress').html(``);
                    $('.amountToDeliveryAddress').html(``);
                    $('.shippingChargeClass').html(``);
                    // Check for merchant delivery rates from users selection
                    var userSelection = $('#deliveryOption').val();
                    var city = $('#city').val();
                    var state = $('#state').val();
                    var totalCost = $('#total').val();
                    route = `${baseUrl}/product/deliveryoption`;

                    headers.Authorization = "Bearer {{ Auth::user()->api_token }}"

                    data = new FormData();
                    data.append('merchantId', merchantId);
                    data.append('userSelection', userSelection);
                    data.append('city', city);
                    data.append('state', state);

                    config = {
                        method: 'post',
                        headers: headers,
                        url: route,
                        data: data
                    };


                    const response = await axios(config);
                    $('.storeDetails').removeClass('disp-0');

                    if (response.status === 200) {

                        if (response.data.message != 'No delivery options available') {
                            if (userSelection != "Home Delivery") {
                                $('.instoreAddress').html(
                                    `<h6 class='text-success'>Address: ${response.data.data.address}</h6>`);
                            }

                            $('.amountToDeliveryAddress').html(
                                `<h6 class='text-success'>Delivery Fee: ${currencySymbol+''+parseFloat(response.data.data.deliveryRate).toFixed(2)}</h6>`
                            );

                            $('.shippingChargeClass').html(
                                `<strong>${currencySymbol+''+parseFloat(response.data.data.deliveryRate).toFixed(2)}</strong>`
                            );

                            $('#shippingCharge').val(parseFloat(response.data.data.deliveryRate).toFixed(2));
                            $('.shippingChargeClass').addClass('text-info');


                            $('.totalCost').html(
                                `<strong>${currencySymbol+''+(Number(totalCost) + Number(response.data.data.deliveryRate)).toFixed(2)}</strong>`
                            );

                        } else {
                            $('.instoreAddress').html(`<h6 class='text-danger'>Note: ${response.data.message}</h6>`);
                            $('.amountToDeliveryAddress').html(``);
                            $('.shippingChargeClass').html(
                                `<strong>${currencySymbol+''+parseFloat(0).toFixed(2)}</strong>`);
                            $('#shippingCharge').val(parseFloat(0).toFixed(2));
                            $('.shippingChargeClass').addClass('text-danger');

                            $('.totalCost').html(`<strong>${currencySymbol+''+Number(totalCost).toFixed(2)}</strong>`);
                        }


                    } else {
                        $('.instoreAddress').html(``);
                        $('.amountToDeliveryAddress').html(
                            `<h6>Delivery Fee: ${currencySymbol+''+parseFloat(0).toFixed(2)}</h6>`);
                        $('.shippingChargeClass').html(`<strong>${currencySymbol+''+parseFloat(0).toFixed(2)}</strong>`);
                        $('#shippingCharge').val(parseFloat(0).toFixed(2));
                        $('.shippingChargeClass').addClass('text-danger');

                        $('.totalCost').html(`<strong>${currencySymbol+''+Number(totalCost).toFixed(2)}</strong>`);
                    }

                } catch (error) {
                    $('.storeDetails').addClass('disp-0');

                    if (error.response) {

                        messageAlert('failed', `${error.response.statusText}`, `${error.response.data.message}`);

                    } else {

                        messageAlert('failed', 'Oops', `${error.message}`);


                    }

                }






            }


            async function deleteFromCart(id) {
                try {

                    route = `${baseUrl}/product/removecartitem?id=${id}`;

                    headers.Authorization = "Bearer {{ Auth::user()->api_token }}";


                    config = {
                        method: 'post',
                        headers: headers,
                        url: route
                    };


                    const response = await axios(config);

                    await loadCart('{{ Auth::user()->id }}');


                } catch (error) {

                    if (error.response) {

                        messageAlert('failed', `${error.response.statusText}`, `${error.response.data.message}`);

                    } else {

                        messageAlert('failed', 'Oops', `${error.message}`);


                    }

                }
            }
        </script>
    @endauth


    <script>
        function deleteWishlist(id) {



            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this item!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#deletewish' + id).submit();
                    }
                });


        }




        function messageAlert(theme, title, message) {

            if (theme === "failed") return iziToast.error({
                title,
                message,
                position: 'topRight' // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter

            });


            return iziToast.success({
                title,
                message,
                position: 'topRight' // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter

            });


        }

        $('#shipping_check').change(() => {

            if ($('#shipping_check').prop('checked') == true) {
                $('.shippingInfo').addClass('disp-0');
            } else {
                $('.shippingInfo').removeClass('disp-0');
            }
        })
    </script>







    </body>

    <!-- Mirrored from spacingtech.com/html/vegist-final/vegist/index5.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 07 Mar 2022 13:17:49 GMT -->

    </html>
