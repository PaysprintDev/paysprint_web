@extends('layouts.merch.merchant-shop')

@section('content')
    <!-- breadcrumb start -->
    <section class="about-breadcrumb" style="margin-top: 150px;">
        <div class="about-back section-tb-padding"
            style="background-image: url({{ asset('shopassets/image/about-image.jpg') }})">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="about-l">
                            <ul class="about-link">
                                <li class="go-home"><a href="{{ url()->previous() }}">Home</a></li>
                                <li class="about-p"><span>Your checkout</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end -->
    <!-- checkout page start -->
    <section class="section-tb-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <form action="{{ route('place order') }}" method="post">
                        @csrf
                        <div class="checkout-area">
                            <div class="billing-area">
                                <h2>Billing details</h2>
                                <div class="billing-form">
                                    <ul class="billing-ul input-2">
                                        <li class="billing-li">
                                            <label>Full name</label>
                                            <input type="text" name="name" class="form-control" placeholder="Full name"
                                                value="{{ Auth::user()->name }}">
                                            <input type="hidden" name="userId" value="{{ Auth::id() }}">
                                            <input type="hidden" name="merchantId" value="{{ $data['user']->id }}">
                                        </li>

                                    </ul>
                                    <ul class="billing-ul mt-3">
                                        <li class="billing-li">
                                            <label>Company name (Optional)</label>
                                            <input type="text" name="company" class="form-control"
                                                placeholder="Company name" value="">
                                        </li>
                                    </ul>
                                    <ul class="billing-ul mt-3">
                                        <li class="billing-li">
                                            <label>Country</label>
                                            <select name="country" id="country" class="form-control form-select countries"
                                                required></select>
                                        </li>
                                    </ul>
                                    <ul class="billing-ul mt-3">
                                        <li class="billing-li">
                                            <label for="state">Province/State</label>
                                            <select name="state" id="state" class="form-control form-select"
                                                required></select>
                                        </li>
                                    </ul>
                                    <ul class="billing-ul mt-3">
                                        <li class="billing-li">
                                            <label>Street address</label>
                                            <input type="text" name="address" class="form-control"
                                                placeholder="Street address" required>
                                        </li>
                                    </ul>
                                    <ul class="billing-ul mt-3">
                                        <li class="billing-li">
                                            <label>Apartment,suite,unit etc. (Optional)</label>
                                            <input type="text" name="apartment" class="form-control" placeholder="">
                                        </li>
                                    </ul>

                                    <ul class="billing-ul mt-3">
                                        <li class="billing-li">
                                            <label>Town / City</label>
                                            <input type="text" name="city" id="city" class="form-control" placeholder=""
                                                required>
                                        </li>
                                    </ul>

                                    <ul class="billing-ul mt-3">
                                        <li class="billing-li">
                                            <label>Postcode / ZIP</label>
                                            <input type="text" name="postalCode" class="form-control" placeholder=""
                                                required>
                                        </li>
                                    </ul>
                                    <ul class="billing-ul input-2 mt-3">
                                        <li class="billing-li">
                                            <label>Email address</label>
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Email address" value="{{ Auth::user()->email }}" required>
                                        </li>
                                        <li class="billing-li mt-3">
                                            <label>Phone</label>
                                            <input type="text" name="phone" class="form-control" placeholder="Phone"
                                                value="{{ Auth::user()->telephone }}" required>
                                        </li>
                                    </ul>

                                    <br>

                                    <ul class="billing-ul input-2 mt-3">
                                        <li class="billing-li">
                                            <label><strong>Shipping Region</strong></label>
                                        </li>

                                    </ul>


                                    <br>

                                    <div>
                                        <h2>Delivery Option</h2>
                                        <ul class="billing-ul input-2 mt-3">
                                            <li class="billing-li">
                                                <select name="deliveryOption" id="deliveryOption"
                                                    class="form-control form-select" required
                                                    onChange="changeDeliveryOption('{{ $data['user']->id }}', '{{ $data['user']->currencySymbol }}')">
                                                    <option value="">Select delivery option</option>
                                                    <option value="Home Delivery">Home Delivery</option>
                                                    <option value="In Store Pick Up">In Store Pick Up</option>
                                                </select>
                                            </li>


                                            <br>
                                            <div class="card storeDetails disp-0">
                                                <div class="card-body">
                                                    <p class="instoreAddress">

                                                    </p>
                                                    <br>
                                                    <p class="amountToDeliveryAddress">

                                                    </p>
                                                </div>
                                            </div>

                                        </ul>



                                        </ul>


                                    </div>

                                    <br>

                                    <ul class="billing-ul input-2 mt-3">
                                        <li class="billing-li">
                                            <label><strong>Add Shipping Details</strong></label>
                                            <hr><br>
                                            <input type="checkbox" name="shipping_check" id="shipping_check"> Same as
                                            billing details
                                        </li>

                                    </ul>

                                    <br>

                                    <div class="shippingInfo">
                                        <h2>Shipping details</h2>
                                        <ul class="billing-ul input-2 mt-3">
                                            <li class="billing-li">
                                                <label>Full name</label>
                                                <input type="text" name="shippingName" class="form-control"
                                                    placeholder="Full name">
                                            </li>

                                        </ul>
                                        <ul class="billing-ul input-2 mt-3">
                                            <li class="billing-li">
                                                <label>Address</label>
                                                <input type="text" name="shippingAddress" class="form-control"
                                                    placeholder="Address">
                                            </li>

                                        </ul>

                                        <ul class="billing-ul input-2 mt-3">
                                            <li class="billing-li">
                                                <label>Email address</label>
                                                <input type="email" name="shippingEmail" class="form-control"
                                                    placeholder="Email address">
                                            </li>

                                        </ul>
                                        <ul class="billing-ul input-2 mt-3">
                                            <li class="billing-li">
                                                <label>Phone Number</label>
                                                <input type="text" name="shippingPhone" class="form-control"
                                                    placeholder="Phone Number">
                                            </li>

                                        </ul>
                                    </div>





                                    <br>

                                </div>

                            </div>

                            <br>
                        </div>
                </div>
                <div class="col-md-4 order-area card">
                    <div class="check-pro">
                        <h2>In your cart ({{ count($data['mycartlist']) }})</h2>
                        <ul class="check-ul">

                            @php

                                $totalPrice = 0;

                            @endphp

                            @if (count($data['mycartlist']) > 0)
                                @foreach ($data['mycartlist'] as $cartItem)
                                    <li>
                                        <div class="check-pro-img">
                                            <center>
                                                <a href="javascript:void(0)"><img
                                                        style="border-radius: 10px; width: 100%; height: 200px; object-fit: contain; "
                                                        src="{{ $cartItem->productImage }}" class="img-fluid"
                                                        alt="image"></a>
                                            </center>
                                        </div>
                                        <div class="check-content">
                                            <p>Item: <a href="javascript:void(0)">{{ $cartItem->productName }}</a></p>
                                            <p class="check-code-blod">Quantity:
                                                <span>{{ $cartItem->quantity }}</span>
                                            </p>
                                            <span
                                                class="check-price">{{ $data['user']->currencySymbol . number_format($cartItem->price * $cartItem->quantity, 2) }}</span>
                                            <hr>
                                        </div>
                                    </li>

                                    @php $totalPrice += $cartItem->quantity * $cartItem->price; @endphp
                                @endforeach
                            @else
                                <li>No item in cart</li>
                            @endif


                        </ul>
                    </div>


                    @isset($data['storeTax'])
                        @php $totalTax = $totalPrice * $data['storeTax']->taxValue / 100; @endphp
                    @else
                        @php $totalTax = 0; @endphp
                    @endisset


                    <h2>Your order</h2>
                    <hr>
                    <ul class="order-history row">
                        <li class="order-details col-md-6 mb-2">
                            <span><strong>Product:</strong></span>
                        </li>
                        <li class="order-details col-md-6 mb-2">
                            <span><strong>Total</strong></span>
                        </li>
                        <hr>

                        @for ($i = 0; $i < count($data['mycartlist']); $i++)
                            <li class="order-details col-md-6 mb-2">
                                <span>{{ $data['mycartlist'][$i]->productName }}</span>
                            </li>
                            <li class="order-details col-md-6 mb-2">
                                <span>{{ $data['user']->currencySymbol . number_format($data['mycartlist'][$i]->price, 2) }}</span>
                            </li>
                        @endfor




                        <li class="order-details col-md-6 mt-2 mb-2">
                            <span>Subtotal:</span>
                        </li>
                        <li class="order-details col-md-6 mt-2 mb-2">
                            <input type="hidden" name="subtotal" value="{{ $totalPrice }}">
                            <span>{{ $data['user']->currencySymbol . number_format($totalPrice, 2) }}</span>
                        </li>

                        <li class="order-details col-md-6 mt-2 mb-2">
                            <span>Shipping Charge:</span>
                        </li>
                        <li class="order-details col-md-6 mt-2 mb-2">
                            <input type="hidden" name="shippingCharge" id="shippingCharge" value="">
                            <span class="shippingChargeClass"></span>
                        </li>

                        @isset($data['storeTax'])
                            <li class="order-details col-md-6 mt-2 mb-2">
                                <span>{{ $data['storeTax']->taxName }} (Tax):</span>
                            </li>
                            <li class="order-details col-md-6 mt-2 mb-2">
                                <span
                                    class="text-primary"><strong>{{ $data['user']->currencySymbol . number_format($totalTax, 2) }}</strong></span>
                            </li>
                        @else
                            <li class="order-details col-md-6 mt-2 mb-2">
                                <span>Tax:</span>
                            </li>
                            <li class="order-details col-md-6 mt-2 mb-2">
                                <span
                                    class="text-danger"><strong>{{ $data['user']->currencySymbol . number_format(0, 2) }}</strong></span>

                            </li>
                        @endisset


                        <li class="order-details col-md-6 mt-2 mb-2">
                            <span>Total:</span>
                        </li>
                        <li class="order-details col-md-6 mt-2 mb-2">
                            <input type="hidden" name="total" id="total" value="{{ $totalPrice + $totalTax }}">
                            <span
                                class="totalCost"><strong>{{ $data['user']->currencySymbol . number_format($totalPrice + $totalTax, 2) }}</strong></span>
                        </li>
                    </ul>

                    <div class="checkout-btn">

                        <button type="submit" class="btn-style1 form-control mt-3">Place order</button>
                    </div>
                </div>


            </div>

            </form>


        </div>
        </div>
        </div>
    </section>
    <!-- checkout page end -->
@endsection
