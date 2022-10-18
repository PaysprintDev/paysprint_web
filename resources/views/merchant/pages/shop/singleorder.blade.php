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
            @if ($product = \App\StoreProducts::where('id', $data['orders']->productId)->first())
                <div class="col-md-12 mb-2">
                    <table class="table" style="width: 50% !important;">
                        <tbody>
                            <tr>
                                <td>Order No:</td>
                                <td>{{ $data['orders']->orderId }}</td>
                            </tr>
                            <tr>
                                <td>Quantity:</td>
                                <td>{{ $data['orders']->quantity }}</td>
                            </tr>
                            <tr>
                                <td>Placed on:</td>
                                <td>{{ date('d-m-Y H:i a', strtotime($data['orders']->created_at)) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <h4 style="font-weight: bold;">Total: {{ $data['user']->currencySymbol . $product->amount }}</h4>
                </div>
                <hr>
                <div class="col-md-12 mt-2">
                    <p style="font-size: 20px; font-weight:bold">ITEMS IN YOUR ORDER</p>
                </div>
        </div>
        <div class="row mt-2 mb-3">
            <div class="col-md-12 card-body">
                <p><span
                        class="{{ $data['orders']->deliveryStatus == 'off' ? 'badge bg-danger' : ($data['orders']->deliveryStatus == 'in-progress' ? 'badge bg-warning' : 'badge bg-success') }}">{{ $data['orders']->deliveryStatus == 'off' ? 'Not Delivered' : ucfirst($data['orders']->deliveryStatus) }}</span>
                </p>
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
                <p style="font-size: 18px"><strong>PAYMENT INFORMATION</strong></p>
                <hr>
                <p><strong>Payment Details</strong></p>
                <p class="mt-2 mb-1">Payment Status: <span
                        class="{{ $data['orders']->paymentStatus == 'not paid' ? 'badge bg-danger' : 'badge bg-success' }}">{{ $data['orders']->paymentStatus == 'not paid' ? 'not Paid' : 'Paid' }}</span>
                </p>
                <h4 style="font-weight: bold;">Price: {{ $data['user']->currencySymbol . $product->amount }}</h4>
            </div>
            <div class="col-md-6 mb-4">
                <p style="font-size: 18px"><strong>DELIVERY INFORMATION</strong></p>
                <hr>
                <p><strong>Delivery Details</strong></p>
                <p>{{ $data['orders']->address }}</p>
                <p class="mt-2">Postal Code: {{ $data['orders']->postalCode }}</p>
                <p class="mt-2">Additional Information: {!! $data['orders']->additionalInfo !!}</p>
            </div>
        </div>


    </section>
@endsection
