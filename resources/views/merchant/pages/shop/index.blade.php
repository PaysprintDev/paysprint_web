@extends('layouts.merch.merchant-shop')



@section('content')
    <!--home page slider start-->
    <section class="home-slider-5">
        <div class="home-slider-main-5">
            <div class="home5-slider swiper-container">
                <div class="swiper-wrapper">
                    @for ($i = 0; $i < count(explode(', ', $data['mystore']->headerContent)); $i++)
                        @if (explode(', ', $data['mystore']->headerContent)[$i] != '')
                            <div class="swiper-slide">
                                <div class="img-back s-image1"
                                    style="background-image:url('{{ explode(', ', $data['mystore']->headerContent)[$i] }}');">
                                    <div class="h-s-content">

                                        <h1>{{ explode(', ', $data['mystore']->headerTitle)[$i] }}</h1>
                                        <h3>{{ explode(', ', $data['mystore']->headerSubtitle)[$i] }}</h3>
                                        <a href="#">Shop now</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endfor


                </div>
                <div class="swiper-buttons">
                    <button class="swiper-prev"><i class="fa fa-angle-left"></i></button>
                    <button class="swiper-next"><i class="fa fa-angle-right"></i></button>
                </div>
                <div class="swiper-pagination"><span></span></div>
            </div>
        </div>
    </section>
    <!--home page slider end-->


    @if ($data['mystore']->advertSectionImage != null)
        <!-- grid banner start -->

        <section class="section-tb-padding home5-grid-banner">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="organic-food-fresh-banner">

                            @for ($i = 0; $i < count(explode(', ', $data['mystore']->advertSectionImage)); $i++)
                                @if (explode(', ', $data['mystore']->advertSectionImage)[$i] != '')
                                    <div class="offer-banner">
                                        <a href="#" class="banner-hover">
                                            <img src="{{ explode(', ', $data['mystore']->advertSectionImage)[$i] }}"
                                                alt="offer-banner" class="img-fluid"
                                                style="width: 100%; height: 280px; object-fit:cover;">
                                        </a>
                                        <div class="banner-content">
                                            <span>{{ explode(', ', $data['mystore']->advertTitle)[$i] }}</span>
                                            <h2>{{ explode(', ', $data['mystore']->advertSubtitle)[$i] }}</h2>
                                            <a href="#">Shop now <i class="fa fa-angle-right"></i></a>
                                        </div>
                                    </div>
                                @endif
                            @endfor

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- grid banner end -->
    @endif







    <!-- service start -->
    <section class="home5-service section-b-padding">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="service">
                        <div class="service-box">
                            <div class="s-box">
                                <i class="ti-truck"></i>
                                <div class="service-content">
                                    <span>Safe delivery</span>
                                    <p>Orders from all item</p>
                                </div>
                            </div>
                        </div>
                        <div class="service-box">
                            <div class="s-box">
                                <i class="ti-money"></i>
                                <div class="service-content">
                                    <span>Return & refund</span>
                                    <p>Money back guarantee</p>
                                </div>
                            </div>
                        </div>
                        <div class="service-box">
                            <div class="s-box">
                                <i class="ti-headphone"></i>
                                <div class="service-content">
                                    <span>Quality support</span>
                                    <p>Alway online 24/7</p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="service-box">
                            <div class="s-box">
                                <i class="ti-email"></i>
                                <div class="service-content">
                                    <span>Join newslleter</span>
                                    <p>20% off by subscribing</p>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- service end -->



    <!-- category image strat -->
    <section class="home5-category disp-0">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-title">
                        <h2>Shop by category</h2>
                    </div>
                    <div class="home5-cate-image owl-carousel owl-theme">
                        <div class="items">
                            <div class="cate-image">
                                <a href="#">
                                    <img src="{{ asset('shopassets/image/category-image/home-5/image1.jpg') }}"
                                        class="img-fluid" alt="cate-image">
                                </a>
                                <span>Organic dryfruit</span>
                                <p>19 item</p>
                            </div>
                        </div>
                        <div class="items">
                            <div class="cate-image">
                                <a href="#">
                                    <img src="{{ asset('shopassets/image/category-image/home-5/image2.jpg') }}"
                                        class="img-fluid" alt="cate-image">
                                </a>
                                <span>Green seafood</span>
                                <p>19 item</p>
                            </div>
                        </div>
                        <div class="items">
                            <div class="cate-image">
                                <a href="#">
                                    <img src="{{ asset('shopassets/image/category-image/home-5/image3.jpg') }}"
                                        class="img-fluid" alt="cate-image">
                                </a>
                                <span>Organic juice</span>
                                <p>19 item</p>
                            </div>
                        </div>
                        <div class="items">
                            <div class="cate-image">
                                <a href="#">
                                    <img src="{{ asset('shopassets/image/category-image/home-5/image4.jpg') }}"
                                        class="img-fluid" alt="cate-image">
                                </a>
                                <span>Dairy & chesse</span>
                                <p>19 item</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- category image end -->


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
                                        <div class="swiper-wrapper">

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
                                                                <a href="#" class="w-c-q-icn"><i
                                                                        class="fa fa-heart"></i></a>
                                                                <a href="#" class="w-c-q-icn"><i
                                                                        class="fa fa-shopping-bag"></i></a>
                                                                <a href="javascript:void(0)" class="w-c-q-icn"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#productModal{{ $product->id }}"><i
                                                                        class="fa fa-eye"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="tab-caption">
                                                            <h3><a href="#">{{ $product->productName }}</a>
                                                            </h3>
                                                            <div class="rating">
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


    <!-- deal of the day start -->
    <section class="deal-day5 disp-0">
        <div class="deal5-back" style="background-image: url('{{ asset('shopassets/image/dealbanner3.jpg') }}');">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="deal-area5">
                            <div class="deal-content">
                                <h2>Deal of the day! <span>Sale</span></h2>
                                <span class="deal-slogan">We offer a hot deal offer every festival</span>
                            </div>
                            <ul class="contdown_row">
                                <li class="countdown_section">
                                    <span id="days" class="countdown_timer">254</span>
                                    <span class="countdown_title">Days</span>
                                </li>
                                <li class="countdown_section">
                                    <span id="hours" class="countdown_timer">11</span>
                                    <span class="countdown_title">Hours</span>
                                </li>
                                <li class="countdown_section">
                                    <span id="minutes" class="countdown_timer">33</span>
                                    <span class="countdown_title">Minutes</span>
                                </li>
                                <li class="countdown_section">
                                    <span id="seconds" class="countdown_timer">36</span>
                                    <span class="countdown_title">Seconds</span>
                                </li>
                            </ul>
                            <a href="#" class="btn btn-style1">Shop collection</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- deal of the day end -->



    <!-- featured products start -->
    <section class="home5-featured section-tb-padding disp-0">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-title">
                        <h2>Featured products</h2>
                    </div>
                    <div class="featured5-pro owl-carousel owl-theme">
                        <div class="items">
                            <div class="tred-pro">
                                <div class="tr-pro-img">
                                    <a href="#">
                                        <img class="img-fluid"
                                            src="{{ asset('shopassets/image/pro/pro-img-1.jpg') }}" alt="pro-img1">
                                        <img class="img-fluid additional-image"
                                            src="{{ asset('shopassets/image/pro/pro-img-01.jpg') }}"
                                            alt="additional image">
                                    </a>
                                </div>
                                <div class="Pro-lable">
                                    <span class="p-text">New</span>
                                </div>
                                <div class="pro-icn">
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-heart"></i></a>
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-shopping-bag"></i></a>
                                    <a href="javascript:void(0)" class="w-c-q-icn" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h3><a href="#">Fresh organic fruit (50gm)</a></h3>
                                <div class="rating">
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <div class="pro-price">
                                    <span class="new-price">$130.00 USD</span>
                                </div>
                            </div>
                        </div>
                        <div class="items">
                            <div class="tred-pro">
                                <div class="tr-pro-img">
                                    <a href="#">
                                        <img class="img-fluid"
                                            src="{{ asset('shopassets/image/pro/pro-img-2.jpg') }}" alt="pro-img1">
                                        <img class="img-fluid additional-image"
                                            src="{{ asset('shopassets/image/pro/pro-img-02.jpg') }}"
                                            alt="additional image">
                                    </a>
                                </div>
                                <div class="Pro-lable">
                                    <span class="p-text">New</span>
                                </div>
                                <div class="pro-icn">
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-heart"></i></a>
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-shopping-bag"></i></a>
                                    <a href="javascript:void(0)" class="w-c-q-icn" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h3><a href="#">Fresh & healty food</a></h3>
                                <div class="rating">
                                    <i class="fa fa-star e-star"></i>
                                    <i class="fa fa-star e-star"></i>
                                    <i class="fa fa-star e-star"></i>
                                    <i class="fa fa-star e-star"></i>
                                    <i class="fa fa-star e-star"></i>
                                </div>
                                <div class="pro-price">
                                    <span class="new-price">$126.00 USD</span>
                                </div>
                            </div>
                        </div>
                        <div class="items">
                            <div class="tred-pro">
                                <div class="tr-pro-img">
                                    <a href="#">
                                        <img class="img-fluid"
                                            src="{{ asset('shopassets/image/pro/pro-img-3.jpg') }}" alt="pro-img1">
                                        <img class="img-fluid additional-image"
                                            src="{{ asset('shopassets/image/pro/pro-img-03.jpg') }}"
                                            alt="additional image">
                                    </a>
                                </div>
                                <div class="Pro-lable">
                                    <span class="p-discount">-20%</span>
                                </div>
                                <div class="pro-icn">
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-heart"></i></a>
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-shopping-bag"></i></a>
                                    <a href="javascript:void(0)" class="w-c-q-icn" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h3><a href="#">Fresh apple</a></h3>
                                <div class="rating">
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <div class="pro-price">
                                    <span class="new-price">$130.00 USD</span>
                                    <span class="old-price"><del>$150.00 USD</del></span>
                                </div>
                            </div>
                        </div>
                        <div class="items">
                            <div class="tred-pro">
                                <div class="tr-pro-img">
                                    <a href="#">
                                        <img class="img-fluid"
                                            src="{{ asset('shopassets/image/pro/pro-img-4.jpg') }}" alt="pro-img1">
                                        <img class="img-fluid additional-image"
                                            src="{{ asset('shopassets/image/pro/pro-img-04.jpg') }}"
                                            alt="additional image">
                                    </a>
                                </div>
                                <div class="Pro-lable">
                                    <span class="p-text">New</span>
                                </div>
                                <div class="pro-icn">
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-heart"></i></a>
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-shopping-bag"></i></a>
                                    <a href="javascript:void(0)" class="w-c-q-icn" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h3><a href="#">Fresh litchi 100% organic</a></h3>
                                <div class="rating">
                                    <i class="fa fa-star e-star"></i>
                                    <i class="fa fa-star e-star"></i>
                                    <i class="fa fa-star e-star"></i>
                                    <i class="fa fa-star e-star"></i>
                                    <i class="fa fa-star e-star"></i>
                                </div>
                                <div class="pro-price">
                                    <span class="new-price">$117.00 USD</span>
                                </div>
                            </div>
                        </div>
                        <div class="items">
                            <div class="tred-pro">
                                <div class="tr-pro-img">
                                    <a href="#">
                                        <img class="img-fluid"
                                            src="{{ asset('shopassets/image/pro/pro-img-5.jpg') }}" alt="pro-img1">
                                        <img class="img-fluid additional-image"
                                            src="{{ asset('shopassets/image/pro/pro-img-05.jpg') }}"
                                            alt="additional image">
                                    </a>
                                </div>
                                <div class="Pro-lable">
                                    <span class="p-discount">-12%</span>
                                </div>
                                <div class="pro-icn">
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-heart"></i></a>
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-shopping-bag"></i></a>
                                    <a href="javascript:void(0)" class="w-c-q-icn" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h3><a href="#">Vegetable tomato fresh</a></h3>
                                <div class="rating">
                                    <i class="fa fa-star b-star"></i>
                                    <i class="fa fa-star b-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <div class="pro-price">
                                    <span class="new-price">$133.00 USD</span>
                                    <span class="old-price"><del>$145.00 USD</del></span>
                                </div>
                            </div>
                        </div>
                        <div class="items">
                            <div class="tred-pro">
                                <div class="tr-pro-img">
                                    <a href="#">
                                        <img class="img-fluid"
                                            src="{{ asset('shopassets/image/pro/pro-img-6.jpg') }}" alt="pro-img1">
                                        <img class="img-fluid additional-image"
                                            src="{{ asset('shopassets/image/pro/pro-img-06.jpg') }}"
                                            alt="additional image">
                                    </a>
                                </div>
                                <div class="Pro-lable">
                                    <span class="p-discount">-21%</span>
                                </div>
                                <div class="pro-icn">
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-heart"></i></a>
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-shopping-bag"></i></a>
                                    <a href="javascript:void(0)" class="w-c-q-icn" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h3><a href="#">Natural grassbean</a></h3>
                                <div class="rating">
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <div class="pro-price">
                                    <span class="new-price">$139.00 USD</span>
                                    <span class="old-price"><del>$160.00 USD</del></span>
                                </div>
                            </div>
                        </div>
                        <div class="items">
                            <div class="tred-pro">
                                <div class="tr-pro-img">
                                    <a href="#">
                                        <img class="img-fluid"
                                            src="{{ asset('shopassets/image/pro/pro-img-7.jpg') }}" alt="pro-img1">
                                        <img class="img-fluid additional-image"
                                            src="{{ asset('shopassets/image/pro/pro-img-07.jpg') }}"
                                            alt="additional image">
                                    </a>
                                </div>
                                <div class="Pro-lable">
                                    <span class="p-discount">-10%</span>
                                </div>
                                <div class="pro-icn">
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-heart"></i></a>
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-shopping-bag"></i></a>
                                    <a href="javascript:void(0)" class="w-c-q-icn" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h3><a href="#">Fresh dryed almod (50gm)</a></h3>
                                <div class="rating">
                                    <i class="fa fa-star e-star"></i>
                                    <i class="fa fa-star e-star"></i>
                                    <i class="fa fa-star e-star"></i>
                                    <i class="fa fa-star e-star"></i>
                                    <i class="fa fa-star e-star"></i>
                                </div>
                                <div class="pro-price">
                                    <span class="new-price">$580.00 USD</span>
                                    <span class="old-price"><del>$590.00 USD</del></span>
                                </div>
                            </div>
                        </div>
                        <div class="items">
                            <div class="tred-pro">
                                <div class="tr-pro-img">
                                    <a href="#">
                                        <img class="img-fluid"
                                            src="{{ asset('shopassets/image/pro/pro-img-8.jpg') }}" alt="pro-img1">
                                        <img class="img-fluid additional-image"
                                            src="{{ asset('shopassets/image/pro/pro-img-08.jpg') }}"
                                            alt="additional image">
                                    </a>
                                </div>
                                <div class="Pro-lable">
                                    <span class="p-text">New</span>
                                </div>
                                <div class="pro-icn">
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-heart"></i></a>
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-shopping-bag"></i></a>
                                    <a href="javascript:void(0)" class="w-c-q-icn" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h3><a href="#">Orange juice (5ltr)</a></h3>
                                <div class="rating">
                                    <i class="fa fa-star b-star"></i>
                                    <i class="fa fa-star b-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <div class="pro-price">
                                    <span class="new-price">$93.00 USD</span>
                                </div>
                            </div>
                        </div>
                        <div class="items">
                            <div class="tred-pro">
                                <div class="tr-pro-img">
                                    <a href="#">
                                        <img class="img-fluid"
                                            src="{{ asset('shopassets/image/pro/pro-img-9.jpg') }}" alt="pro-img1">
                                        <img class="img-fluid additional-image"
                                            src="{{ asset('shopassets/image/pro/pro-img-09.jpg') }}"
                                            alt="additional image">
                                    </a>
                                </div>
                                <div class="Pro-lable">
                                    <span class="p-discount">-12%</span>
                                </div>
                                <div class="pro-icn">
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-heart"></i></a>
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-shopping-bag"></i></a>
                                    <a href="javascript:void(0)" class="w-c-q-icn" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h3><a href="#">Organic coconet (5ltr) juice</a></h3>
                                <div class="rating">
                                    <i class="fa fa-star d-star"></i>
                                    <i class="fa fa-star d-star"></i>
                                    <i class="fa fa-star d-star"></i>
                                    <i class="fa fa-star d-star"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <div class="pro-price">
                                    <span class="new-price">$167.00 USD</span>
                                    <span class="old-price"><del>$179.00 USD</del></span>
                                </div>
                            </div>
                        </div>
                        <div class="items">
                            <div class="tred-pro">
                                <div class="tr-pro-img">
                                    <a href="#">
                                        <img class="img-fluid"
                                            src="{{ asset('shopassets/image/pro/pro-img-10.jpg') }}" alt="pro-img1">
                                        <img class="img-fluid additional-image"
                                            src="{{ asset('shopassets/image/pro/pro-img-010.jpg') }}"
                                            alt="additional image">
                                    </a>
                                </div>
                                <div class="Pro-lable">
                                    <span class="p-text">New</span>
                                </div>
                                <div class="pro-icn">
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-heart"></i></a>
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-shopping-bag"></i></a>
                                    <a href="javascript:void(0)" class="w-c-q-icn" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h3><a href="#">Shrimp jumbo (5Lb)</a></h3>
                                <div class="rating">
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star c-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <div class="pro-price">
                                    <span class="new-price">$230.00 USD</span>
                                </div>
                            </div>
                        </div>
                        <div class="items">
                            <div class="tred-pro">
                                <div class="tr-pro-img">
                                    <a href="#">
                                        <img class="img-fluid"
                                            src="{{ asset('shopassets/image/pro/pro-img-11.jpg') }}" alt="pro-img1">
                                        <img class="img-fluid additional-image"
                                            src="{{ asset('shopassets/image/pro/pro-img-011.jpg') }}"
                                            alt="additional image">
                                    </a>
                                </div>
                                <div class="Pro-lable">
                                    <span class="p-text">New</span>
                                </div>
                                <div class="pro-icn">
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-heart"></i></a>
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-shopping-bag"></i></a>
                                    <a href="javascript:void(0)" class="w-c-q-icn" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h3><a href="#">Sp.red fresh guava</a></h3>
                                <div class="rating">
                                    <i class="fa fa-star d-star"></i>
                                    <i class="fa fa-star d-star"></i>
                                    <i class="fa fa-star d-star"></i>
                                    <i class="fa fa-star d-star"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <div class="pro-price">
                                    <span class="new-price">$45.00 USD</span>
                                </div>
                            </div>
                        </div>
                        <div class="items">
                            <div class="tred-pro">
                                <div class="tr-pro-img">
                                    <a href="#">
                                        <img class="img-fluid" src="image/pro/pro-img-12.jpg" alt="pro-img1">
                                        <img class="img-fluid additional-image" src="image/pro/pro-img-012.jpg"
                                            alt="additional image">
                                    </a>
                                </div>
                                <div class="Pro-lable">
                                    <span class="p-discount">-25%</span>
                                </div>
                                <div class="pro-icn">
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-heart"></i></a>
                                    <a href="#" class="w-c-q-icn"><i class="fa fa-shopping-bag"></i></a>
                                    <a href="javascript:void(0)" class="w-c-q-icn" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"><i class="fa fa-eye"></i></a>
                                </div>
                            </div>
                            <div class="caption">
                                <h3><a href="#">Fresh mussel (500g)</a></h3>
                                <div class="rating">
                                    <i class="fa fa-star d-star"></i>
                                    <i class="fa fa-star d-star"></i>
                                    <i class="fa fa-star d-star"></i>
                                    <i class="fa fa-star d-star"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <div class="pro-price">
                                    <span class="new-price">$245.00 USD</span>
                                    <span class="old-price"><del>$270.00 USD</del></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- featured products end -->


    <!-- quick veiw start -->
    <section class="quick-view">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Product quickview</h5>
                        <a href="javascript:void(0)" data-bs-dismiss="modal" aria-label="Close"><i
                                class="ion-close-round"></i></a>
                    </div>
                    <div class="quick-veiw-area">
                        <div class="quick-image">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="image-1">
                                    <a href="javascript:void(0)" class="long-img">
                                        <img src="{{ asset('shopassets/image/pro-page-image/pro-page-image.jpg') }}"
                                            class="img-fluid" alt="image">
                                    </a>
                                </div>
                                <div class="tab-pane fade show" id="image-2">
                                    <a href="javascript:void(0)" class="long-img">
                                        <img src="{{ asset('shopassets/image/pro-page-image/prro-page-image01.jpg') }}"
                                            class="img-fluid" alt="image">
                                    </a>
                                </div>
                                <div class="tab-pane fade show" id="image-3">
                                    <a href="javascript:void(0)" class="long-img">
                                        <img src="{{ asset('shopassets/image/pro-page-image/pro-page-image1-1.jpg') }}"
                                            class="img-fluid" alt="image">
                                    </a>
                                </div>
                                <div class="tab-pane fade show" id="image-4">
                                    <a href="javascript:void(0)" class="long-img">
                                        <img src="{{ asset('shopassets/image/pro-page-image/pro-page-image1.jpg') }}"
                                            class="img-fluid" alt="image">
                                    </a>
                                </div>
                                <div class="tab-pane fade show" id="image-5">
                                    <a href="javascript:void(0)" class="long-img">
                                        <img src="{{ asset('shopassets/image/pro-page-image/pro-page-image2.jpg') }}"
                                            class="img-fluid" alt="image">
                                    </a>
                                </div>
                                <div class="tab-pane fade show" id="image-6">
                                    <a href="javascript:void(0)" class="long-img">
                                        <img src="{{ asset('shopassets/image/pro-page-image/pro-page-image2-2.jpg') }}"
                                            class="img-fluid" alt="image">
                                    </a>
                                </div>
                                <div class="tab-pane fade show" id="image-7">
                                    <a href="javascript:void(0)" class="long-img">
                                        <img src="{{ asset('shopassets/image/pro-page-image/pro-page-image3.jpg') }}"
                                            class="img-fluid" alt="image">
                                    </a>
                                </div>
                                <div class="tab-pane fade show" id="image-8">
                                    <a href="javascript:void(0)" class="long-img">
                                        <img src="{{ asset('shopassets/image/pro-page-image/pro-page-image03.jpg') }}"
                                            class="img-fluid" alt="image">
                                    </a>
                                </div>
                            </div>
                            <ul class="nav nav-tabs quick-slider owl-carousel owl-theme">
                                <li class="nav-item items">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#image-1"><img
                                            src="{{ asset('shopassets/image/pro-page-image/image1.jpg') }}"
                                            class="img-fluid" alt="image"></a>
                                </li>
                                <li class="nav-item items">
                                    <a class="nav-link" data-bs-toggle="tab" href="#image-2"><img
                                            src="{{ asset('shopassets/image/pro-page-image/image2.jpg') }}"
                                            class="img-fluid" alt="iamge"></a>
                                </li>
                                <li class="nav-item items">
                                    <a class="nav-link" data-bs-toggle="tab" href="#image-3"><img
                                            src="{{ asset('shopassets/image/pro-page-image/image3.jpg') }}"
                                            class="img-fluid" alt="image"></a>
                                </li>
                                <li class="nav-item items">
                                    <a class="nav-link" data-bs-toggle="tab" href="#image-4"><img
                                            src="{{ asset('shopassets/image/pro-page-image/image4.jpg') }}"
                                            class="img-fluid" alt="image"></a>
                                </li>
                                <li class="nav-item items">
                                    <a class="nav-link" data-bs-toggle="tab" href="#image-5"><img
                                            src="{{ asset('shopassets/image/pro-page-image/image5.jpg') }}"
                                            class="img-fluid" alt="image"></a>
                                </li>
                                <li class="nav-item items">
                                    <a class="nav-link" data-bs-toggle="tab" href="#image-6"><img
                                            src="{{ asset('shopassets/image/pro-page-image/image6.jpg') }}"
                                            class="img-fluid" alt="image"></a>
                                </li>
                                <li class="nav-item items">
                                    <a class="nav-link" data-bs-toggle="tab" href="#image-7"><img
                                            src="{{ asset('shopassets/image/pro-page-image/image8.jpg') }}"
                                            class="img-fluid" alt="image"></a>
                                </li>
                                <li class="nav-item items">
                                    <a class="nav-link" data-bs-toggle="tab" href="#image-8"><img
                                            src="{{ asset('shopassets/image/pro-page-image/image7.jpg') }}"
                                            class="img-fluid" alt="image"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="quick-caption">
                            <h4>Fresh organic reachter</h4>
                            <div class="quick-price">
                                <span class="new-price">$350.00 USD</span>
                                <span class="old-price"><del>$399.99 USD</del></span>
                            </div>
                            <div class="quick-rating">
                                <i class="fa fa-star c-star"></i>
                                <i class="fa fa-star c-star"></i>
                                <i class="fa fa-star c-star"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <div class="pro-description">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                    Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                    unknown printer took a galley of type and</p>
                            </div>
                            <div class="pro-size">
                                <label>Size: </label>
                                <select>
                                    <option>1 ltr</option>
                                    <option>3 ltr</option>
                                    <option>5 ltr</option>
                                </select>
                            </div>
                            <div class="plus-minus">
                                <span>
                                    <a href="javascript:void(0)" class="minus-btn text-black">-</a>
                                    <input type="text" name="name" value="1">
                                    <a href="javascript:void(0)" class="plus-btn text-black">+</a>
                                </span>
                                <a href="#" class="quick-cart"><i class="fa fa-shopping-bag"></i></a>
                                <a href="#" class="quick-wishlist"><i class="fa fa-heart"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- quick veiw end -->


    @if (count($data['myproduct']) > 0)
        {{-- Product Open Modal Here --}}
        <section class="quick-view">

            @for ($i = 0; $i < count($data['myproduct']); $i++)
                <div class="modal fade" id="productModal{{ $data['myproduct'][$i]->id }}" tabindex="-1"
                    aria-labelledby="productModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productModalLabel">
                                    Product

                                    quickview </h5>
                                <a href="javascript:void(0)" data-bs-dismiss="modal" aria-label="Close"><i
                                        class="ion-close-round"></i></a>
                            </div>
                            <div class="quick-veiw-area">
                                <div class="quick-image">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="image-1">
                                            <a href="javascript:void(0)" class="long-img">
                                                <img src="{{ $data['myproduct'][$i]->image }}" class="img-fluid"
                                                    alt="image">
                                            </a>
                                        </div>

                                    </div>

                                </div>
                                <div class="quick-caption">
                                    <h4>{{ $data['myproduct'][$i]->productName }}</h4>
                                    <div class="quick-price">
                                        <span
                                            class="new-price">{{ $data['user']->currencySymbol . number_format($data['myproduct'][$i]->amount, 2) }}</span>
                                        <span
                                            style="{{ $data['myproduct'][$i]->previousAmount > 0 ? 'text-decoration: line-through;' : '' }}">{{ $data['myproduct'][$i]->previousAmount > 0? $data['user']->currencySymbol . number_format($data['myproduct'][$i]->previousAmount): '' }}</span>
                                    </div>
                                    <div class="quick-rating">
                                        <i class="fa fa-star c-star"></i>
                                        <i class="fa fa-star c-star"></i>
                                        <i class="fa fa-star c-star"></i>
                                        <i class="fa fa-star c-star"></i>
                                        <i class="fa fa-star-o"></i>
                                    </div>
                                    <div class="pro-description">
                                        {!! $data['myproduct'][$i]->description !!}
                                    </div>

                                    <div class="plus-minus">
                                        <span>
                                            <a href="javascript:void(0)" class="minus-btn text-black">-</a>
                                            <input type="text" name="name" value="1" min="1"
                                                max="{{ $data['myproduct'][$i]->stock }}">
                                            <a href="javascript:void(0)" class="plus-btn text-black">+</a>
                                        </span>
                                        <a href="#" class="quick-cart"><i class="fa fa-shopping-bag"></i></a>
                                        <a href="#" class="quick-wishlist"><i class="fa fa-heart"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor

        </section>





        {{-- End Product Open Modal Here --}}
    @endif


@endsection
