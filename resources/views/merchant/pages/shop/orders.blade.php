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
        </div>

        <!-- displaying the ordders -->
        @if (count($data['orders']) > 0)
            @foreach ($data['orders'] as $value)
                <hr>

                @if ($product = \App\StoreProducts::where('id', $value->productId)->first())
                    <div class="row mt-3 mb-5">
                        <div class="col-md-3">
                            <p><img style="width:100%; border-radius: 10px;" src="{{ $product->image }}"></p>
                        </div>
                        <div class="col-md-6">

                            <table class="table table-striped table-responsive">

                                <tbody>
                                    <tr>
                                        <td>Order Id:</td>
                                        <td>
                                            <p>{!! $value->orderId !!}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p>{!! $product->description !!}</p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Quantity:</td>
                                        <td>
                                            <p>{!! $value->quantity !!}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Payment Status:</td>
                                        <td>
                                            <p><span
                                                    class="{{ $value->paymentStatus == 'not paid' ? 'badge bg-danger' : 'badge bg-success' }}">{{ $value->paymentStatus == 'not paid' ? 'not paid' : 'Paid' }}</span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Delivery Status:</td>
                                        <td>
                                            <p>
                                                <span
                                                    class="{{ $value->deliveryStatus == 'off' ? 'badge bg-danger' : 'badge bg-success' }}">{{ $value->deliveryStatus == 'off' ? 'Not Delivered' : 'Delivered' }}</span>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>


                        </div>
                        <div class="col-md-3">
                            <a class="text-center"
                                href="{{ route('single orders', 'merchant=' . $data['user']->businessname . '&orderid=' . $value->orderId) }}"
                                style="color: orange; font-weight:lighter; font-size:18px;">SEE
                                DETAILS</a>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </section>









@endsection
