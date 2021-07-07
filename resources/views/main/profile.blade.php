@extends('layouts.app')

@section('title', 'Profile')


@show
<?php use \App\Http\Controllers\LinkAccount; ?>
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
.notificationImage{
    margin-top: 0px;
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
                                <a href="{{ Auth::user()->avatar }}" target="_blank"><img src="{{ (Auth::user()->avatar != "") ? Auth::user()->avatar : 'https://cdn.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png' }}" alt="" class="img-rounded img-responsive" style="height: 150px; width: 150px; border-radius: 100%;" /></a>
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
                                    <i class="fa fa-user"></i> <b>Account Type:  {{ Auth::user()->accountType." account" }}</b>
                                </p>
                                <p>
                                    <i class="fa fa-envelope"></i> <b>Email: {{ Auth::user()->email }}</b>
                                </p>
                                <p>
                                    <i class="fa fa-phone"></i> <b>Phone: {{ Auth::user()->telephone }}</b>
                                </p>
                                <p>
                                    <i class="fa fa-address-book"></i> <b>Address: {{ Auth::user()->address.', '.Auth::user()->city.' '.Auth::user()->state.' '.Auth::user()->country }}</b>
                                </p>
                                
                                <p>
                                    <i class="fa fa-id-card"></i> <b>Means of Identification</b>

                                    <ul>

                                        @if (Auth::user()->nin_front != null || Auth::user()->nin_back != null)
                                        <li style="font-weight: bold;">Government issued photo ID: <br>
                                            <small style="font-weight: bold;"> <a href="{{ Auth::user()->nin_front }}" target="_blank">Front View</a> | <a href="{{ Auth::user()->nin_back }}" target="_blank">Back View</a></small>
                                             
                                         </li>
                                        @endif
                                         <br>

                                        @if (Auth::user()->drivers_license_front != null || Auth::user()->drivers_license_back != null)

                                        <li style="font-weight: bold;">Driver's License: <br>
                                            <small style="font-weight: bold;"> <a href="{{ Auth::user()->drivers_license_front }}" target="_blank">Front View</a> | <a href="{{ Auth::user()->drivers_license_back }}" target="_blank">Back View</a> </small>
                                            
                                        </li>


                                        @endif
                                        <br>

                                        @if (Auth::user()->international_passport_front != null || Auth::user()->international_passport_back != null)

                                        <li style="font-weight: bold;">International Passport: <br>
                                            <small style="font-weight: bold;"> <a href="{{ Auth::user()->international_passport_front }}" target="_blank">Front View</a> | <a href="{{ Auth::user()->international_passport_back }}" target="_blank">Back View</a></small>
                                             
                                        </li>

                                        @endif
                                        <br>

                                        @if (Auth::user()->incorporation_doc_front != null)

                                        <li style="font-weight: bold;">Document: <br>
                                            <small style="font-weight: bold;"> <a href="{{ Auth::user()->incorporation_doc_front }}" target="_blank">View document</a></small>
                                            
                                        </li>

                                        @endif
                                        
                                        
                                        
                                    </ul>
                                </p>

                                    
                                    
                                
                            </div>
                            
                        </div>

                        
                    </div>

                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Transaction Pin Settings
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">

        @if (Auth::user()->transaction_pin != null)

        <form action="#" method="post" id="formElemtransactionpinsettings">
            
            <div class="form-group">
                <label for="oldpin">Old Pin <strong><p class="text-danger" style="cursor: pointer;" onclick="resetPin('{{ Auth::user()->securityQuestion }}','transaction')">Have you forgotten your old transaction pin? Click here to reset</p></strong></label>
                <input type="password" name="oldpin" id="oldpin" class="form-control" placeholder="Pin" maxlength="4">
            </div>
            <div class="form-group">
                <label for="newpin">New Pin</label>
                <input type="password" name="newpin" id="newpin" class="form-control" placeholder="New Pin" maxlength="4">
            </div>
            <div class="form-group">
                <label for="confirmpin">Confirm Pin</label>
                <input type="password" name="confirmpin" id="confirmpin" class="form-control" placeholder="Confirm Pin" maxlength="4">
            </div>
            
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-block" id="transactionBtn" onclick="handShake('transactionpinsettings')">Save</button>
            </div>

        </form>
            
        @else

        <form action="#" method="post" id="formElemnewtransactionpinsettings">
            
            <div class="form-group">
                <label for="newpin">New Pin</label>
                <input type="password" name="newpin" id="newpin" class="form-control" placeholder="New Pin" maxlength="4">
            </div>
            <div class="form-group">
                <label for="confirmpin">Confirm Pin</label>
                <input type="password" name="confirmpin" id="confirmpin" class="form-control" placeholder="Confirm Pin" maxlength="4">
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-block" id="transactionBtn" onclick="handShake('newtransactionpinsettings')">Save</button>
            </div>

        </form>
            
        @endif

        



      </div>
    </div>
  </div>

  @if (Auth::user()->country == "Nigeria")

  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingSeven">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
          BVN Verification {!! (Auth::user()->bvn_verification == 1) ? '<img src="https://img.icons8.com/fluent/25/000000/verified-account.png"/>' : ""  !!}
        </a>
      </h4>
    </div>
    <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
      <div class="panel-body">
        <form action="#" method="post" id="formElembvnverification">

            <div class="form-group">
                <label for="bvn">Bank Verification Number @if(Auth::user()->bvn_number == null) <strong><p class="text-warning" style="cursor: pointer;">Enter your bank verification number</p></strong> @endif</label>
                <input type="number" name="bvn" id="bvn" class="form-control" @if(Auth::user()->bvn_number != null) value="{{ Auth::user()->bvn_number }}" readonly @else placeholder="BVN" @endif >
            </div>

            @if (Auth::user()->bvn_number == null)

            <div class="form-group">
                    <label for="account_number">Bank Account Number <strong><p class="text-warning" style="cursor: pointer;">Enter your bank account number</p></strong></label>
                    <input type="number" name="account_number" id="account_number" class="form-control" placeholder="Account Number">
                </div>

                <div class="form-group">
                    <label for="bank_code">Select Bank <strong><p class="text-warning" style="cursor: pointer;">Select your bank</p></strong></label>
                    <select name="bank_code" id="bank_code" class="form-control">

                        @if (count($data['listbank']) > 0)
                        <option value="">Select your bank</option>
                            @foreach ($data['listbank'] as $banksData)
                                <option value="{{ $banksData->code }}">{{ $banksData->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                


                <div class="form-group">
                    <label for="account_name">Account Name</label>
                    <input type="text" name="account_name" id="account_name" class="form-control" value="" readonly>
                </div>
                
                
                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-block" id="passwordBtn" onclick="handShake('bvnverification')">Save</button>
                </div>

            @endif

            

        </form>
      </div>
    </div>
  </div>
      
  @endif

  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Password Settings
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
        <form action="#" method="post" id="formElempasswordsettings">


            <div class="form-group">
                <label for="oldpassword">Old Password <strong><p class="text-danger" style="cursor: pointer;" onclick="resetPin('{{ Auth::user()->securityQuestion }}','password')">Have you forgotten your old password? Click here to reset</p></strong></label>
                <input type="password" name="oldpassword" id="oldpassword" class="form-control" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="newpin">New Password</label>
                <input type="password" name="newpassword" id="newpassword" class="form-control" placeholder="New Password">
            </div>
            <div class="form-group">
                <label for="confirmpin">Confirm Password</label>
                <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Confirm Password">
            </div>
            
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-block" id="passwordBtn" onclick="handShake('passwordsettings')">Save</button>
            </div>

        </form>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Security Question and Answer
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="panel-body">

        <h5 >
            <strong>Security Question: <span style="color: red">{{ Auth::user()->securityQuestion }}</span></strong>
        </h5>
        <hr>
        <form action="#" method="post" id="formElemsecurityquestans">

            <div class="form-group">
                <label for="securityQuestion">Question</label>
                <select name="securityQuestion" id="securityQuestion" class="form-control">
                    <option value="">Select Question</option>
                    <option value="What was your first pet's name?" {{ (Auth::user()->securityQuestion == "What was your first pet's name?") ? "selected" : "" }}>What was your first pet's name?</option>
                    <option value="What's the name of the city where you were born?" {{ (Auth::user()->securityQuestion == "What's the name of the city where you were born?") ? "selected" : "" }}>What's the name of the city where you were born?</option>
                    <option value="What was your childhood nickname?" {{ (Auth::user()->securityQuestion == "What was your childhood nickname?") ? "selected" : "" }}>What was your childhood nickname?</option>
                    <option value="What's the name of the city where your parents met?" {{ (Auth::user()->securityQuestion == "What's the name of the city where your parents met?") ? "selected" : "" }}>What's the name of the city where your parents met?</option>
                    <option value="What's the first name of your oldest cousin?" {{ (Auth::user()->securityQuestion == "What's the first name of your oldest cousin?") ? "selected" : "" }}>What's the first name of your oldest cousin?</option>
                    <option value="What's the name of the first school you attended?" {{ (Auth::user()->securityQuestion == "What's the name of the first school you attended?") ? "selected" : "" }}>What's the name of the first school you attended?</option>
                </select>

                {{--  <input type="text" name="securityQuestion" id="securityQuestion" class="form-control" placeholder="Question">  --}}
            </div>
            <div class="form-group">
                <label for="securityAnswer">Answer</label>
                <input type="text" name="securityAnswer" id="securityAnswer" class="form-control" placeholder="Answer">
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-block" id="securityBtn" onclick="handShake('securityquestans')">Save</button>
            </div>

        </form>
      </div>
    </div>
  </div>


  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingFour">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
          Turn Off Auto Deposit
        </a>
      </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
      <div class="panel-body">

        <h5 >
            <strong>Status: <span style="color: {{ (Auth::user()->auto_deposit == 'on' ? 'green' : 'red') }}">{{ strtoupper(Auth::user()->auto_deposit) }}</span></strong>
        </h5>
        <hr>
        <form action="#" method="post" id="formElemautodeposit">

            <div class="form-group">
                <label for="securityQuestion">Change Status</label>
                <select name="auto_deposit" id="auto_deposit" class="form-control">
                    <option value="on" {{ (Auth::user()->auto_deposit == 'on' ? 'selected' : '') }}>ON</option>
                    <option value="off" {{ (Auth::user()->auto_deposit == 'off' ? 'selected' : '') }}>OFF</option>
                </select>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-block" id="autodepositBtn" onclick="handShake('autodeposit')">Save</button>
            </div>

        </form>
      </div>
    </div>
  </div>


    <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingSix">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
          Link Other Accounts
        </a>
      </h4>
    </div>
    <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
      <div class="panel-body">
        <form action="#" method="post" id="formElemlinkaccount">

            <div class="form-group">
                <label for="account_number">Account Number</label><br>
                <small style="color: red; font-weight: 700;">Kindly enter the PS account number to link</small>
                <input type="text" name="account_number" id="link_account_number" class="form-control" placeholder="E.g 69212">
            </div>
            
            <div class="form-group">
                <label for="transaction_pin">Transaction Pin</label><br>
                <small style="color: red; font-weight: 700;">Kindly provide transaction pin of the account to link</small>
                <input type="password" name="transaction_pin" id="link_transaction_pin" class="form-control">
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-block" id="linkaccountBtn" onclick="handShake('linkaccount')">Submit</button>
            </div>

        </form>
      </div>
    </div>
  </div>



  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingFive">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
          Switch to Other Account
        </a>
      </h4>
    </div>
    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
      <div class="panel-body">

        <form action="#" method="post" id="formElemotheraccount">

            <div class="form-group">
                <label for="account_number">Select Other Accounts</label>

                <select name="account_number" id="other_account_number" class="form-control">

                    @php
                        $account = \App\LinkAccount::where('ref_code', Auth::user()->ref_code)->get();
                    @endphp

                    @if(count($account) > 0)
                        <option value="">Select account number</option>
                        @foreach ($account as $item)
                            <option value="{{ $item->link_ref_code }}">{{ $item->link_ref_code }}</option>
                        @endforeach
                    @else
                        
                        @php
                            $account = \App\LinkAccount::where('link_ref_code', Auth::user()->ref_code)->get();
                        @endphp

                        @if(count($account) > 0)

                            <option value="">Select account number</option>
                            @foreach ($account as $item)
                                <option value="{{ $item->ref_code }}">{{ $item->ref_code }}</option>
                            @endforeach

                            @else

                            <option value="">You have not linked an account yet</option>
                        
                        @endif
                    @endif
                    
                </select>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-block" id="otheraccountBtn" onclick="handShake('otheraccount')">Submit</button>
            </div>

        </form>
      </div>
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
                                        <input type="text" class="form-control" name="name" id="name" value="{{ Auth::user()->name }}" placeholder="Your Name" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" class="form-control" name="email" id="email" value="{{ Auth::user()->email }}" readonly placeholder="Your Email Address">
                                    </div>
                                    <div class="form-group">
                                        <label for="telephone">Phone Number</label>
                                        <input type="tel" class="form-control" name="telephone" id="telephone" value="{{ Auth::user()->telephone }}" placeholder="Your Phone Number" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dayOfBirth">Day of Birth</label>

                                                <select name="dayOfBirth" id="dayOfBirth" class="form-control" required>
                                                    @for ($i = 1; $i <= 31; $i++)
                                                        <option value="{{ $i }}" {{ (Auth::user()->dayOfBirth == $i) ? "selected" : "" }}>{{ $i }}</option>
                                                    @endfor
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="state">Month of Birth</label>
                                                <select name="monthOfBirth" id="monthOfBirth" class="form-control" required>
                                                        <option selected value='1' {{ (Auth::user()->monthOfBirth == 1) ? "selected" : "" }}>January</option>
                                                        <option value='2' {{ (Auth::user()->monthOfBirth == 2) ? "selected" : "" }}>February</option>
                                                        <option value='3' {{ (Auth::user()->monthOfBirth == 3) ? "selected" : "" }}>March</option>
                                                        <option value='4' {{ (Auth::user()->monthOfBirth == 4) ? "selected" : "" }}>April</option>
                                                        <option value='5' {{ (Auth::user()->monthOfBirth == 5) ? "selected" : "" }}>May</option>
                                                        <option value='6' {{ (Auth::user()->monthOfBirth == 6) ? "selected" : "" }}>June</option>
                                                        <option value='7' {{ (Auth::user()->monthOfBirth == 7) ? "selected" : "" }}>July</option>
                                                        <option value='8' {{ (Auth::user()->monthOfBirth == 8) ? "selected" : "" }}>August</option>
                                                        <option value='9' {{ (Auth::user()->monthOfBirth == 9) ? "selected" : "" }}>September</option>
                                                        <option value='10' {{ (Auth::user()->monthOfBirth == 10) ? "selected" : "" }}>October</option>
                                                        <option value='11' {{ (Auth::user()->monthOfBirth == 11) ? "selected" : "" }}>November</option>
                                                        <option value='12' {{ (Auth::user()->monthOfBirth == 12) ? "selected" : "" }}>December</option>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="yearOfBirth">Year of Birth</label>
                                                <select name="yearOfBirth" id="yearOfBirth" class="form-control">
                                                    @for ($i = 1900; $i <= date('Y'); $i++)
                                                        <option value="{{ $i }}" {{ (Auth::user()->yearOfBirth == $i) ? "selected" : "" }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address">Home Address</label>
                                        <input type="text" class="form-control" name="address" id="address" value="{{ Auth::user()->address }}" placeholder="Your Home Address" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="country">Country</label>
                                                {{-- <select id="thiscountry" class="form-control" required>
                                                    <option value="{{ Auth::user()->country }}" selected>{{ Auth::user()->country }}</option>
                                                </select> --}}
                                                <input type="text" class="form-control" name="country" id="country" value="{{ Auth::user()->country }}" placeholder="Your Country" required readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="state">State/Province</label>
                                                {{-- <input type="text" class="form-control" name="state" id="state" value="{{ Auth::user()->state }}" placeholder="Your State/Province"> --}}
                                                <select name="state" id="state" class="form-control" required>
                                                    <option value="{{ Auth::user()->state }}" selected>{{ Auth::user()->state }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="city">City</label>
                                                <input type="text" class="form-control" name="city" id="city" value="{{ Auth::user()->city }}" placeholder="Your City" required>
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


                                        <div class="row">
                                        <div class="col-md-12">
                                            <b style="color: darkorange;">Upload Document</b>
                                        </div>
                                        <hr>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="incorporation_doc_front">Document</label>
                                                <input type="file" class="form-control" name="incorporation_doc_front" id="incorporation_doc_front">
                                            </div>
                                        </div>
                                        {{--  <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nin_back">Back</label>
                                                <input type="file" class="form-control" name="incorporation_doc_back" id="incorporation_doc_back">
                                            </div>
                                        </div>  --}}
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
