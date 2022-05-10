@extends('layouts.merch.merchant-shop')


<style>
    .h-s-content {
        background-color: #fff;
        padding: 20px 30px;
        border-radius: 20px;
    }

    .banner-content {
        background-color: #fff;
        padding: 10px;
        border-radius: 10px;
    }

</style>

@section('content')
    <!--home page slider start-->
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
    <!--home page slider end-->

    <!-- displaying products starts -->
    <section class="container">
        <div class="row">
            @if (count($data['myproduct']) > 0)
            <!-- products tab start -->
            <section class="section-tb-padding">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="pro-tab">
                                <div class="tab-title">
                                    <div class="section-title">
                                        <h2>Our products</h2>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#home">New product</a>
                                        </li>
    
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="home">
                                        <div class="home5-tab swiper-container">
                                            <div class="swiper-wrapper col-md-3">
    
    
                                                @foreach ($data['myproduct'] as $product)
                                                    <div class="swiper-slide">
                                                        <div class="tab-product">
                                                            <div class="tred-pro">
                                                                <div class="tr-pro-img">
                                                                    <a href="#">
                                                                        <img src="{{ $product->image }}" alt="pro-img1"
                                                                            class="img-fluid"
                                                                            style="width: 100%;height: auto;object-fit: contain;">
                                                                        <img src="{{ $product->image }}"
                                                                            alt="additional image"
                                                                            class="img-fluid additional-image">
                                                                    </a>
                                                                </div>
                                                                <div class="Pro-lable">
                                                                    <span
                                                                        class="p-text">{{ $product->stock . ' in stock' }}</span>
                                                                </div>
                                                                <div class="pro-icn">
    
    
                                                                    @guest
                                                                        <a href="javascript:void(0)" class="w-c-q-icn"
                                                                            onclick="addWishlist('{{ $product->id }}', 0)"><i
                                                                                class="fa fa-heart"></i></a>
                                                                        <a href="javascript:void(0)"
                                                                            onclick="addCart('{{ $product->id }}', 0)"
                                                                            class="w-c-q-icn"><i
                                                                                class="fa fa-shopping-bag"></i></a>
                                                                        <a href="javascript:void(0)" class="w-c-q-icn"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#productModal{{ $product->id }}"><i
                                                                                class="fa fa-eye"></i></a>
    
                                                                    @endguest
    
    
                                                                    @auth
                                                                        <a href="javascript:void(0)"
                                                                            class="w-c-q-icn wishes{{ $product->id }}"
                                                                            onclick="addWishlist('{{ $product->id }}', {{ Auth::id() }})"><i
                                                                                class="fa fa-heart"></i></a>
                                                                        <a href="javascript:void(0)"
                                                                            onclick="addCart('{{ $product->id }}', {{ Auth::id() }})"
                                                                            class="w-c-q-icn carty{{ $product->id }}"><i
                                                                                class="fa fa-shopping-bag "></i></a>
                                                                        <a href="javascript:void(0)" class="w-c-q-icn"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#productModal{{ $product->id }}"><i
                                                                                class="fa fa-eye"></i></a>
    
                                                                        <div class="spinner-grow text-warning disp-0 modalspinner{{ $product->id }}"
                                                                            role="status">
                                                                            <span class="sr-only">Loading...</span>
                                                                        </div>
                                                                    @endauth
    
    
                                                                </div>
                                                            </div>
                                                            <div class="tab-caption">
                                                                <h3><a href="#">{{ $product->productName }}</a>
                                                                </h3>
                                                                <div class="rating disp-0">
                                                                    <i class="fa fa-star e-star"></i>
                                                                    <i class="fa fa-star e-star"></i>
                                                                    <i class="fa fa-star e-star"></i>
                                                                    <i class="fa fa-star e-star"></i>
                                                                    <i class="fa fa-star e-star"></i>
                                                                </div>
                                                                <div class="pro-price">
                                                                    <span
                                                                        class="new-price">{{ $data['user']->currencySymbol . number_format($product->amount, 2) }}
                                                                        {{ $product->previousAmount > 0 ? ' - ' : '' }}</span>
                                                                    <span
                                                                        style="{{ $product->previousAmount > 0 ? 'text-decoration: line-through;' : '' }}">{{ $product->previousAmount > 0 ? $data['user']->currencySymbol . number_format($product->previousAmount) : '' }}</span>
    
    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
    
    
    
    
    
    
    
    
    
    
    
    
    
    
                                            </div>
                                        </div>
                                        <div class="swiper-buttons">
                                            <div class="swiper-button-prev"></div>
                                            <div class="swiper-button-next"></div>
                                        </div>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- product tab end -->
        @endif
        </div>
    </section>





  



@endsection
