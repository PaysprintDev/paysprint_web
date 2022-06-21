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
                                <li class="about-p"><span>Your Wishlist</span></li>
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
                <h1>My Wishlist</h1>
            </div>
            <hr>
        </div>
        <!-- wishlist content -->
        @if (count($data['mywishlist']) > 0)
            @foreach ($data['mywishlist'] as $wishlist)
                @if ($product = \App\StoreProducts::where('id', $wishlist->productId)->first())
                    <div class="row mt-3 mb-5">
                        <div class="col-md-3">
                            <p><img style="width:100%; border-radius: 10px;" src="{{ $product->image }}"></p>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-striped table-responsive">
                                <tbody>
                                    <tr>
                                        <td>Product Name:</td>
                                        <td>{{ $product->productName }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p>{!! $product->description !!}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>


                        </div>
                        <div class="col-md-3">
                            <span><a class=" text-center" href="javascript:void(0)"
                                    onclick="addCart('{{ $product->id }}', '{{ Auth::id() }}')"
                                    style="color: orange; font-weight:lighter; font-size:18px;">ADD TO CART</a></span>
                            <br>
                            <span class="mt-4">
                                <button class="btn btn-danger" id="btns{{ $wishlist->id }}"
                                    onclick="deleteWishlist('{{ $wishlist->id }}');">Remove from wishlist</button>
                                <form action="{{ route('delete wishlist', $wishlist->id) }}" method="post"
                                    style="visibility: hidden" id="deletewish{{ $wishlist->id }}">
                                    @csrf
                                    <input type="hidden" name="storeid" value="{{ $wishlist->id }}">
                                </form>
                            </span>
                        </div>
                    </div>
                    <hr>
                @endif
            @endforeach
        @else
            <div class="col-md-12 text-center mt-3 mb-5">


                <h4 class="display-4">No Item in your wishlist</h4>
            </div>
        @endif


        @if (count($data['mywishlist']) > 0)
            {{-- Product Open Modal Here --}}
            <section class="quick-view">

                @foreach ($data['mywishlist'] as $wishlist)
                    @if ($product = \App\StoreProducts::where('id', $wishlist->productId)->first())
                        <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1"
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
                                                        <img src="{{ $product->image }}" class="img-fluid"
                                                            alt="image">
                                                    </a>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="quick-caption">
                                            <h4>{{ $product->productName }}</h4>
                                            <div class="quick-price">
                                                <span
                                                    class="new-price">{{ $data['user']->currencySymbol . number_format($product->amount, 2) }}</span>
                                                <span
                                                    style="{{ $product->previousAmount > 0 ? 'text-decoration: line-through;' : '' }}">{{ $product->previousAmount > 0 ? $data['user']->currencySymbol . number_format($product->previousAmount) : '' }}</span>
                                            </div>
                                            <div class="quick-rating disp-0">
                                                <i class="fa fa-star c-star"></i>
                                                <i class="fa fa-star c-star"></i>
                                                <i class="fa fa-star c-star"></i>
                                                <i class="fa fa-star c-star"></i>
                                                <i class="fa fa-star-o"></i>
                                            </div>
                                            <div class="pro-description">
                                                {!! $product->description !!}
                                            </div>

                                            <div class="plus-minus">
                                                <span>
                                                    <a href="javascript:void(0)" class="minus-btn text-black">-</a>
                                                    <input type="text" name="quantity" id="quantity{{ $product->id }}"
                                                        value="1" min="1" max="{{ $product->stock }}">


                                                    <a href="javascript:void(0)" class="plus-btn text-black">+</a>
                                                </span>


                                                @auth
                                                    <a href="javascript:void(0)"
                                                        onclick="addCart('{{ $product->id }}', {{ Auth::id() }})"
                                                        class="quick-cart carty{{ $product->id }}"><i
                                                            class="fa fa-shopping-bag"></i></a>
                                                    <a href="javascript:void(0)"
                                                        onclick="addWishlist('{{ $product->id }}', {{ Auth::id() }})"
                                                        class="quick-wishlist wishes{{ $product->id }}"><i
                                                            class="fa fa-heart"></i></a>

                                                    <div class="spinner-grow text-warning disp-0 modalspinner{{ $product->id }}"
                                                        role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                @endauth


                                                @guest
                                                    <a href="javascript:void(0)" onclick="addCart('{{ $product->id }}', 0)"
                                                        class="quick-cart"><i class="fa fa-shopping-bag"></i></a>
                                                    <a href="javascript:void(0)"
                                                        onclick="addWishlist('{{ $product->id }}', 0)"
                                                        class="quick-wishlist"><i class="fa fa-heart"></i></a>
                                                @endguest


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach




            </section>

            {{-- End Product Open Modal Here --}}
        @endif



    </section>


    <br>
    <br>
    <br>
    <br>
@endsection
