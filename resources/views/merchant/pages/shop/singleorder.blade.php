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
               <h1>Order Details</h1>
           </div>
           <hr>
        </div>
        <div class="row">
            @if($product = \App\StoreProducts::where('id', $data['orders']->productId)->first())
                
            <div class="col-md-12 mb-2">
                <p> Order No: {{ $data['orders']->orderId }} </p>
                <p>{{ $data['orders']->quantity}} quantity</p>
                <p>Placed on {{ $data['orders']->created_at}}</p>
                <p>Total: {{ $product->amount}}</p>
            </div>
            <hr>
            <div class="col-md-12 mt-2">
                <p style="font-size: 20px; font-weight:bold">ITEMS IN YOUR ORDER</p>
            </div>  
        </div>
        <div class="row mt-2 mb-3">
            <div class="col-md-12 card-body">
                <p><span 
                    class="{{ $data['orders']->deliveryStatus == 'off' ? 'text-danger' : 'text-success' }}">{{ $data['orders']->deliveryStatus == 'off' ? 'Not Delivered' : 'Delivered' }}</span></p>
                <p>{{ $data['orders']->deliveryDate }}</p>
            </div>
            <div class="col-md-4">
                <img style="width:100%; height:300px; border-radius:10px" src="{{ $product->image }}">
            </div>
            <div class="col-md-8">
                <p>{!! $product->description !!}</p>
            </div>    
            @endif
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <p style="font-size: 18px"><strong>PAYMENTINFORMATION</strong></p>
                <hr>
                <p><strong>Payment Details</strong></p>
                <p class="mt-2 mb-1">Payment Status: <span
                    class="{{ $data['orders']->paymentStatus == 'not paid' ? 'text-danger' : 'text-success' }}">{{ $data['orders']->paymentStatus == 'not paid' ? 'not Paid' : 'Paid' }}</span> 
                </p>
                <p class="mt-2">Price: {{ $product->amount}}</p>
            </div>
            <div class="col-md-6 mb-4">
                <p style="font-size: 18px"><strong>DELIVERY INFORMATION</strong></p>
                <hr>
                <p><strong>Delivery Details</strong></p>
                <p>{{$data['orders']->address }}</p>
                <p class="mt-2">Postal Code: {{$data['orders']->postalCode }}</p>
            </div>
        </div>

       
    </section>





  



@endsection
