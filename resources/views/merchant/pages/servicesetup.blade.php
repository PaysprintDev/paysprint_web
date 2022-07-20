@extends('layouts.merch.merchant-dashboard')

<style>
    .note-editor {
        background: white !important;
    }
</style>

@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">

                    <div class="col-lg-6">

                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">




                <!-- DOM / jQuery  Starts-->

                <div class="card-body">



                    <div class="col-sm-12">


                        <div class="card">



                            <div class="card-body">

                                <div class="mb-3">
                                    <a href="{{ route('merchant service now', Auth::user()->businessname) }}"
                                        target="_blank" type="button" class="btn btn-success" style="width: 100%">Preview
                                        Store</a>
                                </div>

                                <div style="background: aliceblue; padding: 20px; margin-bottom: 20px;">
                                    <form action="#" method="post" enctype="multipart/form-data" id="formElemHead">

                                        <h4><strong>Head Section</strong></h4>
                                        <hr>
                                        <div class="mb-3">
                                            <label style="font-weight: bold;" for="businessLogo" class="form-label">Business
                                                Logo</label>
                                            <input type="file" accept="images/*" name="businessLogo" id="businessLogo"
                                                class="form-control" aria-describedby="emailHelp">
                                            <div id="emailHelp" class="form-text">Upload your business logo here.</div>
                                        </div>



                                        <div class="mb-3">
                                            <label style="font-weight: bold;" for="backdropImage" class="form-label">Select
                                                background
                                                drop</label>
                                            <div id="emailHelp" class="form-text">Select your preferred background drop.
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img style="width: 100%; height: 100px;"
                                                        src="{{ asset('backdrop/blue.webp') }}" />

                                                    <div class="form-check mt-2">
                                                        <input class="form-check-input" type="radio" name="backdropImage"
                                                            id="pattern1" value="pattern1"
                                                            @isset($data['myserviceStore']) {{ $data['myserviceStore']->backdropImage === asset('backdrop/blue.webp') ? 'checked' : '' }} @else checked @endisset>

                                                        @isset($data['myserviceStore'])
                                                            {!! $data['myserviceStore']->backdropImage === asset('backdrop/blue.webp')
                                                                ? '<label for="pattern1" class="badge bg-success">Default</label>'
                                                                : '' !!}
                                                        @else
                                                            <label for="pattern1" class="badge bg-success">Default</label>
                                                        @endisset

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <img style="width: 100%; height: 100px;"
                                                        src="{{ asset('backdrop/pattern2.jpg') }}" />

                                                    <div class="form-check mt-2">
                                                        <input class="form-check-input" type="radio" name="backdropImage"
                                                            id="pattern2" value="pattern2"
                                                            @isset($data['myserviceStore']) {{ $data['myserviceStore']->backdropImage === asset('backdrop/pattern2.jpg') ? 'checked' : '' }} @endisset">


                                                        @isset($data['myserviceStore'])
                                                            {!! $data['myserviceStore']->backdropImage === asset('backdrop/pattern2.jpg')
                                                                ? '<label for="pattern1" class="badge bg-success">Default</label>'
                                                                : '' !!}
                                                        @else
                                                            <label for="pattern1" class="badge bg-success">Default</label>
                                                        @endisset

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <img style="width: 100%; height: 100px;"
                                                        src="{{ asset('backdrop/pattern3.jpg') }}" />

                                                    <div class="form-check mt-2">
                                                        <input class="form-check-input" type="radio" name="backdropImage"
                                                            id="pattern3" value="pattern3"
                                                            @isset($data['myserviceStore']) {{ $data['myserviceStore']->backdropImage === asset('backdrop/pattern3.jpg') ? 'checked' : '' }} @endisset">

                                                        @isset($data['myserviceStore'])
                                                            {!! $data['myserviceStore']->backdropImage === asset('backdrop/pattern3.jpg')
                                                                ? '<label for="pattern1" class="badge bg-success">Default</label>'
                                                                : '' !!}
                                                        @else
                                                            <label for="pattern1" class="badge bg-success">Default</label>
                                                        @endisset

                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="mb-3">
                                            <label style="font-weight: bold;" for="businessWelcome" class="form-label">Welcome Text</label>
                                            <input type="text" name="businessWelcome" id="businessWelcome"
                                                class="form-control" placeholder="WELCOME TO {{ strtoupper(Auth::user()->businessname) }}" value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->businessWelcome !== null ? $data['myserviceStore']->businessWelcome : '' }} @endisset">
                                            <div id="emailHelp" class="form-text">A short welcome text.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label style="font-weight: bold;" for="businessWhatWeAre" class="form-label">What we are</label>
                                            <input type="text" name="businessWhatWeAre" id="businessWhatWeAre"
                                                class="form-control" placeholder="Virtual technology in a Refined IT System" value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->businessWhatWeAre !== null ? $data['myserviceStore']->businessWhatWeAre : '' }} @endisset">
                                            <div id="emailHelp" class="form-text">A short description of your company.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label style="font-weight: bold;" for="businessSlogan" class="form-label">Business Slogan</label>
                                            <input type="text" name="businessSlogan" id="businessSlogan"
                                                class="form-control" placeholder="Set the trends for desktop & server virtualization technology" value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->businessSlogan !== null ? $data['myserviceStore']->businessSlogan : '' }} @endisset">
                                            <div id="emailHelp" class="form-text">A short description of your company.</div>
                                        </div>


                                        <div class="mb-3">
                                            <label style="font-weight: bold;" for="youtubeLink" class="form-label">Embed
                                                Youtube
                                                video (optional)</label>
                                            <input type="text" name="youtubeLink" id="youtubeLink" class="form-control"
                                                aria-describedby="youtubeLink"
                                                value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->youtubeLink !== null ? $data['myserviceStore']->youtubeLink : '' }} @endisset">
                                            <div id="emailHelp" class="form-text">An embedded youtube video link about your
                                                business</div>
                                        </div>

                                        <div class="mb-3">
                                            <label style="font-weight: bold;" for="website" class="form-label">Business
                                                Website (optional)</label>
                                            <input type="text" name="website" id="website" class="form-control"
                                                aria-describedby="website"
                                                value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->website !== null ? $data['myserviceStore']->website : '' }} @endisset">
                                            <div id="emailHelp" class="form-text">Redirect customer to your business website
                                            </div>
                                        </div>
                                        <br>
                                        <div class="mb-3">
                                            <button type="button" onclick="serviceSetup('{{ Auth::id() }}', 'header')"
                                                class="btn btn-danger header{{ Auth::id() }}">Submit Header
                                                Section</button>

                                            <button class="btn btn-primary header disp-0" type="button" disabled>
                                                <span class="spinner-grow spinner-grow-sm" role="status"
                                                    aria-hidden="true"></span>
                                                Loading...
                                            </button>
                                        </div>

                                        <br>
                                        <br>




                                    </form>
                                </div>

                                <div style="background: cornsilk; padding: 20px; margin-bottom: 20px;">
                                    <form action="#" method="post" enctype="multipart/form-data"
                                        id="formElemAbout">
                                        <h4><strong>About Company</strong></h4>
                                        <hr>

                                        <div class="mb-3">
                                            <label style="font-weight: bold;" for="aboutUs" class="form-label">Brief
                                                About Business</label>
                                            <textarea cols="20" rows="10" name="aboutUs" id="aboutUs" class="form-control"
                                                aria-describedby="aboutUs">
