@extends('layouts.merch.merchant-dashboard')


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

                                <div style="background: aliceblue; padding: 20px; margin-bottom: 20px;">
                                    <form action="#" method="post" enctype="multipart/form-data" id="formElemHead">

                                        <h4><strong>Head Section</strong></h4>
                                        <hr>
                                        <div class="mb-3">
                                            <label style="font-weight: bold;" for="businessLogo" class="form-label">Business
                                                Logo</label>
                                            <input type="file" name="businessLogo" id="businessLogo" class="form-control"
                                                aria-describedby="emailHelp">
                                            <div id="emailHelp" class="form-text">Upload your business logo here.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label style="font-weight: bold;" for="businessLogo" class="form-label">Select
                                                background
                                                drop</label>
                                            <div id="emailHelp" class="form-text">Select your preferred background drop.
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img style="width: 100%; height: 100px;"
                                                        src="{{ asset('backdrop/blue.webp') }}" />

                                                    <div class="form-check mt-2">
                                                        <input class="form-check-input" type="radio" name="backdrop"
                                                            id="blue" value="blue" checked>
                                                        <label for="blue" class="badge bg-success">Default</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <img style="width: 100%; height: 100px;"
                                                        src="{{ asset('backdrop/pattern2.jpg') }}" />

                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="backdrop"
                                                            id="pattern2" value="pattern2">

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <img style="width: 100%; height: 100px;"
                                                        src="{{ asset('backdrop/pattern3.jpg') }}" />

                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="backdrop"
                                                            id="pattern3" value="pattern3">

                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="mb-3">
                                            <label style="font-weight: bold;" for="youtubeLink" class="form-label">Embed
                                                Youtube
                                                video (optional)</label>
                                            <input type="text" name="youtubeLink" id="youtubeLink" class="form-control"
                                                aria-describedby="youtubeLink">
                                            <div id="emailHelp" class="form-text">An embedded youtube video link about your
                                                business</div>
                                        </div>

                                        <div class="mb-3">
                                            <label style="font-weight: bold;" for="businessWebsite"
                                                class="form-label">Business
                                                Website (optional)</label>
                                            <input type="text" name="businessWebsite" id="businessWebsite"
                                                class="form-control" aria-describedby="businessWebsite">
                                            <div id="emailHelp" class="form-text">Redirect customer to your business website
                                            </div>
                                        </div>
                                        <br>
                                        <div class="mb-3">
                                            <button type="button" onclick="serviceSetup('{{ Auth::id() }}', 'header')"
                                                class="btn btn-danger">Submit Header Section</button>
                                        </div>

                                        <br>
                                        <br>




                                    </form>
                                </div>

                                <div style="background: cornsilk; padding: 20px; margin-bottom: 20px;">
                                    <form action="#" method="post" enctype="multipart/form-data" id="formElemAbout">
                                        <h4><strong>About Company</strong></h4>
                                        <hr>

                                        <div class="mb-3">
                                            <label style="font-weight: bold;" for="businessDescription"
                                                class="form-label">Brief
                                                About Business</label>
                                            <textarea name="businessDescription" id="businessDescription" class="form-control"
                                                aria-describedby="businessDescription"></textarea>
                                            <div id="emailHelp" class="form-text">Briefly describe your business.
                                                <span class="text-danger"><strong>150 characters</strong></span>
                                            </div>
                                        </div>


                                        <div class="mb-3">
                                            <br>
                                            <h6 style="font-weight: bold;">More Business Information</h6>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label style="font-weight: bold;" for="legendQuestionOne"
                                                        class="form-label">Question One</label>
                                                    <input type="text" name="legendQuestionOne" id="legendQuestionOne"
                                                        class="form-control" aria-describedby="legendQuestionOne">
                                                    <br />
                                                    <label style="font-weight: bold;" for="legendAnswerOne"
                                                        class="form-label">Answer One</label>
                                                    <textarea name="legendAnswerOne" id="legendAnswerOne" class="form-control" aria-describedby="legendAnswerOne"></textarea>
                                                    <div id="emailHelp" class="form-text">Briefly describe your business.
                                                        <span class="text-danger"><strong>150 characters</strong></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label style="font-weight: bold;" for="legendQuestionTwo"
                                                        class="form-label">Question Two</label>
                                                    <input type="text" name="legendQuestionTwo" id="legendQuestionTwo"
                                                        class="form-control" aria-describedby="legendQuestionTwo">
                                                    <br />
                                                    <label style="font-weight: bold;" for="legendAnswerTwo"
                                                        class="form-label">Answer Two</label>
                                                    <textarea name="legendAnswerTwo" id="legendAnswerTwo" class="form-control" aria-describedby="legendAnswerTwo"></textarea>
                                                    <div id="emailHelp" class="form-text">Briefly describe your business.
                                                        <span class="text-danger"><strong>150 characters</strong></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label style="font-weight: bold;" for="legendQuestionThree"
                                                        class="form-label">Question Three</label>
                                                    <input type="text" name="legendQuestionThree"
                                                        id="legendQuestionThree" class="form-control"
                                                        aria-describedby="legendQuestionThree">

                                                    <br />
                                                    <label style="font-weight: bold;" for="legendAnswerThree"
                                                        class="form-label">Answer Three</label>
                                                    <textarea name="legendAnswerThree" id="legendAnswerThree" class="form-control" aria-describedby="legendAnswerThree"></textarea>
                                                    <div id="emailHelp" class="form-text">Briefly describe your business.
                                                        <span class="text-danger"><strong>150 characters</strong></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                        <br>
                                        <div class="mb-3">
                                            <label style="font-weight: bold;" for="businessLogo"
                                                class="form-label">Important
                                                Company Image (Optional)</label>
                                            <input type="file" name="businessLogo" id="businessLogo"
                                                class="form-control" aria-describedby="emailHelp">
                                            <div id="emailHelp" class="form-text">If there is any important official
                                                image.
                                            </div>
                                        </div>

                                        <br>
                                        <div class="mb-3">
                                            <button type="button" onclick="serviceSetup('{{ Auth::id() }}', 'about')"
                                                class="btn btn-danger">Submit About Section</button>
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
                                                    <label style="font-weight: bold;" for="businessServiceOne"
                                                        class="form-label">Service One</label>
                                                    <input type="text" name="businessServiceOne"
                                                        id="businessServiceOne" class="form-control"
                                                        aria-describedby="businessServiceOne">

                                                    <br />
                                                    <label style="font-weight: bold;" for="businessServiceBenefits"
                                                        class="form-label">Benefits</label>
                                                    <textarea name="businessServiceBenefits" id="businessServiceBenefits" class="form-control"
                                                        aria-describedby="businessServiceBenefits"></textarea>
                                                    <div id="emailHelp" class="form-text">Tell your customers about the
                                                        benefits of the service
                                                    </div>

                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label style="font-weight: bold;" for="businessServiceTwo"
                                                        class="form-label">Service Two</label>
                                                    <input type="text" name="businessServiceTwo"
                                                        id="businessServiceTwo" class="form-control"
                                                        aria-describedby="businessServiceTwo">

                                                    <br />
                                                    <label style="font-weight: bold;" for="businessServiceBenefitsTwo"
                                                        class="form-label">Benefits</label>
                                                    <textarea name="businessServiceBenefitsTwo" id="businessServiceBenefitsTwo" class="form-control"
                                                        aria-describedby="businessServiceBenefitsTwo"></textarea>
                                                    <div id="emailHelp" class="form-text">Tell your customers about the
                                                        benefits of the service
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label style="font-weight: bold;" for="businessServiceThree"
                                                        class="form-label">Service Three</label>
                                                    <input type="text" name="businessServiceThree"
                                                        id="businessServiceThree" class="form-control"
                                                        aria-describedby="businessServiceThree">


                                                    <br />
                                                    <label style="font-weight: bold;" for="businessServiceBenefitsThree"
                                                        class="form-label">Benefits</label>
                                                    <textarea name="businessServiceBenefitsThree" id="businessServiceBenefitsThree" class="form-control"
                                                        aria-describedby="businessServiceBenefitsThree"></textarea>
                                                    <div id="emailHelp" class="form-text">Tell your customers about the
                                                        benefits of the service
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label style="font-weight: bold;" for="businessServiceFour"
                                                        class="form-label">Service Four</label>
                                                    <input type="text" name="businessServiceFour"
                                                        id="businessServiceFour" class="form-control"
                                                        aria-describedby="businessServiceFour">

                                                    <br />
                                                    <label style="font-weight: bold;" for="businessServiceBenefitsFour"
                                                        class="form-label">Benefits</label>
                                                    <textarea name="businessServiceBenefitsFour" id="businessServiceBenefitsFour" class="form-control"
                                                        aria-describedby="businessServiceBenefitsFour"></textarea>
                                                    <div id="emailHelp" class="form-text">Tell your customers about the
                                                        benefits of the service
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label style="font-weight: bold;" for="businessServiceFive"
                                                        class="form-label">Service Five</label>
                                                    <input type="text" name="businessServiceFive"
                                                        id="businessServiceFive" class="form-control"
                                                        aria-describedby="businessServiceFive">

                                                    <br />
                                                    <label style="font-weight: bold;" for="businessServiceBenefitsFive"
                                                        class="form-label">Benefits</label>
                                                    <textarea name="businessServiceBenefitsFive" id="businessServiceBenefitsFive" class="form-control"
                                                        aria-describedby="businessServiceBenefitsFive"></textarea>
                                                    <div id="emailHelp" class="form-text">Tell your customers about the
                                                        benefits of the service
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label style="font-weight: bold;" for="businessServiceSix"
                                                        class="form-label">Service Six</label>
                                                    <input type="text" name="businessServiceSix"
                                                        id="businessServiceSix" class="form-control"
                                                        aria-describedby="businessServiceSix">

                                                    <br />
                                                    <label style="font-weight: bold;" for="businessServiceBenefitsSix"
                                                        class="form-label">Benefits</label>
                                                    <textarea name="businessServiceBenefitsSix" id="businessServiceBenefitsSix" class="form-control"
                                                        aria-describedby="businessServiceBenefitsSix"></textarea>
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
                                                class="btn btn-danger">Submit Services Section</button>
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
                                                    <label style="font-weight: bold;" for="pricePlanOne"
                                                        class="form-label">Plan A</label>
                                                    <input type="text" name="pricePlanOne" id="pricePlanOne"
                                                        class="form-control" aria-describedby="pricePlanOne"
                                                        placeholder="Basic">
                                                    <br />
                                                    <label style="font-weight: bold;" for="pricePlanAmountOne"
                                                        class="form-label">Plan Amount</label>
                                                    <input type="text" name="pricePlanAmountOne"
                                                        id="pricePlanAmountOne" class="form-control"
                                                        aria-describedby="pricePlanAmountOne">
                                                    <br />
                                                    <label style="font-weight: bold;" for="serviceOfferOne"
                                                        class="form-label">Service Offer</label>
                                                    <textarea name="serviceOfferOne" id="serviceOfferOne" class="form-control" aria-describedby="serviceOfferOne"></textarea>
                                                    <div id="emailHelp" class="form-text">Briefly describe your business.
                                                        <span class="text-danger"><strong>150 characters</strong></span>
                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <label style="font-weight: bold;" for="pricePlanTwo"
                                                        class="form-label">Plan B</label>
                                                    <input type="text" name="pricePlanTwo" id="pricePlanTwo"
                                                        class="form-control" aria-describedby="pricePlanTwo"
                                                        placeholder="Professional">
                                                    <br />
                                                    <label style="font-weight: bold;" for="pricePlanAmountTwo"
                                                        class="form-label">Plan Amount</label>
                                                    <input type="text" name="pricePlanAmountTwo"
                                                        id="pricePlanAmountTwo" class="form-control"
                                                        aria-describedby="pricePlanAmountTwo">
                                                    <br />
                                                    <label style="font-weight: bold;" for="serviceOfferTwo"
                                                        class="form-label">Service Offer</label>
                                                    <textarea name="serviceOfferTwo" id="serviceOfferTwo" class="form-control" aria-describedby="serviceOfferTwo"></textarea>
                                                    <div id="emailHelp" class="form-text">Briefly describe your business.
                                                        <span class="text-danger"><strong>150 characters</strong></span>
                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <label style="font-weight: bold;" for="pricePlanThree"
                                                        class="form-label">Plan C</label>
                                                    <input type="text" name="pricePlanThree" id="pricePlanThree"
                                                        class="form-control" aria-describedby="pricePlanThree"
                                                        placeholder="Professional Plus">
                                                    <br />
                                                    <label style="font-weight: bold;" for="pricePlanAmountThree"
                                                        class="form-label">Plan Amount</label>
                                                    <input type="text" name="pricePlanAmountThree"
                                                        id="pricePlanAmountThree" class="form-control"
                                                        aria-describedby="pricePlanAmountThree">
                                                    <br />
                                                    <label style="font-weight: bold;" for="serviceOfferThree"
                                                        class="form-label">Service Offer</label>
                                                    <textarea name="serviceOfferThree" id="serviceOfferThree" class="form-control" aria-describedby="serviceOfferThree"></textarea>
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
                                                class="btn btn-danger">Submit Pricing Section</button>
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
                                                    <input type="file" name="testimonialImage" id="testimonialImage"
                                                        class="form-control" aria-describedby="testimonialImage">
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
                                                    <textarea name="testimonialDescription" id="testimonialDescription" class="form-control"
                                                        aria-describedby="testimonialDescription"></textarea>
                                                </div>

                                            </div>

                                        </div>

                                        <br>
                                        <div class="mb-3">
                                            <button type="button"
                                                onclick="serviceSetup('{{ Auth::id() }}', 'testimonial')"
                                                class="btn btn-danger">Submit Testimonial
                                                Section</button>
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
                                                        class="form-control" aria-describedby="contactNumber">
                                                </div>
                                                <div class="col-md-6">
                                                    <label style="font-weight: bold;" for="contactEmail"
                                                        class="form-label">Contact Email</label>
                                                    <input type="text" name="contactEmail" id="contactEmail"
                                                        class="form-control" aria-describedby="contactEmail">
                                                </div>

                                            </div>



                                        </div>

                                        <br>
                                        <div class="mb-3">
                                            <button type="button"
                                                onclick="serviceSetup('{{ Auth::id() }}', 'contact')"
                                                class="btn btn-danger">Submit Contact Section</button>
                                        </div>

                                    </form>
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
