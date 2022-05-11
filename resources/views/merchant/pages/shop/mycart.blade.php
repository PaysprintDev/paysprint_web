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
    <section>
        <div class="container mb-4">
            <div class="row mt-4">
                <div class="col-md-9">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="card-title">
                            <p  style="font-size: 20px" class="c-items mt-3">Cart: ( {{ count($data['mycartlist']) }} )</p>
                        </div>
                      <hr>
                      @php
                      $totalPrice = 0;
                      @endphp
                      @if (count($data['mycartlist']) > 0)
                      @foreach ($data['mycartlist'] as $cartItem)
                      @if($product = \App\StoreProducts::where('id', $cartItem->productId)->first())
                      <div class="row mb-5">
                        <div class="col-md-3 mb-3">
                            <a href="javascript:void(0)"><img style="width: 150px; border-radius:5px;" src="{{ $cartItem->productImage }}"
                                class="img-fluid" alt="image"></a>
                                <p> <a href="javascript:void(0)" class="pro-remove mt-3 btn btn-warning mb-4">Remove</a></p>
                        </div>
                        <div class="col-md-7 mb-3">
                            <p style="font-size: 20px" class="mb-2">{{ $cartItem->productName }}</p>
                            <p style="font-size: 15px">{!! $product->description !!}</p>
                            <p><span class="pro-size mb-3"><span class="size"><strong>Quantity:</strong></span>
                                {{ $cartItem->quantity }}</span></p>
                            <p><strong>Price:  </strong><span
                                class="cart-pro-price">{{ $data['user']->currencySymbol . number_format($cartItem->price, 2) }}</span></p>
                                {{-- <p class="mt-2">
                                <span> <a href="javascript:void(0)" class="minus-btn text-black btn btn-danger">-</a></span>
                                <span><input type="text" name="name" value="{{ $cartItem->quantity }}" style="border-radius:5px;"></span>
                               <span> <a href="javascript:void(0)" class="plus-btn text-black btn btn-success">+</a></span>
                                </p> --}}
                            
                        </div>
                        <div class="col-md-2 mb-3">
                            <p style="font-size: 18px; font-weight:bold;"><span>{{ $data['user']->currencySymbol . number_format($cartItem->price * $cartItem->quantity, 2) }}</span></p>
                         
                        </div>
                        <hr>
                        </div>
                        @php $totalPrice += $cartItem->quantity * $cartItem->price; @endphp
                        @endif
                        @endforeach
                    @else
                        <div></div>
                    @endif
                    </div>
                </div>
                </div>
                <div class="col-md-3 card ">
                    <div class="row mt-3">
                    <div class=" col-md-12 ">
                        <p>CART SUMMARY</p>
                    </div>
                    <hr>
                    <div>
                        <div class="c-total">
                            <ul>
                                <li class="c-all-price">
                                    <span style="font-size: 18px">Subtotal:</span> 
                                    <span style="font-size: 18px">{{ $data['user']->currencySymbol . number_format($totalPrice, 2) }}</span>
                                </li>
                            </ul>
                            <div class="recive-details mt-3">
                                <form>

                                    <div class="form-2">
                                        <ul class="recive-comments-area mt-3 mb-3">

                                            <li class="recive-comments">
                                                <a href="{{ route('checkout item', 'store=' . $data['user']->businessname) }}"
                                                    class="btn-style1 form-control">CHECKOUT</a>
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
        </div>
    </section>
    <!-- cart end -->
@endsection