@isset($data['myserviceStore'])
{{ $data['myserviceStore']->aboutUs !== null ? $data['myserviceStore']->aboutUs : '' }}
@endisset
</textarea>
                                            <div id="emailHelp" class="form-text">Briefly describe your business.
                                                <span class="text-danger"><strong>150 characters</strong></span>
                                            </div>
                                        </div>


                                        <div class="mb-3">
                                            <br>
                                            <h6 style="font-weight: bold;">More Business Information</h6>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label style="font-weight: bold;" for="aboutUsQ1"
                                                        class="form-label">Question One</label>
                                                    <input type="text" name="aboutUsQ1" id="aboutUsQ1"
                                                        class="form-control" aria-describedby="aboutUsQ1"
                                                        value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->aboutUsQ1 !== null ? $data['myserviceStore']->aboutUsQ1 : '' }} @endisset">
                                                    <br />
                                                    <label style="font-weight: bold;" for="aboutUsA1"
                                                        class="form-label">Answer One</label>
                                                    <textarea cols="10" rows="10" name="aboutUsA1" id="aboutUsA1" class="form-control"
                                                        aria-describedby="aboutUsA1">
@isset($data['myserviceStore'])
{{ $data['myserviceStore']->aboutUsA1 !== null ? $data['myserviceStore']->aboutUsA1 : '' }}
@endisset
</textarea>
                                                    <div id="emailHelp" class="form-text">Briefly describe your business.
                                                        <span class="text-danger"><strong>150 characters</strong></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label style="font-weight: bold;" for="aboutUsQ2"
                                                        class="form-label">Question Two</label>
                                                    <input type="text" name="aboutUsQ2" id="aboutUsQ2"
                                                        class="form-control" aria-describedby="aboutUsQ2"
                                                        value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->aboutUsQ2 !== null ? $data['myserviceStore']->aboutUsQ2 : '' }} @endisset">
                                                    <br />
                                                    <label style="font-weight: bold;" for="aboutUsA2"
                                                        class="form-label">Answer Two</label>
                                                    <textarea cols="10" rows="10" name="aboutUsA2" id="aboutUsA2" class="form-control"
                                                        aria-describedby="aboutUsA2">
