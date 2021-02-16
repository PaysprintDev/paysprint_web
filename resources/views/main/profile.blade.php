@extends('layouts.app')

@section('title', 'Pay Organization')


@show

@section('text/css')

<style>
    .billingIns{
    margin-bottom: 10px;
}
.billingIns > input{
    padding: 20px 15px;
}
.billingIns > select{
    padding: 5px 15px;
    line-height: 10;
}
.tab-menu{
    font-weight: bold;
    color: navy;
}

.invoice{
  position: relative !important;
  top: 0 !important;
}

</style>

@show


@section('content')

    <!-- Banner area -->
    <section class="banner_area" data-stellar-background-ratio="0.5">
        <h2>Profile Details</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="#" class="active">Profile Details</a></li>
        </ol>
    </section>
    <!-- End Banner area -->

    <!-- Our Services Area -->
    <section class="our_services_tow">
        <br>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="well well-sm">
                        <div class="row">
                            <div class="col-sm-6 col-md-4">
                                <img src="{{ (Auth::user()->avatar != "") ? Auth::user()->avatar : 'https://cdn.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png' }}" alt="" class="img-rounded img-responsive" />
                            </div>
                            <div class="col-sm-6 col-md-8">
                                <h4>
                                    {{ Auth::user()->name }}</h4>
                                <small><cite title="San Francisco, USA"> <b>Location: {{ Auth::user()->city.' '.Auth::user()->state.', '.Auth::user()->country }} </b> <i class="fa fa-map-marker">
                                </i></cite></small>
                                <p>
                                    <i class="fa fa-cc"></i> <b>Account code:  {{ Auth::user()->ref_code }}</b>
                                </p>
                                <p>
                                    <i class="fa fa-envelope"></i> <b>Email: {{ Auth::user()->email }}</b>
                                </p>
                                <p>
                                    <i class="fa fa-phone"></i> <b>Phone: {{ Auth::user()->telephone }}</b>
                                </p>
                                <p>
                                    <i class="fa fa-address-book"></i> <b>Address: {{ Auth::user()->address }}</b>
                                </p>
                                
                                <p>
                                    <i class="fa fa-id-card"></i> <b>Means of Identification</b>

                                    <ul>

                                        @if (Auth::user()->nin_front != null || Auth::user()->nin_back != null)
                                        <li>Government issued photo ID: <br>
                                            <small style="font-weight: bold;"> <a href="{{ Auth::user()->nin_front }}" target="_blank">Front View</a> | <a href="{{ Auth::user()->nin_back }}" target="_blank">Back View</a></small>
                                             
                                         </li>
                                         <hr>
                                        @endif


                                        @if (Auth::user()->drivers_license_front != null || Auth::user()->drivers_license_back != null)

                                        <li>Driver's License: <br>
                                            <small style="font-weight: bold;"> <a href="{{ Auth::user()->drivers_license_front }}" target="_blank">Front View</a> | <a href="{{ Auth::user()->drivers_license_back }}" target="_blank">Back View</a> </small>
                                            
                                        </li>
                                        <hr>


                                        @endif


                                        @if (Auth::user()->international_passport_front != null || Auth::user()->international_passport_back != null)

                                        <li>International Passport: <br>
                                            <small style="font-weight: bold;"> <a href="{{ Auth::user()->international_passport_front }}" target="_blank">Front View</a> | <a href="{{ Auth::user()->international_passport_back }}" target="_blank">Back View</a></small>
                                             
                                        </li>

                                        @endif
                                        
                                        
                                        
                                    </ul>
                                </p>

                                    
                                    
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="well well-sm">
                        <div class="row">
                            <div class="col-sm-6 col-md-12">
                                <form action="#" method="post" enctype="multipart/form-data" id="formElem">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" value="{{ Auth::user()->name }}" placeholder="Your Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" class="form-control" name="email" id="email" value="{{ Auth::user()->email }}" readonly placeholder="Your Email Address">
                                    </div>
                                    <div class="form-group">
                                        <label for="telephone">Phone Number</label>
                                        <input type="tel" class="form-control" name="telephone" id="telephone" value="{{ Auth::user()->telephone }}" placeholder="Your Phone Number">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Home Address</label>
                                        <input type="text" class="form-control" name="address" id="address" value="{{ Auth::user()->address }}" placeholder="Your Home Address">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="country">Country</label>
                                                <input type="text" class="form-control" name="country" id="country" value="{{ Auth::user()->country }}" placeholder="Your Country">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="state">State/Province</label>
                                                <input type="text" class="form-control" name="state" id="state" value="{{ Auth::user()->state }}" placeholder="Your State/Province">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="city">City</label>
                                                <input type="text" class="form-control" name="city" id="city" value="{{ Auth::user()->city }}" placeholder="Your City">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <b style="color: darkorange;">Update Avatar</b>
                                        </div>
                                        <hr>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="avatar">Profile picture</label>
                                                <input type="file" class="form-control" name="avatar" id="avatar">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <b style="color: darkorange;">Upload Government issued photo ID</b>
                                        </div>
                                        <hr>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nin_front">Front</label>
                                                <input type="file" class="form-control" name="nin_front" id="nin_front">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nin_back">Back</label>
                                                <input type="file" class="form-control" name="nin_back" id="nin_back">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <b style="color: darkorange;">Upload Driver's License</b>
                                        </div>
                                        <hr>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nin_front">Front</label>
                                                <input type="file" class="form-control" name="drivers_license_front" id="drivers_license_front">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nin_back">Back</label>
                                                <input type="file" class="form-control" name="drivers_license_back" id="drivers_license_back">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <b style="color: darkorange;">Upload International Passport</b>
                                        </div>
                                        <hr>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nin_front">Front</label>
                                                <input type="file" class="form-control" name="international_passport_front" id="international_passport_front">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nin_back">Back</label>
                                                <input type="file" class="form-control" name="international_passport_back" id="international_passport_back">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <button type="button" onclick="handShake('updateprofile')" class="btn btn-primary btn-block" id="updateBtn">Update Profile</button>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </section>
    <!-- End Our Services Area -->


@endsection
