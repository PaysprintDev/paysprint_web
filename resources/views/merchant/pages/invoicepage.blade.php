@extends('layouts.merch.merchant-dashboard')


@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <h3>Invoice</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../dashboard.html">Home</a></li>
                            <li class="breadcrumb-item">Pages</li>
                            <li class="breadcrumb-item">Ecommerce</li>
                            <li class="breadcrumb-item active">Invoice</li>
                        </ol>
                    </div>
                    <div class="col-lg-6">
                        <!-- Bookmark Start-->
                        <div class="bookmark">

                        </div>
                        <!-- Bookmark Ends-->
                    </div>
                </div>
            </div>
        </div>
        <div class="container invoice">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <div>
                                    <div class="row invo-header">
                                        <div class="col-sm-6">
                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="{{ route('dashboard') }}"><img class="media-object img-60"
                                                            {{-- src="{{ asset('assets/images/dashboard/01.jpg') }}" --}}
                                                            src="https://res.cloudinary.com/pilstech/image/upload/v1618251695/paysprint_icon_new_kg2h3j.png"
                                                            alt="" /></a>
                                                </div>
                                                <div class="media-body m-l-20">
                                                    <h4 class="media-heading f-w-600">PaySprint</h4>
                                                    <p>
                                                        hello@viho.in<br />
                                                        <span class="digits">289-335-6503</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- End Info-->
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="text-md-end text-xs-center">
                                                <h3>Invoice #<span class="digits counter">1069</span></h3>
                                                <p>
                                                    Issued: May<span class="digits"> 27, 2015</span><br />
                                                    Payment Due: June <span class="digits">27, 2015</span>
                                                </p>
                                            </div>
                                            <!-- End Title                                 -->
                                        </div>
                                    </div>
                                </div>
                                <!-- End InvoiceTop-->
                                <div class="row invo-profile">
                                    <div class="col-xl-4">
                                        <div class="media">
                                            <div class="media-left"><img class="media-object rounded-circle img-60"
                                                    src="{{ asset('assets/images/dashboard/icons8-invoice-30.png') }}"
                                                    alt="" /></div>
                                            <div class="media-body m-l-20">
                                                <h4 class="media-heading f-w-600">Johan Deo</h4>
                                                <p>
                                                    JohanDeo@gmail.com<br />
                                                    <span class="digits">555-555-5555</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8">
                                        <div class="text-xl-end" id="project">
                                            <h6>Project Description</h6>
                                            <p>
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.It
                                                is a long established fact that a reader will be distracted by the readable
                                                content of a page when looking at its layout.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Invoice Mid-->
                                <div>
                                    <div class="table-responsive invoice-table" id="table">
                                        <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <td class="item">
                                                        <h6 class="p-2 mb-0">Item Description</h6>
                                                    </td>
                                                    <td class="Hours">
                                                        <h6 class="p-2 mb-0">Hours</h6>
                                                    </td>
                                                    <td class="Rate">
                                                        <h6 class="p-2 mb-0">Rate</h6>
                                                    </td>
                                                    <td class="subtotal">
                                                        <h6 class="p-2 mb-0">Sub-total</h6>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>Lorem Ipsum</label>
                                                        <p class="m-0">Lorem Ipsum is simply dummy text of the
                                                            printing and typesetting industry.</p>
                                                    </td>
                                                    <td>
                                                        <p class="itemtext digits">5</p>
                                                    </td>
                                                    <td>
                                                        <p class="itemtext digits">$75</p>
                                                    </td>
                                                    <td>
                                                        <p class="itemtext digits">$375.00</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>Lorem Ipsum</label>
                                                        <p class="m-0">Lorem Ipsum is simply dummy text of the
                                                            printing and typesetting industry.</p>
                                                    </td>
                                                    <td>
                                                        <p class="itemtext digits">3</p>
                                                    </td>
                                                    <td>
                                                        <p class="itemtext digits">$75</p>
                                                    </td>
                                                    <td>
                                                        <p class="itemtext digits">$225.00</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>Lorem Ipsum</label>
                                                        <p class="m-0">Lorem Ipsum is simply dummy text of the
                                                            printing and typesetting industry.</p>
                                                    </td>
                                                    <td>
                                                        <p class="itemtext digits">10</p>
                                                    </td>
                                                    <td>
                                                        <p class="itemtext digits">$75</p>
                                                    </td>
                                                    <td>
                                                        <p class="itemtext digits">$750.00</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>Lorem Ipsum</label>
                                                        <p class="m-0">Lorem Ipsum is simply dummy text of the
                                                            printing and typesetting industry.</p>
                                                    </td>
                                                    <td>
                                                        <p class="itemtext digits">10</p>
                                                    </td>
                                                    <td>
                                                        <p class="itemtext digits">$75</p>
                                                    </td>
                                                    <td>
                                                        <p class="itemtext digits">$750.00</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p class="itemtext"></p>
                                                    </td>
                                                    <td>
                                                        <p class="m-0">HST</p>
                                                    </td>
                                                    <td>
                                                        <p class="m-0 digits">13%</p>
                                                    </td>
                                                    <td>
                                                        <p class="m-0 digits">$419.25</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="Rate">
                                                        <h6 class="mb-0 p-2">Total</h6>
                                                    </td>
                                                    <td class="payment digits">
                                                        <h6 class="mb-0 p-2">$3,644.25</h6>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- End Table-->
                                    <div class="row mt-3">
                                        <div class="col-md-8">
                                            <div>
                                                <p class="legal">
                                                    <strong>Thank you for your business!</strong> Payment is expected within
                                                    31 days; please process this invoice within that time. There will be a
                                                    5% interest charge per month on late invoices.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <form class="text-end invo-pal">
                                                <input type="image" src="../assets/images/other-images/paypal.png"
                                                    name="submit" alt="PayPal - The safer, easier way to pay online!" />
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- End InvoiceBot-->
                            </div>
                            <div class="col-sm-12 text-center mt-3">
                                <a class="btn btn btn-primary me-2" type="button" onclick="goBack()">Go Back</a>
                                <button class="btn btn-secondary" type="submit">Submit</button>
                            </div>
                            <!-- End Invoice-->
                            <!-- End Invoice Holder-->
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Container-fluid Ends-->
    @endsection
