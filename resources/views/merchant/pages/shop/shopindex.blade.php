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
    <section class="about-breadcrumb">
        <div class="about-back section-tb-padding"
            style="background-image: url('{{ array_filter(explode(', ', $data['mystore']->headerContent))[0] }}')">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="about-l">
                            <ul class="about-link">
                                <li class="go-home"><a href="{{ url()->previous() }}">Home</a></li>
                                <li class="about-p"><span>Merchant Shop</span></li>
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
            <div class="col-md-12 mb-3 mt-5">
                <h1>&nbsp;</h1>
            </div>
        </div>
        @if (count($data['myproduct']) > 0)
            <!-- products tab start -->
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
                                            <div class="swiper-slideqqq" style="padding: 10px 10px 50px;">
                                                <div class="tab-product">
                                                    <div class="tred-pro">
                                                        <div class="tr-pro-img">
                                                            <a href="#">
                                                                <img src="{{ $product->image }}"
                                                                    alt="{{ $product->productName }}"
                                                                    class="img-fluid">
                                                                <img src="{{ $product->image }}" alt="additional image"
                                                                    class="img-fluid additional-image">
                                                            </a>
                                                        </div>
                                                        <div class="Pro-lable">
                                                            <span
                                                                class="p-text">{{ $product->stock . ' in stock' }}</span>
                                                        </div>
                                                        <div class="pro-icn">


                                                            @guest
                                                                <a title="add to wishlist" href="javascript:void(0)"
                                                                    class="w-c-q-icn"
                                                                    onclick="addWishlist('{{ $product->id }}', 0)"><i
                                                                        class="fa fa-heart"></i></a>
                                                                <a title="add to cart" href="javascript:void(0)"
                                                                    onclick="addCart('{{ $product->id }}', 0)"
                                                                    class="w-c-q-icn"><i
                                                                        class="fa fa-shopping-bag"></i></a>
                                                                <a title="view product" href="javascript:void(0)"
                                                                    class="w-c-q-icn" data-bs-toggle="modal"
                                                                    data-bs-target="#productModal{{ $product->id }}"><i
                                                                        class="fa fa-eye"></i></a>

                                                            @endguest


                                                            @auth
                                                                <a title="add to wishlist" href="javascript:void(0)"
                                                                    class="w-c-q-icn wishes{{ $product->id }}"
                                                                    onclick="addWishlist('{{ $product->id }}', {{ Auth::id() }})"><i
                                                                        class="fa fa-heart"></i></a>
                                                                <a title="add to cart" href="javascript:void(0)"
                                                                    onclick="addCart('{{ $product->id }}', {{ Auth::id() }})"
                                                                    class="w-c-q-icn carty{{ $product->id }}"><i
                                                                        class="fa fa-shopping-bag "></i></a>
                                                                <a title="view product" href="javascript:void(0)"
                                                                    class="w-c-q-icn" data-bs-toggle="modal"
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
                                    @else
                                        <div class="col-md-12 text-center mt-3 mb-4"
                                            style="font-size: 20px; font-weight:bold">No Products Available
                                        </div>













                                    </div>
                                </div>
                                {{-- <div class="swiper-buttons">
                                                <div class="swiper-button-prev"></div>
                                                <div class="swiper-button-next"></div>
                                            </div> --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- product tab end -->
        @endif
    </section>


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
                                            style="{{ $data['myproduct'][$i]->previousAmount > 0 ? 'text-decoration: line-through;' : '' }}">{{ $data['myproduct'][$i]->previousAmount > 0 ? $data['user']->currencySymbol . number_format($data['myproduct'][$i]->previousAmount) : '' }}</span>
                                    </div>
                                    <div class="quick-rating disp-0">
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
                                            <input type="text" name="quantity"
                                                id="quantity{{ $data['myproduct'][$i]->id }}" value="1" min="1"
                                                max="{{ $data['myproduct'][$i]->stock }}">


                                            <a href="javascript:void(0)" class="plus-btn text-black">+</a>
                                        </span>


                                        @auth
                                            <a href="javascript:void(0)"
                                                onclick="addCart('{{ $data['myproduct'][$i]->id }}', {{ Auth::id() }})"
                                                class="quick-cart carty{{ $data['myproduct'][$i]->id }}"><i
                                                    class="fa fa-shopping-bag"></i></a>
                                            <a href="javascript:void(0)"
                                                onclick="addWishlist('{{ $data['myproduct'][$i]->id }}', {{ Auth::id() }})"
                                                class="quick-wishlist wishes{{ $data['myproduct'][$i]->id }}"><i
                                                    class="fa fa-heart"></i></a>

                                            <div class="spinner-grow text-warning disp-0 modalspinner{{ $data['myproduct'][$i]->id }}"
                                                role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        @endauth


                                        @guest
                                            <a title="add to cart" href="javascript:void(0)"
                                                onclick="addCart('{{ $data['myproduct'][$i]->id }}', 0)"
                                                class="quick-cart"><i class="fa fa-shopping-bag"></i></a>
                                            <a title="add to wishlist" href="javascript:void(0)"
                                                onclick="addWishlist('{{ $data['myproduct'][$i]->id }}', 0)"
                                                class="quick-wishlist"><i class="fa fa-heart"></i></a>
                                        @endguest


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor

        </section>


        <br>
        <br>


        {{-- End Product Open Modal Here --}}
    @endif



@endsection
