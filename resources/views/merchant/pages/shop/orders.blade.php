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
               <h1>Orders</h1>
           </div>
           <hr>
        </div>

        <!-- displaying the ordders -->
        @if(count($data['orders']) > 0)
        @foreach ( $data['orders'] as $value )
        @if($product = \App\StoreProducts::where('id', $value->productId)->first())
        <div class="row">
            <div class="col-md-3">
                <p><img style="width:50%" src="{{ $product->image}}"></p>
            </div>
            <div class="col-md-6">
                <p>{!! $product->description !!}</p>
                <p>Order Id: {{$value->orderId}}</p>
                <p>Quantity: {{ $value->quantity }}</p>
                <p><span
                    class="{{ $value->paymentStatus == 'not paid' ? 'text-danger' : 'text-success' }}">{{ $value->paymentStatus == 'not paid' ? 'not Paid' : 'Paid' }}</span></p>
                <p><span 
                    class="{{ $value->deliveryStatus == 'off' ? 'text-danger' : 'text-success' }}">{{ $value->deliveryStatus == 'off' ? 'Not Delivered' : 'Delivered' }}</span></p>
            </div>
            <div class="col-md-3">
                <a href="#" style="color: orange; font-weight:lighter; font-size:18px;">SEE DETAILS</a>
            </div>
        </div>
        <hr>
        @endif
        @endforeach
        @endif
    </section>





  



@endsection