@isset($data['myserviceStore'])
{{ $data['myserviceStore']->aboutUsA2 !== null ? $data['myserviceStore']->aboutUsA2 : '' }}
@endisset
</textarea>
                                                    <div id="emailHelp" class="form-text">Briefly describe your business.
                                                        <span class="text-danger"><strong>150 characters</strong></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label style="font-weight: bold;" for="aboutUsQ3"
                                                        class="form-label">Question Three</label>
                                                    <input type="text" name="aboutUsQ3" id="aboutUsQ3"
                                                        class="form-control" aria-describedby="aboutUsQ3"
                                                        value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->aboutUsQ3 !== null ? $data['myserviceStore']->aboutUsQ3 : '' }} @endisset">

                                                    <br />
                                                    <label style="font-weight: bold;" for="aboutUsA3"
                                                        class="form-label">Answer Three</label>
                                                    <textarea cols="10" rows="10" name="aboutUsA3" id="aboutUsA3" class="form-control"
                                                        aria-describedby="aboutUsA3">
@isset($data['myserviceStore'])
{{ $data['myserviceStore']->aboutUsA3 !== null ? $data['myserviceStore']->aboutUsA3 : '' }}
@endisset
</textarea>
                                                    <div id="emailHelp" class="form-text">Briefly describe your business.
                                                        <span class="text-danger"><strong>150 characters</strong></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                        <br>
                                        <div class="mb-3">
                                            <label style="font-weight: bold;" for="aboutImportantImage"
                                                class="form-label">Important
                                                Company Image (Optional)</label>
                                            <input type="file" accept="images/*" name="aboutImportantImage"
                                                id="aboutImportantImage" class="form-control"
                                                aria-describedby="emailHelp">
                                            <div id="emailHelp" class="form-text">If there is any important official
                                                image.
                                            </div>
                                        </div>

                                        <br>
                                        <div class="mb-3">
                                            <button type="button" onclick="serviceSetup('{{ Auth::id() }}', 'about')"
                                                class="btn btn-danger about{{ Auth::id() }}">Submit About
                                                Section</button>

                                            <button class="btn btn-primary about disp-0" type="button" disabled>
                                                <span class="spinner-grow spinner-grow-sm" role="status"
                                                    aria-hidden="true"></span>
                                                Loading...
                                            </button>
                                        </div>
                                        <br>
                                        <br>

                                    </form>
                                </div>


                                <div style="background: aliceblue; padding: 20px; margin-bottom: 20px;">
                                    <form action="#" method="post" id="formElemService">
                                        <h4><strong>Your Services</strong></h4>
                                        <hr>

                                        <div class="mb-3">


                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label style="font-weight: bold;" for="services1"
                                                        class="form-label">Service One</label>
                                                    <input type="text" name="services1" id="services1"
                                                        class="form-control" aria-describedby="services1"
                                                        value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->services1 !== null ? $data['myserviceStore']->services1 : '' }} @endisset">

                                                    <br />
                                                    <label style="font-weight: bold;" for="serviceBenefits1"
                                                        class="form-label">Benefits</label>
                                                    <textarea cols="10" rows="10" name="serviceBenefits1" id="serviceBenefits1" class="form-control"
                                                        aria-describedby="serviceBenefits1">
