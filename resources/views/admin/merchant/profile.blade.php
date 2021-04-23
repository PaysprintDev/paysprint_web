@extends('layouts.dashboard')


@section('dashContent')

<?php use \App\Http\Controllers\ClientInfo; ?>
<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\InvoicePayment; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        My Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">My Profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" @if($data['getuserDetail']->avatar != null || $data['getuserDetail']->avatar != "") src="{{ $data['getuserDetail']->avatar }}"  @else src="https://res.cloudinary.com/pilstech/image/upload/v1618251695/paysprint_icon_new_kg2h3j.png" @endif alt="User profile picture">

              <h3 class="profile-username text-center">{{ $data['getuserDetail']->name }}</h3>

              <p class="text-muted text-center">{{ $data['getuserDetail']->accountType }} Account</p>

              {{--  <input type="file" name="avatar" class="form-control" id="avatar">  --}}
              {{--  <br>  --}}
              {{--  <a style="cursor: pointer;" onclick="uploadAvatar()" class="btn btn-primary btn-block" id="uploadingavatar"><b>Upload Profile Picture</b></a>  --}}
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              {{-- <li class="active"><a href="#timeline" data-toggle="tab">Timeline</a></li> --}}
              <li class="active"><a href="#business" data-toggle="tab">Business Information</a></li>
              <li><a href="#settings" data-toggle="tab">Personal Information</a></li>
              <li><a href="#myconnection" data-toggle="tab">Transaction Pin</a></li>
              <li><a href="#myreferral" data-toggle="tab">Password</a></li>
              <li><a href="#accountsettings" data-toggle="tab">Security</a></li>
              {{--  <li><a href="#accountsettings" data-toggle="tab">Auto Deposit</a></li>  --}}
            </ul>


            <div class="tab-content">

             

              <div class="active tab-pane" id="business">
                <form action="#" method="post" class="form-horizontal" id="formElemBusinessProfile">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Business</label>

                    <div class="col-sm-10">

                        
                      <input type="text" class="form-control" name="businessName" value="{{ $data['getbusinessDetail']->business_name }}" placeholder="Business Name" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Address</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="businessAddress" value="{{ $data['getbusinessDetail']->address }}" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Corporation</label>

                    <div class="col-sm-10">
                      <select name="corporate_type" id="corporate_type" class="form-control">
                            <option value="">Select Corporation Type</option>
                            <option value="Sole Proprietorship" {{ ($data['getbusinessDetail']->corporate_type == "Sole Proprietorship") ? 'selected' : '' }} >Sole Proprietorship</option>
                            <option value="Partnership" {{ ($data['getbusinessDetail']->corporate_type == "Partnership") ? 'selected' : '' }} >Partnership</option>
                            <option value="Limited Liability Company" {{ ($data['getbusinessDetail']->corporate_type == "Limited Liability Company") ? 'selected' : '' }} >Limited Liability Company</option>
                            <option value="Public Company" {{ ($data['getbusinessDetail']->corporate_type == "Public Company") ? 'selected' : '' }} >Public Company</option>
                            <option value="Trust and Estate" {{ ($data['getbusinessDetail']->corporate_type == "Trust and Estate") ? 'selected' : '' }} >Trust and Estate</option>
                        </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Industry</label>

                    <div class="col-sm-10">
                      <select name="industry" id="industry" class="form-control">
          <option value="">Select Industry</option>
          <option value="{{ $data['getbusinessDetail']->industry }}" selected>{{ $data['getbusinessDetail']->industry }}</option>
          <option value="Accounting">Accounting</option>
