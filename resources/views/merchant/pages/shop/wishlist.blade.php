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
            <div class="col-md-12 mb-3">
                <h1>My Wishlist</h1>
            </div>
            <hr>
        </div>
        <!-- wishlist content -->
                @if(count($data['mywishlist']) > 0)
            @foreach ($data['mywishlist'] as $wishlist )
            @if($product = \App\StoreProducts::where('id', $wishlist->productId)->first())
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
                    <span><a class=" text-center"
                        href=""javascript:void(0)" onclick="addCart($wishlist->productId, $wishlist->merchantId)"
                        style="color: orange; font-weight:lighter; font-size:18px;">ADD TO CART</a></span>
                        <br>
                        <span class="mt-4">
                            <button class="btn btn-danger" id="btns{{ $wishlist->id}}"
                                onclick="deleteWishlist('{{ $wishlist->id }}');">Remove from wishlist</button>
                            <form action="{{ route('delete wishlist',$wishlist->id)}}"
                                method="post" style="visibility: hidden"
                                id="deletewish{{ $wishlist->id }}">
                                @csrf
                                <input type="hidden" name="storeid"
                                    value="{{ $wishlist->id }}">
                            </form>
                        </span>
                </div>
            </div>
            <hr>
                   @endif
                   @endforeach
                   @else
                   <div class="col-md-12 text-center mt-3 mb-4" style="font-size: 20px; font-weight:bold">No Item in your wishlist</div>
                   @endif
                    
        
        


    </section>
@endsection