@isset($data['myserviceStore'])
{{ $data['myserviceStore']->serviceBenefits1 !== null ? $data['myserviceStore']->serviceBenefits1 : '' }}
@endisset
</textarea>
                                                    <div id="emailHelp" class="form-text">Tell your customers about the
                                                        benefits of the service
                                                    </div>

                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label style="font-weight: bold;" for="services2"
                                                        class="form-label">Service Two</label>
                                                    <input type="text" name="services2" id="services2"
                                                        class="form-control" aria-describedby="services2"
                                                        value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->services2 !== null ? $data['myserviceStore']->services2 : '' }} @endisset">

                                                    <br />
                                                    <label style="font-weight: bold;" for="serviceBenefits2"
                                                        class="form-label">Benefits</label>
                                                    <textarea cols="10" rows="10" name="serviceBenefits2" id="serviceBenefits2" class="form-control"
                                                        aria-describedby="serviceBenefits2">
@isset($data['myserviceStore'])
{{ $data['myserviceStore']->serviceBenefits2 !== null ? $data['myserviceStore']->serviceBenefits2 : '' }}
@endisset
</textarea>
                                                    <div id="emailHelp" class="form-text">Tell your customers about the
                                                        benefits of the service
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label style="font-weight: bold;" for="services3"
                                                        class="form-label">Service Three</label>
                                                    <input type="text" name="services3" id="services3"
                                                        class="form-control" aria-describedby="services3"
                                                        value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->services3 !== null ? $data['myserviceStore']->services3 : '' }} @endisset">


                                                    <br />
                                                    <label style="font-weight: bold;" for="serviceBenefits3"
                                                        class="form-label">Benefits</label>
                                                    <textarea cols="10" rows="10" name="serviceBenefits3" id="serviceBenefits3" class="form-control"
                                                        aria-describedby="serviceBenefits3">
@isset($data['myserviceStore'])
{{ $data['myserviceStore']->serviceBenefits3 !== null ? $data['myserviceStore']->serviceBenefits3 : '' }}
@endisset
</textarea>
                                                    <div id="emailHelp" class="form-text">Tell your customers about the
                                                        benefits of the service
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label style="font-weight: bold;" for="services4"
                                                        class="form-label">Service Four</label>
                                                    <input type="text" name="services4" id="services4"
                                                        class="form-control" aria-describedby="services4"
                                                        value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->services4 !== null ? $data['myserviceStore']->services4 : '' }} @endisset">

                                                    <br />
                                                    <label style="font-weight: bold;" for="serviceBenefits4"
                                                        class="form-label">Benefits</label>
                                                    <textarea cols="10" rows="10" name="serviceBenefits4" id="serviceBenefits4" class="form-control"
                                                        aria-describedby="serviceBenefits4">