<option value="Airlines/Aviation">Airlines/Aviation</option>
<option value="Alternative Dispute Resolution">Alternative Dispute Resolution</option>
<option value="Alternative Medicine">Alternative Medicine</option>
<option value="Animation">Animation</option>
<option value="Apparel/Fashion">Apparel/Fashion</option>
<option value="Architecture/Planning">Architecture/Planning</option>
<option value="Arts/Crafts">Arts/Crafts</option>
<option value="Automotive">Automotive</option>
<option value="Aviation/Aerospace">Aviation/Aerospace</option>
<option value="Banking/Mortgage">Banking/Mortgage</option>
<option value="Biotechnology/Greentech">Biotechnology/Greentech</option>
<option value="Broadcast Media">Broadcast Media</option>
<option value="Building Materials">Building Materials</option>
<option value="Business Supplies/Equipment">Business Supplies/Equipment</option>
<option value="Capital Markets/Hedge Fund/Private Equity">Capital Markets/Hedge Fund/Private Equity</option>
<option value="Chemicals">Chemicals</option>
<option value="Civic/Social Organization">Civic/Social Organization</option>
<option value="Civil Engineering">Civil Engineering</option>
<option value="Commercial Real Estate">Commercial Real Estate</option>
<option value="Computer Games">Computer Games</option>
<option value="Computer Hardware">Computer Hardware</option>
<option value="Computer Networking">Computer Networking</option>
<option value="Computer Software/Engineering">Computer Software/Engineering</option>
<option value="Computer/Network Security">Computer/Network Security</option>
<option value="Construction">Construction</option>
<option value="Consumer Electronics">Consumer Electronics</option>
<option value="Consumer Goods">Consumer Goods</option>
<option value="Consumer Services">Consumer Services</option>
<option value="Cosmetics">Cosmetics</option>
<option value="Dairy">Dairy</option>
<option value="Defense/Space">Defense/Space</option>
<option value="Design">Design</option>
<option value="E-Learning">E-Learning</option>
<option value="Education Management">Education Management</option>
<option value="Electrical/Electronic Manufacturing">Electrical/Electronic Manufacturing</option>
<option value="Entertainment/Movie Production">Entertainment/Movie Production</option>
<option value="Environmental Services">Environmental Services</option>
<option value="Events Services">Events Services</option>
<option value="Executive Office">Executive Office</option>
<option value="Facilities Services">Facilities Services</option>
<option value="Farming">Farming</option>
<option value="Financial Services">Financial Services</option>
<option value="Fine Art">Fine Art</option>
<option value="Fishery">Fishery</option>
<option value="Food Production">Food Production</option>
<option value="Food/Beverages">Food/Beverages</option>
<option value="Fundraising">Fundraising</option>
<option value="Furniture">Furniture</option>
<option value="Gambling/Casinos">Gambling/Casinos</option>
<option value="Glass/Ceramics/Concrete">Glass/Ceramics/Concrete</option>
<option value="Government Administration">Government Administration</option>
<option value="Government Relations">Government Relations</option>
<option value="Graphic Design/Web Design">Graphic Design/Web Design</option>
<option value="Health/Fitness">Health/Fitness</option>
<option value="Higher Education/Acadamia">Higher Education/Acadamia</option>
<option value="Hospital/Health Care">Hospital/Health Care</option>
<option value="Hospitality">Hospitality</option>
<option value="Human Resources/HR">Human Resources/HR</option>
<option value="Import/Export">Import/Export</option>
<option value="Individual/Family Services">Individual/Family Services</option>
<option value="Industrial Automation">Industrial Automation</option>
<option value="Information Services">Information Services</option>
<option value="Information Technology/IT">Information Technology/IT</option>
<option value="Insurance">Insurance</option>
<option value="International Affairs">International Affairs</option>
<option value="International Trade/Development">International Trade/Development</option>
<option value="Internet">Internet</option>
<option value="Investment Banking/Venture">Investment Banking/Venture</option>
<option value="Investment Management/Hedge Fund/Private Equity">Investment Management/Hedge Fund/Private Equity</option>
<option value="Judiciary">Judiciary</option>
<option value="Law Enforcement">Law Enforcement</option>
<option value="Law Practice/Law Firms">Law Practice/Law Firms</option>
<option value="Legal Services">Legal Services</option>
<option value="Legislative Office">Legislative Office</option>
<option value="Leisure/Travel">Leisure/Travel</option>
<option value="Library">Library</option>
<option value="Logistics/Procurement">Logistics/Procurement</option>
<option value="Luxury Goods/Jewelry">Luxury Goods/Jewelry</option>
<option value="Machinery">Machinery</option>
<option value="Management Consulting">Management Consulting</option>
<option value="Maritime">Maritime</option>
<option value="Market Research">Market Research</option>
<option value="Marketing/Advertising/Sales">Marketing/Advertising/Sales</option>
<option value="Mechanical or Industrial Engineering">Mechanical or Industrial Engineering</option>
<option value="Media Production">Media Production</option>
<option value="Medical Equipment">Medical Equipment</option>
<option value="Medical Practice">Medical Practice</option>
<option value="Mental Health Care">Mental Health Care</option>
<option value="Military Industry">Military Industry</option>
<option value="Mining/Metals">Mining/Metals</option>
<option value="Motion Pictures/Film">Motion Pictures/Film</option>
<option value="Museums/Institutions">Museums/Institutions</option>
<option value="Music">Music</option>
<option value="Nanotechnology">Nanotechnology</option>
<option value="Newspapers/Journalism">Newspapers/Journalism</option>
<option value="Non-Profit/Volunteering">Non-Profit/Volunteering</option>
<option value="Oil/Energy/Solar/Greentech">Oil/Energy/Solar/Greentech</option>
<option value="Online Publishing">Online Publishing</option>
<option value="Other Industry">Other Industry</option>
<option value="Outsourcing/Offshoring">Outsourcing/Offshoring</option>
<option value="Package/Freight Delivery">Package/Freight Delivery</option>
<option value="Packaging/Containers">Packaging/Containers</option>
<option value="Paper/Forest Products">Paper/Forest Products</option>
<option value="Performing Arts">Performing Arts</option>
<option value="Pharmaceuticals">Pharmaceuticals</option>
<option value="Philanthropy">Philanthropy</option>
<option value="Photography">Photography</option>
<option value="Plastics">Plastics</option>
<option value="Political Organization">Political Organization</option>
<option value="Primary/Secondary Education">Primary/Secondary Education</option>
<option value="Printing">Printing</option>
<option value="Professional Training">Professional Training</option>
<option value="Program Development">Program Development</option>
<option value="Public Relations/PR">Public Relations/PR</option>
<option value="Public Safety">Public Safety</option>
<option value="Publishing Industry">Publishing Industry</option>
<option value="Railroad Manufacture">Railroad Manufacture</option>
<option value="Ranching">Ranching</option>
<option value="Real Estate/Mortgage">Real Estate/Mortgage</option>
<option value="Recreational Facilities/Services">Recreational Facilities/Services</option>
<option value="Religious Institutions">Religious Institutions</option>
<option value="Renewables/Environment">Renewables/Environment</option>
<option value="Research Industry">Research Industry</option>
<option value="Restaurants">Restaurants</option>
<option value="Retail Industry">Retail Industry</option>
<option value="Security/Investigations">Security/Investigations</option>
<option value="Semiconductors">Semiconductors</option>
<option value="Shipbuilding">Shipbuilding</option>
<option value="Sporting Goods">Sporting Goods</option>
<option value="Sports">Sports</option>
<option value="Staffing/Recruiting">Staffing/Recruiting</option>
<option value="Supermarkets">Supermarkets</option>
<option value="Telecommunications">Telecommunications</option>
<option value="Textiles">Textiles</option>
<option value="Think Tanks">Think Tanks</option>
<option value="Tobacco">Tobacco</option>
<option value="Translation/Localization">Translation/Localization</option>
<option value="Transportation">Transportation</option>
<option value="Utilities">Utilities</option>
<option value="Venture Capital/VC">Venture Capital/VC</option>
<option value="Veterinary">Veterinary</option>
<option value="Warehousing">Warehousing</option>
<option value="Wholesale">Wholesale</option>
<option value="Wine/Spirits">Wine/Spirits</option>
<option value="Wireless">Wireless</option>
<option value="Writing/Editing">Writing/Editing</option>
        </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputWebsite" class="col-sm-2 control-label">Website</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="businessWebsite" value="{{ $data['getbusinessDetail']->website }}" placeholder="www.example.com">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputCorporationDocument" class="col-sm-2 control-label">Document</label>

                    <div class="col-sm-5">
                      <input type="file" class="form-control" name="incorporation_doc_front">
                    <small class="text-danger"><strong>Incorporation document (FRONT)</strong></small>

                    </div>
                    <div class="col-sm-5">
                      <input type="file" class="form-control" name="incorporation_doc_back">
                    <small class="text-danger"><strong>Incorporation document (BACK)</strong></small>

                    </div>
                  </div>
                  

                  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="button" class="btn btn-primary btn-block" onclick="handShake('merchantbusiness')" id="updatemyBusinessProfile">Update Business</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->


              <div class="tab-pane" id="settings">
                <form action="#" method="post" class="form-horizontal" id="formElemProfile">
                  
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="name" value="{{ $data['getuserDetail']->name }}" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" name="email" value="{{ $data['getuserDetail']->email }}" readonly="" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Address</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="address" value="{{ $data['getuserDetail']->address }}" placeholder="Address">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Telephone</label>

                    <div class="col-sm-10">
                      <input type="number" class="form-control" name="telephone" placeholder="Telephone" value="{{ $data['getuserDetail']->telephone }}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Country</label>

                    <div class="col-sm-10">
                      <select class="form-control" name="country" readonly>
                        <option selected="" value="{{ $data['getuserDetail']->country }}">{{ $data['getuserDetail']->country }}</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">State</label>

                    <div class="col-sm-10">
                      <select class="form-control" name="state">
                        <option selected="" value="{{ $data['getuserDetail']->state }}">{{ $data['getuserDetail']->state }}</option>
                      </select>
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">City</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="city" placeholder="City" value="{{ $data['getuserDetail']->city }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Postal Code</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="zip" placeholder="Zip Code" value="{{ $data['getuserDetail']->zip }}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputPhotoId" class="col-sm-2 control-label">Profile Pic.</label>

                    <div class="col-sm-10">
                      <input type="file" name="avatar" class="form-control">
                    </div>
                    
                  </div>

                  <div class="form-group">
                    <label for="inputPhotoId" class="col-sm-2 control-label">Photo ID</label>

                    <div class="col-sm-5">
                      <input type="file" class="form-control" name="nin_front">
                      <small class="text-danger"><strong>Government issued photo ID (FRONT)</strong></small>
                    </div>
                    <div class="col-sm-5">
                      <input type="file" class="form-control" name="nin_back">
                      <small class="text-danger"><strong>Government issued photo ID (BACK)</strong></small>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputLicense" class="col-sm-2 control-label">License</label>

                    <div class="col-sm-5">
                      <input type="file" class="form-control" name="drivers_license_front">
                      <small class="text-danger"><strong>Upload Driver's License (FRONT)</strong></small>
                    </div>
                    <div class="col-sm-5">
                      <input type="file" class="form-control" name="drivers_license_back">
                      <small class="text-danger"><strong>Upload Driver's License (BACK)</strong></small>
                    </div>
                  </div>


                  <div class="form-group">
                    <label for="inputPassport" class="col-sm-2 control-label">Passport</label>

                    <div class="col-sm-5">
                      <input type="file" class="form-control" name="international_passport_front">
                      <small class="text-danger"><strong>Upload International Passport (FRONT)</strong></small>
                    </div>
                    <div class="col-sm-5">
                      <input type="file" class="form-control" name="international_passport_back">
                      <small class="text-danger"><strong>Upload International Passport (BACK)</strong></small>
                    </div>
                  </div>

                  


                  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="button" class="btn btn-primary btn-block" onclick="handShake('merchantprofile')" id="updatemyProfile">Update Profile</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->



               <!-- /.tab-pane -->
              <div class="tab-pane" id="myconnection">
                    @if ($data['getuserDetail']->transaction_pin != null)

                        <form action="#" method="post" id="formElemtransactionpinsettings">
                            
                            <div class="form-group">
                                <label for="oldpin">Old Pin <strong><p class="text-danger" style="cursor: pointer;" onclick="resetPin('{{ $data['getuserDetail']->securityQuestion }}','transaction')">Have you forgotten your old transaction pin? <span style="text-decoration: underline;">Click here to reset</span></p></strong></label>
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
              <!-- /.tab-pane -->



              <!-- /.tab-pane -->
              <div class="tab-pane" id="myreferral">
                  <form action="#" method="post" id="formElempasswordsettings">

                        <div class="form-group">
                            <label for="oldpassword">Old Password <strong><p class="text-danger" style="cursor: pointer;" onclick="resetPin('{{ $data['getuserDetail']->securityQuestion }}','password')">Have you forgotten your old password? <span style="text-decoration: underline;">Click here to reset</span></p></strong></label>
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
              <!-- /.tab-pane -->

              <!-- /.tab-pane -->
              <div class="tab-pane" id="accountsettings">

                <h5 >
                    <strong>Security Question: <span style="color: red">{{ $data['getuserDetail']->securityQuestion }}?</span></strong>
                </h5>
                <hr>

                  <form action="#" method="post" id="formElemsecurityquestans">
                    <div class="form-group">
                        <label for="securityQuestion">Question</label>
                        <input type="text" name="securityQuestion" id="securityQuestion" class="form-control" placeholder="Question">
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
              <!-- /.tab-pane -->




            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>

  @include('include.modal')

@endsection
