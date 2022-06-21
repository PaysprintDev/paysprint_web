@extends('layouts.merch.merchant-shop')

@section('content')
    <!-- breadcrumb start -->
    <section class="about-breadcrumb" style="margin-top: 150px;">
        <div class="about-back section-tb-padding"
            style="background-image: url('{{ array_filter(explode(', ', $data['mystore']->headerContent))[0] }}')">

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
        <div class="container">
            <div class="row mt-5 mb-5">
                <div class="col-md-9">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <div class="card-title">
                                <p style="font-size: 20px" class="c-items mt-3">Cart: ( {{ count($data['mycartlist']) }}
                                    )</p>
                            </div>
                            <hr>
                            @php
                                $totalPrice = 0;
                            @endphp
                            @if (count($data['mycartlist']) > 0)
                                @foreach ($data['mycartlist'] as $cartItem)
                                    @if ($product = \App\StoreProducts::where('id', $cartItem->productId)->first())
                                        <div class="row mb-4">
                                            <div class="col-md-3 mb-3">
                                                <a href="javascript:void(0)"><img style="width: 100%; border-radius:5px;"
                                                        src="{{ $cartItem->productImage }}" class="img-fluid"
                                                        alt="image"></a>
                                                <p class="text-center"> <a href="javascript:void(0)"
                                                        class="pro-remove mt-3 btn btn-warning mb-4">Remove</a></p>
                                            </div>
                                            <div class="col-md-9 mb-3">

                                                <table class="table table-responsive table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <h4 style="font-size: 20px" class="mb-2">
                                                                    {{ $cartItem->productName }}</h4>
                                                                <small>{{ $product->productCode }}</small>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p style="font-size: 15px;">{!! $product->description !!}</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p><span class="pro-size mb-3"><span
                                                                            class="size"><strong>Quantity:</strong></span>
                                                                        {{ $cartItem->quantity }}</span></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5><strong>Price: </strong><span
                                                                        class="cart-pro-price">{{ $data['user']->currencySymbol . number_format($cartItem->price * $cartItem->quantity, 2) }}</span>
                                                                </h5>
                                                            </td>
                                                        </tr>
                                                        {{-- <tr>
                                                            <td>
                                                                <p class="mt-2">
                                                                    <span> <a href="javascript:void(0)"
                                                                            class="minus-btn text-black btn btn-danger">-</a></span>
                                                                    <span><input type="text" name="name"
                                                                            value="{{ $cartItem->quantity }}"
                                                                            style="border-radius:5px;"></span>
                                                                    <span> <a href="javascript:void(0)"
                                                                            class="plus-btn text-black btn btn-success">+</a></span>
                                                                </p>
                                                            </td>
                                                        </tr> --}}
                                                    </tbody>
                                                </table>




                                            </div>
                                            {{-- <div class="col-md-3 mb-3">
                                                <h5 style="font-weight:bold;">
                                                    <span>{{ $data['user']->currencySymbol . number_format($cartItem->price * $cartItem->quantity, 2) }}</span>
                                                </h5>

                                            </div> --}}
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
                <div class="col-md-3">

                    <div class="card">
                        <div class="card-header">
                            CART SUMMARY
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Subtotal: </h5>
                            <h3 class="card-text text-success">
                                {{ $data['user']->currencySymbol . number_format($totalPrice, 2) }}
                            </h3>
                            <br>
                            <a href="{{ route('checkout item', 'store=' . $data['user']->businessname) }}"
                                class="btn-style1 form-control text-center">CHECKOUT</a>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
    <!-- cart end -->
@endsection