@isset($data['myserviceStore'])
{{ $data['myserviceStore']->serviceBenefits4 !== null ? $data['myserviceStore']->serviceBenefits4 : '' }}
@endisset
</textarea>
                                                    <div id="emailHelp" class="form-text">Tell your customers about the
                                                        benefits of the service
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label style="font-weight: bold;" for="services5"
                                                        class="form-label">Service Five</label>
                                                    <input type="text" name="services5" id="services5"
                                                        class="form-control" aria-describedby="services5"
                                                        value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->services5 !== null ? $data['myserviceStore']->services5 : '' }} @endisset">

                                                    <br />
                                                    <label style="font-weight: bold;" for="serviceBenefits5"
                                                        class="form-label">Benefits</label>
                                                    <textarea cols="10" rows="10" name="serviceBenefits5" id="serviceBenefits5" class="form-control"
                                                        aria-describedby="serviceBenefits5">
@isset($data['myserviceStore'])
{{ $data['myserviceStore']->serviceBenefits5 !== null ? $data['myserviceStore']->serviceBenefits5 : '' }}
@endisset
</textarea>
                                                    <div id="emailHelp" class="form-text">Tell your customers about the
                                                        benefits of the service
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label style="font-weight: bold;" for="services6"
                                                        class="form-label">Service Six</label>
                                                    <input type="text" name="services6" id="services6"
                                                        class="form-control" aria-describedby="services6"
                                                        value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->services6 !== null ? $data['myserviceStore']->services6 : '' }} @endisset">

                                                    <br />
                                                    <label style="font-weight: bold;" for="serviceBenefits6"
                                                        class="form-label">Benefits</label>
                                                    <textarea cols="10" rows="10" name="serviceBenefits6" id="serviceBenefits6" class="form-control"
                                                        aria-describedby="serviceBenefits6">
@isset($data['myserviceStore'])
{{ $data['myserviceStore']->serviceBenefits6 !== null ? $data['myserviceStore']->serviceBenefits6 : '' }}
@endisset
</textarea>
                                                    <div id="emailHelp" class="form-text">Tell your customers about the
                                                        benefits of the service
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <br>
                                        <div class="mb-3">
                                            <button type="button"
                                                onclick="serviceSetup('{{ Auth::id() }}', 'service')"
                                                class="btn btn-danger service{{ Auth::id() }}">Submit Services
                                                Section</button>


                                            <button class="btn btn-primary service disp-0" type="button" disabled>
                                                <span class="spinner-grow spinner-grow-sm" role="status"
                                                    aria-hidden="true"></span>
                                                Loading...
                                            </button>
                                        </div>

                                        <br>
                                        <br>

                                    </form>
                                </div>

                                <div style="background: cornsilk; padding: 20px; margin-bottom: 20px;">
                                    <form action="#" method="post" id="formElemPricing">
                                        <h4><strong>Plan & Pricing</strong></h4>
                                        <hr>

                                        <div class="mb-3">
                                            <br>
                                            <h6 style="font-weight: bold;">Organize Your Plan Type</h6>
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <label style="font-weight: bold;" for="pricing1"
                                                        class="form-label">Plan A</label>
                                                    <input type="text" name="pricing1" id="pricing1"
                                                        class="form-control" aria-describedby="pricing1"
                                                        placeholder="Basic"
                                                        value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->pricing1 !== null ? $data['myserviceStore']->pricing1 : '' }} @endisset">
                                                    <br />
                                                    <label style="font-weight: bold;" for="pricingPlan1"
                                                        class="form-label">Plan Amount</label>
                                                    <input type="text" name="pricingPlan1" id="pricingPlan1"
                                                        class="form-control" aria-describedby="pricingPlan1"
                                                        value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->pricingPlan1 !== null ? $data['myserviceStore']->pricingPlan1 : '' }} @endisset">
                                                    <br />
                                                    <label style="font-weight: bold;" for="pricingOffer1"
                                                        class="form-label">Service Offer</label>
                                                    <textarea cols="10" rows="10" name="pricingOffer1" id="pricingOffer1" class="form-control"
                                                        aria-describedby="pricingOffer1">
