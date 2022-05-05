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
        </script>
    @endauth


    <script>
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
