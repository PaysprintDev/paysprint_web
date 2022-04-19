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
                <div class="col">

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
                                    <ul class="billing-ul">
                                        <li class="billing-li">
                                            <label>Company name (Optional)</label>
                                            <input type="text" name="company" class="form-control"
                                                placeholder="Company name" value="">
                                        </li>
                                    </ul>
                                    <ul class="billing-ul">
                                        <li class="billing-li">
                                            <label>Country</label>
                                            <select name="country" id="country" class="form-control form-select countries"
                                                required></select>
                                        </li>
                                    </ul>
                                    <ul class="billing-ul">
                                        <li class="billing-li">
                                            <label for="state">Province/State</label>
                                            <select name="state" id="state" class="form-control form-select"
                                                required></select>
                                        </li>
                                    </ul>
                                    <ul class="billing-ul">
                                        <li class="billing-li">
                                            <label>Street address</label>
                                            <input type="text" name="address" class="form-control"
                                                placeholder="Street address" required>
                                        </li>
                                    </ul>
                                    <ul class="billing-ul">
                                        <li class="billing-li">
                                            <label>Apartment,suite,unit etc. (Optional)</label>
                                            <input type="text" name="apartment" class="form-control" placeholder="">
                                        </li>
                                    </ul>

                                    <ul class="billing-ul">
                                        <li class="billing-li">
                                            <label>Town / City</label>
                                            <input type="text" name="city" class="form-control" placeholder="" required>
                                        </li>
                                    </ul>

                                    <ul class="billing-ul">
                                        <li class="billing-li">
                                            <label>Postcode / ZIP</label>
                                            <input type="text" name="postalCode" class="form-control" placeholder=""
                                                required>
                                        </li>
                                    </ul>
                                    <ul class="billing-ul input-2">
                                        <li class="billing-li">
                                            <label>Email address</label>
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Email address" value="{{ Auth::user()->email }}" required>
                                        </li>
                                        <li class="billing-li">
                                            <label>Phone</label>
                                            <input type="text" name="phone" class="form-control" placeholder="Phone"
                                                value="{{ Auth::user()->telephone }}" required>
                                        </li>
                                    </ul>
                                    <br>
                                    <ul class="billing-ul input-2">
                                        <li class="billing-li">
                                            <label>Add Shipping Details</label> <br>
                                            <input type="checkbox" name="shipping_check" id="shipping_check"> Same as
                                            billing details
                                        </li>

                                    </ul>

                                    <br>

                                    <div class="shippingInfo">
                                        <h2>Shipping details</h2>
                                        <ul class="billing-ul input-2">
                                            <li class="billing-li">
                                                <label>Full name</label>
                                                <input type="text" name="shippingName" class="form-control"
                                                    placeholder="Full name">
                                            </li>

                                        </ul>
                                        <ul class="billing-ul input-2">
                                            <li class="billing-li">
                                                <label>Address</label>
                                                <input type="text" name="shippingAddress" class="form-control"
                                                    placeholder="Address">
                                            </li>

                                        </ul>

                                        <ul class="billing-ul input-2">
                                            <li class="billing-li">
                                                <label>Email address</label>
                                                <input type="email" name="shippingEmail" class="form-control"
                                                    placeholder="Email address">
                                            </li>

                                        </ul>
                                        <ul class="billing-ul input-2">
                                            <li class="billing-li">
                                                <label>Phone Number</label>
                                                <input type="text" name="shippingPhone" class="form-control"
                                                    placeholder="Phone Number">
                                            </li>

                                        </ul>
                                    </div>

                                </div>

                            </div>

                            <br>

                            <div class="order-area">
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
                                                        <a href="javascript:void(0)"><img
                                                                src="{{ $cartItem->productImage }}" class="img-fluid"
                                                                alt="image"></a>
                                                    </div>
                                                    <div class="check-content">
                                                        <a href="javascript:void(0)">{{ $cartItem->productName }}</a>
                                                        <span class="check-code-blod">Quantity:
                                                            <span>{{ $cartItem->quantity }}</span></span>
                                                        <span
                                                            class="check-price">{{ $data['user']->currencySymbol . number_format($cartItem->price * $cartItem->quantity, 2) }}</span>
                                                    </div>
                                                </li>

                                                @php $totalPrice += $cartItem->quantity * $cartItem->price; @endphp
                                            @endforeach
                                        @else
                                            <li>No item in cart</li>
                                        @endif


                                    </ul>
                                </div>


                                <h2>Your order</h2>
                                <ul class="order-history">
                                    <li class="order-details">
                                        <span>Product:</span>
                                        <span>Total</span>
                                    </li>

                                    @for ($i = 0; $i < count($data['mycartlist']); $i++)
                                        <li class="order-details">
                                            <span>{{ $data['mycartlist'][$i]->productName }}</span>
                                            <span>{{ $data['user']->currencySymbol . number_format($data['mycartlist'][$i]->price, 2) }}</span>
                                        </li>
                                    @endfor




                                    <li class="order-details">
                                        <span>Subtotal:</span>
                                        <input type="hidden" name="subtotal" value="{{ $totalPrice }}">
                                        <span>{{ $data['user']->currencySymbol . number_format($totalPrice, 2) }}</span>
                                    </li>
                                    <li class="order-details">
                                        <span>Shipping Charge:</span>
                                        <input type="hidden" name="shippingCharge" value="0">
                                        <span>Free shipping</span>
                                    </li>
                                    <li class="order-details">
                                        <span>Total:</span>
                                        <input type="hidden" name="total" value="{{ $totalPrice }}">
                                        <span>{{ $data['user']->currencySymbol . number_format($totalPrice, 2) }}</span>
                                    </li>
                                </ul>

                                <div class="checkout-btn">

                                    <button type="submit" class="btn-style1">Place order</button>
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