@isset($data['myserviceStore'])
{{ $data['myserviceStore']->pricingOffer1 !== null ? $data['myserviceStore']->pricingOffer1 : '' }}
@endisset
</textarea>
                                                    <div id="emailHelp" class="form-text">Briefly describe your business.
                                                        <span class="text-danger"><strong>150 characters</strong></span>
                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <label style="font-weight: bold;" for="pricing2"
                                                        class="form-label">Plan B</label>
                                                    <input type="text" name="pricing2" id="pricing2"
                                                        class="form-control" aria-describedby="pricing2"
                                                        placeholder="Professional"
                                                        value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->pricing2 !== null ? $data['myserviceStore']->pricing2 : '' }} @endisset">
                                                    <br />
                                                    <label style="font-weight: bold;" for="pricingPlan2"
                                                        class="form-label">Plan Amount</label>
                                                    <input type="text" name="pricingPlan2" id="pricingPlan2"
                                                        class="form-control" aria-describedby="pricingPlan2"
                                                        value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->pricingPlan2 !== null ? $data['myserviceStore']->pricingPlan2 : '' }} @endisset">
                                                    <br />
                                                    <label style="font-weight: bold;" for="pricingOffer2"
                                                        class="form-label">Service Offer</label>
                                                    <textarea cols="10" rows="10" name="pricingOffer2" id="pricingOffer2" class="form-control"
                                                        aria-describedby="pricingOffer2">
@isset($data['myserviceStore'])
{{ $data['myserviceStore']->pricingOffer2 !== null ? $data['myserviceStore']->pricingOffer2 : '' }}
@endisset
</textarea>
                                                    <div id="emailHelp" class="form-text">Briefly describe your business.
                                                        <span class="text-danger"><strong>150 characters</strong></span>
                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <label style="font-weight: bold;" for="pricing3"
                                                        class="form-label">Plan C</label>
                                                    <input type="text" name="pricing3" id="pricing3"
                                                        class="form-control" aria-describedby="pricing3"
                                                        placeholder="Professional Plus"
                                                        value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->pricing3 !== null ? $data['myserviceStore']->pricing3 : '' }} @endisset">
                                                    <br />
                                                    <label style="font-weight: bold;" for="pricingPlan3"
                                                        class="form-label">Plan Amount</label>
                                                    <input type="text" name="pricingPlan3" id="pricingPlan3"
                                                        class="form-control" aria-describedby="pricingPlan3"
                                                        value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->pricingPlan3 !== null ? $data['myserviceStore']->pricingPlan3 : '' }} @endisset">
                                                    <br />
                                                    <label style="font-weight: bold;" for="pricingOffer3"
                                                        class="form-label">Service Offer</label>
                                                    <textarea cols="10" rows="10" name="pricingOffer3" id="pricingOffer3" class="form-control"
                                                        aria-describedby="pricingOffer3">
