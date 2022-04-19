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
                                <li class="about-p"><span>Your shopping cart</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end -->
    <!-- cart start -->
    <section class="cart-page section-tb-padding">
        <div class="container">
            <div class="row">

                <div class="cart-item">
                    <span class="cart-head">My cart:</span>
                    <span class="c-items">{{ count($data['mycartlist']) }} item</span>
                </div>

                <div class="col">

                    @php
                        
                        $totalPrice = 0;
                        
                    @endphp


                    @if (count($data['mycartlist']) > 0)
                        @foreach ($data['mycartlist'] as $cartItem)
                            <div class="cart-area">
                                <div class="cart-details">


                                    <div class="cart-all-pro">
                                        <div class="cart-pro">
                                            <div class="cart-pro-image">
                                                <a href="product.html"><img src="{{ $cartItem->productImage }}"
                                                        class="img-fluid" alt="image"></a>
                                            </div>
                                            <div class="pro-details">
                                                <h4><a href="javascript:void()">{{ $cartItem->productName }}</a></h4>
                                                <span class="pro-size"><span class="size">Quantity:</span>
                                                    {{ $cartItem->quantity }}</span>
                                                <span
                                                    class="cart-pro-price">{{ $data['user']->currencySymbol . number_format($cartItem->price, 2) }}</span>
                                            </div>
                                        </div>
                                        <div class="qty-item">
                                            <div class="center">
                                                <div class="plus-minus">
                                                    <span>
                                                        <a href="javascript:void(0)" class="minus-btn text-black">-</a>
                                                        <input type="text" name="name" value="{{ $cartItem->quantity }}">
                                                        <a href="javascript:void(0)" class="plus-btn text-black">+</a>
                                                    </span>
                                                </div>
                                                <a href="javascript:void(0)" class="pro-remove">Remove</a>
                                            </div>
                                        </div>
                                        <div class="all-pro-price">
                                            <span>{{ $data['user']->currencySymbol . number_format($cartItem->price * $cartItem->quantity, 2) }}</span>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            @php $totalPrice += $cartItem->quantity * $cartItem->price; @endphp
                        @endforeach
                    @else
                        <div class="cart-area">
                            <div class="cart-details">


                                <div class="cart-all-pro">

                                    <h4 class="text-center">No item on cart</h4>

                                </div>


                            </div>
                        </div>
                    @endif


                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="cart-style-3">
                        <h2 class="cart-main-title">Cart totals</h2>
                        <div class="c-total">
                            <ul>
                                <li class="c-all-price">
                                    <span>Subtotal</span>
                                    <span>{{ $data['user']->currencySymbol . number_format($totalPrice, 2) }}</span>
                                </li>
                            </ul>
                            <div class="recive-details">
                                <form>

                                    <div class="form-2">
                                        <ul class="recive-comments-area">

                                            <li class="recive-comments">
                                                <a href="{{ route('checkout item', 'store=' . $data['user']->businessname) }}"
                                                    class="btn-style1">Checkout</a>
                                            </li>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- cart end -->
@endsection