@isset($data['myserviceStore'])
{{ $data['myserviceStore']->pricingOffer3 !== null ? $data['myserviceStore']->pricingOffer3 : '' }}
@endisset
</textarea>
                                                    <div id="emailHelp" class="form-text">Briefly describe your business.
                                                        <span class="text-danger"><strong>150 characters</strong></span>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <br>
                                        <div class="mb-3">
                                            <button type="button"
                                                onclick="serviceSetup('{{ Auth::id() }}', 'pricing')"
                                                class="btn btn-danger pricing{{ Auth::id() }}">Submit Pricing
                                                Section</button>

                                            <button class="btn btn-primary pricing disp-0" type="button" disabled>
                                                <span class="spinner-grow spinner-grow-sm" role="status"
                                                    aria-hidden="true"></span>
                                                Loading...
                                            </button>
                                        </div>

                                        <br>
                                        <br>

                                    </form>
                                </div>


                                <div style="background: aliceblue; padding: 20px; margin-bottom: 20px;">
                                    <form action="#" method="post" enctype="multipart/form-data"
                                        id="formElemTestimonial">
                                        <h4><strong>Testimonial</strong></h4>
                                        <hr>

                                        <div class="mb-3">
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <label style="font-weight: bold;" for="testimonialName"
                                                        class="form-label">Customer Name/Company</label>
                                                    <input type="text" name="testimonialName" id="testimonialName"
                                                        class="form-control" aria-describedby="testimonialName">
                                                </div>

                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <label style="font-weight: bold;" for="testimonialImage"
                                                        class="form-label">Customer Image (optional)</label>
                                                    <input type="file" accept="images/*" name="testimonialImage"
                                                        id="testimonialImage" class="form-control"
                                                        aria-describedby="testimonialImage">
                                                </div>
                                                <div class="col-md-6">
                                                    <label style="font-weight: bold;" for="testimonialRating"
                                                        class="form-label">Rating received</label>
                                                    <select class="form-select" aria-label="Rating received"
                                                        id="testimonialRating" name="testimonialRating">
                                                        <option selected>Select option</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <label style="font-weight: bold;" for="testimonialDescription"
                                                        class="form-label">Testimony</label>
                                                    <textarea cols="20" rows="10" name="testimonialDescription" id="testimonialDescription"
                                                        class="form-control" aria-describedby="testimonialDescription"></textarea>
                                                </div>

                                            </div>

                                        </div>

                                        <br>
                                        <div class="mb-3">
                                            <button type="button"
                                                onclick="serviceSetup('{{ Auth::id() }}', 'testimonial')"
                                                class="btn btn-danger testimonial{{ Auth::id() }}">Submit Testimonial
                                                Section</button>

                                            <button class="btn btn-primary testimonial disp-0" type="button" disabled>
                                                <span class="spinner-grow spinner-grow-sm" role="status"
                                                    aria-hidden="true"></span>
                                                Loading...
                                            </button>

                                        </div>
                                        <br>
                                        <br>

                                    </form>
                                </div>


                                <div style="background: cornsilk; padding: 20px; margin-bottom: 20px;">
                                    <form action="#" method="post" id="formElemContact">
                                        <h4><strong>Contact Us</strong></h4>
                                        <hr>

                                        <div class="mb-3">

                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <label style="font-weight: bold;" for="contactNumber"
                                                        class="form-label">Contact Number</label>
                                                    <input type="text" name="contactNumber" id="contactNumber"
                                                        class="form-control" aria-describedby="contactNumber"
                                                        value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->contactNumber !== null ? $data['myserviceStore']->contactNumber : '' }} @endisset">
                                                </div>
                                                <div class="col-md-6">
                                                    <label style="font-weight: bold;" for="contactEmail"
                                                        class="form-label">Contact Email</label>
                                                    <input type="text" name="contactEmail" id="contactEmail"
                                                        class="form-control" aria-describedby="contactEmail"
                                                        value="@isset($data['myserviceStore']) {{ $data['myserviceStore']->contactEmail !== null ? $data['myserviceStore']->contactEmail : '' }} @endisset">
                                                </div>

                                            </div>



                                        </div>

                                        <br>
                                        <div class="mb-3">
                                            <button type="button"
                                                onclick="serviceSetup('{{ Auth::id() }}', 'contact')"
                                                class="btn btn-danger contact{{ Auth::id() }}">Submit Contact
                                                Section</button>

                                            <button class="btn btn-primary contact disp-0" type="button" disabled>
                                                <span class="spinner-grow spinner-grow-sm" role="status"
                                                    aria-hidden="true"></span>
                                                Loading...
                                            </button>
                                        </div>

                                    </form>
                                </div>


                                <div class="mb-3">
                                    <a href="{{ route('merchant service now', Auth::user()->businessname) }}"
                                        target="_blank" type="button" class="btn btn-success"
                                        style="width: 100%">Preview
                                        Store</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column rendering Ends-->
                    <!-- Multiple table control elements  Starts-->
                </div>
            </div>
        </div>


        <!-- Container-fluid Ends-->
    </div>
@endsection
