@extends('layouts.merch.merchant-dashboard')


@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <h3>Edit Profile</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href={{ route('dashboard') }}>Dashboard</a></li>

                            <li class="breadcrumb-item active">Edit Profile</li>
                        </ol>
                    </div>
                    <div class="col-lg-6">
                        <!-- Bookmark Start-->

                        <!-- Bookmark Ends-->
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="edit-profile">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h4 class="card-title mb-0">My Profile</h4>
                                <div class="card-options">
                                    <a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i
                                            class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#"
                                        data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row mb-2">
                                        <div class="profile-title">
                                            <div class="media">
                                                <img class="img-70 rounded-circle" alt=""
                                                    src="../assets/images/user/01.jpg" />
                                                <div class="media-body">
                                                    <h3 class="mb-1 f-20 txt-primary">DOUBLE MAJOR</h3>
                                                    <p class="f-12">MUSIC PRODUCER, WEB DESIGNER</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div style="width: 100%;">
                                            <div class="card-header"
                                                style="background-color: #f6b60b; padding: 10px; font-weight: bold; border-radius: 10px 10px 0px 0px;">
                                                Quick Wallet Setup

                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"
                                                    title="Upload Government issued photo ID e.g National ID, International Passport, Driver Licence">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <a href="{{ route('profile') }}">Identity
                                                                Verification</a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img
                                                                src='https://img.icons8.com/fluent/20/000000/check-all.png' />
                                                        </div>
                                                    </div>

                                                </li>
                                                <li class="list-group-item"
                                                    title="To add money to your wallet, you need to add a credit/debit card to your account">

                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <a href="#">Add
                                                                Card/Bank Account </a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img
                                                                src='https://img.icons8.com/fluent/20/000000/check-all.png' />
                                                        </div>
                                                    </div>


                                                </li>
                                                <li class="list-group-item"
                                                    title="Setup transaction pin for security purpose">

                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <a href="{{ route('profile') }}">Set Transaction Pin
                                                            </a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img
                                                                src='https://img.icons8.com/fluent/20/000000/check-all.png' />
                                                        </div>
                                                    </div>


                                                </li>
                                                <li class="list-group-item"
                                                    title="Setup transaction pin for security purpose">

                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <a href="{{ route('profile') }}">Set Security
                                                                Question </a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img
                                                                src='https://img.icons8.com/fluent/20/000000/check-all.png' />
                                                        </div>
                                                    </div>



                                                </li>



                                                <li class="list-group-item" title="Bank Verification (BVN)">

                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <a href="{{ route('profile') }}">Bank
                                                                Verification (BVN) </a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img
                                                                src='https://img.icons8.com/fluent/20/000000/check-all.png' />
                                                        </div>
                                                    </div>



                                                </li>




                                                <li class="list-group-item" title="Set Up Tax">

                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <a href="{{ route('set up tax') }}">Set Up Tax </a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img
                                                                src='https://img.icons8.com/fluent/20/000000/check-all.png' />
                                                        </div>
                                                    </div>



                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div style="width: auto;">
                                            <div class="card-header"
                                                style="background-color: green; color: white; padding: 10px; font-weight: bold; border-radius: 10px 10px 0px 0px;">
                                                Required Documents

                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item" title="Articles of Incorporation">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <a href="{{ route('profile') }}">Articles of
                                                                Incorporation</a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img
                                                                src='https://img.icons8.com/fluent/20/000000/check-all.png' />
                                                        </div>
                                                    </div>

                                                </li>
                                                <li class="list-group-item" title="Register of Directors">

                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <a href="{{ route('profile') }}">Register of
                                                                Directors</a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img
                                                                src='https://img.icons8.com/fluent/20/000000/check-all.png' />
                                                        </div>
                                                    </div>


                                                </li>
                                                <li class="list-group-item" title="Register of Shareholders">

                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <a href="{{ route('profile') }}">Register of
                                                                Shareholders</a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img
                                                                src='https://img.icons8.com/fluent/20/000000/check-all.png' />
                                                        </div>
                                                    </div>


                                                </li>
                                                <li class="list-group-item" title="Proof of Identity - 1 Director">

                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <a href="{{ route('profile') }}">Proof of Identity -
                                                                1 Director</a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img
                                                                src='https://img.icons8.com/fluent/20/000000/check-all.png' />
                                                        </div>
                                                    </div>



                                                </li>


                                                <li class="list-group-item" title="Proof of Identity - 1 UBO">

                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <a href="{{ route('profile') }}">Proof of Identity -
                                                                1 UBO</a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img
                                                                src='https://img.icons8.com/fluent/20/000000/check-all.png' />
                                                        </div>
                                                    </div>



                                                </li>
                                                <li class="list-group-item" title="AML Policy and Procedures">

                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <a href="{{ route('profile') }}">AML Policy and
                                                                Procedures</a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img
                                                                src='https://img.icons8.com/fluent/20/000000/check-all.png' />
                                                        </div>
                                                    </div>



                                                </li>
                                                <li class="list-group-item" title="Latest Compliance External Audit Report">

                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <a href="{{ route('profile') }}">Latest Compliance
                                                                External Audit Report</a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img
                                                                src='https://img.icons8.com/fluent/20/000000/check-all.png' />
                                                        </div>
                                                    </div>



                                                </li>
                                                <li class="list-group-item"
                                                    title="Organizational Chart (including details of Compliance roles and functions)">

                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <a href="{{ route('profile') }}">Organizational
                                                                Chart</a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img
                                                                src='https://img.icons8.com/fluent/20/000000/check-all.png' />
                                                        </div>
                                                    </div>



                                                </li>
                                                <li class="list-group-item" title="Proof of Financial License">

                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <a href="{{ route('profile') }}">Proof of Financial
                                                                License</a>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img
                                                                src='https://img.icons8.com/fluent/20/000000/check-all.png' />
                                                        </div>
                                                    </div>



                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                    type="button" role="tab" aria-controls="home" aria-selected="true">Company
                                    Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                                    aria-selected="false">Owner and Controllers</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                    data-bs-target="#contact" type="button" role="tab" aria-controls="contact"
                                    aria-selected="false">Personal Information</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="transpin-tab" data-bs-toggle="tab"
                                    data-bs-target="#transpin" type="button" role="tab" aria-controls="transpin"
                                    aria-selected="false">Transaction Pin</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="bvn-tab" data-bs-toggle="tab" data-bs-target="#bvn"
                                    type="button" role="tab" aria-controls="password" aria-selected="false">BVN
                                    Verification</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="password-tab" data-bs-toggle="tab"
                                    data-bs-target="#password" type="button" role="tab" aria-controls="password"
                                    aria-selected="false">Password</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="security-tab" data-bs-toggle="tab"
                                    data-bs-target="#security" type="button" role="tab" aria-controls="security"
                                    aria-selected="false">Security</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                                <form class="card">
                                    <div class="container">
                                        <hr>
                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-3 control-label">Legal Entity Name</label>

                                            <div class="col-sm-12">


                                                <input type="text" class="form-control" name="businessName"
                                                    value="Double Major" placeholder="Legal Entity Name" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-3 control-label">Company Reg.
                                                Number</label>

                                            <div class="col-sm-12">


                                                <input type="text" class="form-control" name="companyRegistrationNumber"
                                                    value="2277848" placeholder="Company Registration Number">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-3 control-label">Trading Name</label>

                                            <div class="col-sm-12">


                                                <input type="text" class="form-control" name="tradingName"
                                                    value="D MAjor" placeholder="Trading Name">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-3 control-label">Registered Office
                                                Address</label>

                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="businessAddress"
                                                    value="No 14 Samuel Awonoyo Street" placeholder="Street Number & Name">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-3 control-label">Date of
                                                Incorporation</label>

                                            <div class="col-sm-12">
                                                <input type="date" class="form-control" name="dateOfIncorporation"
                                                    value="23/05/21">
                                            </div>
                                        </div>

                                        @if (session('country') == 'United States' || session('country') == 'USA')

                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-3 control-label">EIN Number</label>

                                                <div class="col-sm-12">
                                                    <input type="date" class="form-control" name="einNumber"
                                                        value="23565787">
                                                </div>
                                            </div>

                                        @endif




                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-3 control-label">Nature of
                                                Business</label>

                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="nature_of_business"
                                                    value="Entertainment" placeholder="E.g Auditing, Accounting & Advisory">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-3 control-label">Corporation</label>

                                            <div class="col-sm-12">
                                                <select name="corporate_type" id="corporate_type" class="form-control">
                                                    <option value="">Select Corporation Type</option>
                                                    <option value="Sole Proprietorship">
                                                        Sole Proprietorship</option>
                                                    <option value="Partnership">
                                                        Partnership</option>
                                                    <option value="Limited Liability Company">
                                                        Limited Liability Company</option>
                                                    <option value="Public Company">
                                                        Public Company</option>
                                                    <option value="Trust and Estate">
                                                        Trust and Estate</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-3 control-label">Invoice Type</label>

                                            <div class="col-sm-12">
                                                <select name="type_of_service" id="type_of_service" class="form-control">
                                                    <option value="">Select Invoice Type</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-3 control-label">Industry</label>

                                            <div class="col-sm-12">
                                                <select name="industry" id="industry" class="form-control">
                                                    <option value="">Select Industry</option>
                                                    {{-- <option value="{{ $data['getbusinessDetail']->industry }}" selected>
                                                    {{ $data['getbusinessDetail']->industry }}</option> --}}
                                                    <option value="Accounting">Accounting</option>
                                                    <option value="Airlines/Aviation">Airlines/Aviation</option>
                                                    <option value="Alternative Dispute Resolution">Alternative Dispute
                                                        Resolution</option>
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
                                                    <option value="Business Supplies/Equipment">Business Supplies/Equipment
                                                    </option>
                                                    <option value="Capital Markets/Hedge Fund/Private Equity">Capital
                                                        Markets/Hedge Fund/Private Equity</option>
                                                    <option value="Chemicals">Chemicals</option>
                                                    <option value="Civic/Social Organization">Civic/Social Organization
                                                    </option>
                                                    <option value="Civil Engineering">Civil Engineering</option>
                                                    <option value="Commercial Real Estate">Commercial Real Estate</option>
                                                    <option value="Computer Games">Computer Games</option>
                                                    <option value="Computer Hardware">Computer Hardware</option>
                                                    <option value="Computer Networking">Computer Networking</option>
                                                    <option value="Computer Software/Engineering">Computer
                                                        Software/Engineering
                                                    </option>
                                                    <option value="Computer/Network Security">Computer/Network Security
                                                    </option>
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
                                                    <option value="Electrical/Electronic Manufacturing">
                                                        Electrical/Electronic
                                                        Manufacturing</option>
                                                    <option value="Entertainment/Movie Production">Entertainment/Movie
                                                        Production</option>
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
                                                    <option value="Government Administration">Government Administration
                                                    </option>
                                                    <option value="Government Relations">Government Relations</option>
                                                    <option value="Graphic Design/Web Design">Graphic Design/Web Design
                                                    </option>
                                                    <option value="Health/Fitness">Health/Fitness</option>
                                                    <option value="Higher Education/Acadamia">Higher Education/Acadamia
                                                    </option>
                                                    <option value="Hospital/Health Care">Hospital/Health Care</option>
                                                    <option value="Hospitality">Hospitality</option>
                                                    <option value="Human Resources/HR">Human Resources/HR</option>
                                                    <option value="Import/Export">Import/Export</option>
                                                    <option value="Individual/Family Services">Individual/Family Services
                                                    </option>
                                                    <option value="Industrial Automation">Industrial Automation</option>
                                                    <option value="Information Services">Information Services</option>
                                                    <option value="Information Technology/IT">Information Technology/IT
                                                    </option>
                                                    <option value="Insurance">Insurance</option>
                                                    <option value="International Affairs">International Affairs</option>
                                                    <option value="International Trade/Development">International
                                                        Trade/Development</option>
                                                    <option value="Internet">Internet</option>
                                                    <option value="Investment Banking/Venture">Investment Banking/Venture
                                                    </option>
                                                    <option value="Investment Management/Hedge Fund/Private Equity">
                                                        Investment
                                                        Management/Hedge Fund/Private Equity</option>
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
                                                    <option value="Marketing/Advertising/Sales">Marketing/Advertising/Sales
                                                    </option>
                                                    <option value="Mechanical or Industrial Engineering">Mechanical or
                                                        Industrial Engineering</option>
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
                                                    <option value="Oil/Energy/Solar/Greentech">Oil/Energy/Solar/Greentech
                                                    </option>
                                                    <option value="Online Publishing">Online Publishing</option>
                                                    <option value="Other Industry">Other Industry</option>
                                                    <option value="Outsourcing/Offshoring">Outsourcing/Offshoring</option>
                                                    <option value="Package/Freight Delivery">Package/Freight Delivery
                                                    </option>
                                                    <option value="Packaging/Containers">Packaging/Containers</option>
                                                    <option value="Paper/Forest Products">Paper/Forest Products</option>
                                                    <option value="Performing Arts">Performing Arts</option>
                                                    <option value="Pharmaceuticals">Pharmaceuticals</option>
                                                    <option value="Philanthropy">Philanthropy</option>
                                                    <option value="Photography">Photography</option>
                                                    <option value="Plastics">Plastics</option>
                                                    <option value="Political Organization">Political Organization</option>
                                                    <option value="Primary/Secondary Education">Primary/Secondary Education
                                                    </option>
                                                    <option value="Printing">Printing</option>
                                                    <option value="Professional Training">Professional Training</option>
                                                    <option value="Program Development">Program Development</option>
                                                    <option value="Public Relations/PR">Public Relations/PR</option>
                                                    <option value="Public Safety">Public Safety</option>
                                                    <option value="Publishing Industry">Publishing Industry</option>
                                                    <option value="Railroad Manufacture">Railroad Manufacture</option>
                                                    <option value="Ranching">Ranching</option>
                                                    <option value="Real Estate/Mortgage">Real Estate/Mortgage</option>
                                                    <option value="Recreational Facilities/Services">Recreational
                                                        Facilities/Services</option>
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
                                                    <option value="Translation/Localization">Translation/Localization
                                                    </option>
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
                                            <label for="inputWebsite" class="col-sm-3 control-label">Website</label>

                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="businessWebsite"
                                                    value="www.example.com" placeholder="www.example.com">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="inputDescription"
                                                class="col-sm-3 control-label">Description</label>

                                            <div class="col-sm-12">
                                                <textarea name="businessDescription" class="form-control"
                                                    id="businessDescription" cols="30" rows="10"
                                                    maxlength="500">Entertainment</textarea>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="inputCorporationDocument"
                                                class="col-sm-3 control-label">&nbsp;</label>

                                            <div class="col-sm-12">
                                                <small class="text-danger"><strong>Articles of
                                                        Incorporation</strong></small>
                                                <input type="file" class="form-control" name="incorporation_doc_front">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputCorporationDocument"
                                                class="col-sm-3 control-label">&nbsp;</label>

                                            <div class="col-sm-12">
                                                <small class="text-danger"><strong>Register of
                                                        Directors</strong></small>
                                                <input type="file" class="form-control" name="directors_document">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputCorporationDocument"
                                                class="col-sm-3 control-label">&nbsp;</label>

                                            <div class="col-sm-12">
                                                <small class="text-danger"><strong>Register of
                                                        Shareholders</strong></small>
                                                <input type="file" class="form-control" name="shareholders_document">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputCorporationDocument"
                                                class="col-sm-3 control-label">&nbsp;</label>

                                            <div class="col-sm-12">
                                                <small class="text-danger"><strong>Proof of Identity - 1
                                                        Director</strong></small>
                                                <input type="file" class="form-control" name="proof_of_identity_1">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputCorporationDocument"
                                                class="col-sm-3 control-label">&nbsp;</label>

                                            <div class="col-sm-12">
                                                <small class="text-danger"><strong>Proof of Identity - 1
                                                        UBO</strong></small>
                                                <input type="file" class="form-control" name="proof_of_identity_2">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputCorporationDocument"
                                                class="col-sm-3 control-label">&nbsp;</label>

                                            <div class="col-sm-12">
                                                <small class="text-danger"><strong>AML Policy and
                                                        Procedures</strong></small>
                                                <input type="file" class="form-control" name="aml_policy">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputCorporationDocument"
                                                class="col-sm-3 control-label">&nbsp;</label>

                                            <div class="col-sm-12">
                                                <small class="text-danger"><strong>Latest Compliance External Audit
                                                        Report</strong></small>
                                                <input type="file" class="form-control" name="compliance_audit_report">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputCorporationDocument"
                                                class="col-sm-3 control-label">&nbsp;</label>

                                            <div class="col-sm-12">
                                                <small class="text-danger"><strong>Organizational Chart (including
                                                        details
                                                        of Compliance roles and functions)</strong></small>
                                                <input type="file" class="form-control" name="organizational_chart">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="inputCorporationDocument"
                                                class="col-sm-3 control-label">&nbsp;</label>

                                            <div class="col-sm-12">
                                                <small class="text-danger"><strong>Proof of Financial
                                                        License</strong></small>
                                                <input type="file" class="form-control" name="financial_license">
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <button type="button" class="btn btn-primary btn-block"
                                                            onclick="handShake('merchantbusiness')"
                                                            id="updatemyBusinessProfile">Update Business</button>
                                                    </div>
                                                    <div class="col-md-6">



                                                        {{-- <button type="button" class="btn btn-danger btn-block"
                                                        onclick="handShake('promotebusiness')"
                                                        id="promoteMyBusiness">Promote Business</button> --}}



                                                        <button type="button" class="btn btn-success btn-block"
                                                            onclick="handShake('broadcastbusiness')"
                                                            id="broadcastMyBusiness">Broadcast Business</button>




                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                                <form action="#" method="post" class="card" id="formElemShareholder">
                                    <div class="container">
                                        <hr>

                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-3 control-label">Shareholder
                                                Details</label>

                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="shareholder"
                                                    value="Daniel Oni" placeholder="Shareholder Details">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail" class="col-sm-3 control-label">Director Details</label>

                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="directordetails"
                                                    value="Test" placeholder="Director Details">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="button" class="btn btn-primary btn-block"
                                                    onclick="handShake('ownerandcontrollers')" id="updatemyOwnership">Update
                                                    Information</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>

                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <form action="#" method="post" class="card" id="formElemProfile">
                                    <div class="container">
                                        <hr>

                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Name</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="name" value="Oni"
                                                    placeholder="Name" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" name="email"
                                                    value="onidaniel23@yahoo.com" readonly="" placeholder="Email">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Telephone</label>

                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="telephone"
                                                    placeholder="Telephone" value="759839497497">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Day of Birth</label>

                                            <div class="col-sm-10">
                                                <select name="dayOfBirth" id="dayOfBirth" class="form-control" required>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Month of Birth</label>

                                            <div class="col-sm-10">
                                                <select name="monthOfBirth" id="monthOfBirth" class="form-control"
                                                    required>
                                                    <option selected value='1'>
                                                        January</option>
                                                    <option value='2'>
                                                        February</option>
                                                    <option value='3'>
                                                        March</option>
                                                    <option value='4'>
                                                        April</option>
                                                    <option value='5'>
                                                        May</option>
                                                    <option value='6'>
                                                        June</option>
                                                    <option value='7'>
                                                        July</option>
                                                    <option value='8'>
                                                        August</option>
                                                    <option value='9'>
                                                        September</option>
                                                    <option value='10'>
                                                        October</option>
                                                    <option value='11'>
                                                        November</option>
                                                    <option value='12'>
                                                        December</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Year of Birth</label>

                                            <div class="col-sm-10">
                                                <select name="yearOfBirth" id="yearOfBirth" class="form-control">

                                                </select>
                                            </div>
                                        </div>




                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Country</label>

                                            <div class="col-sm-10">
                                                <select class="form-control" name="country" readonly>
                                                    {{-- <option selected="" value="{{ $data['getuserDetail']->country }}">
                                                    {{ $data['getuserDetail']->country }}</option> --}}
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">State</label>

                                            <div class="col-sm-10">
                                                <select class="form-control" name="state">
                                                    <option selected="" value="Lagos State">
                                                        Lagos State</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">City</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="city" placeholder="City"
                                                    value="Ikeja">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Postal Code</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="zip" placeholder="Zip Code"
                                                    value="860848">
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
                                                <small class="text-danger"><strong>Government issued photo ID
                                                        (FRONT)</strong></small>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="file" class="form-control" name="nin_back">
                                                <small class="text-danger"><strong>Government issued photo ID
                                                        (BACK)</strong></small>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputLicense" class="col-sm-2 control-label">License</label>

                                            <div class="col-sm-5">
                                                <input type="file" class="form-control" name="drivers_license_front">
                                                <small class="text-danger"><strong>Upload Driver's License
                                                        (FRONT)</strong></small>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="file" class="form-control" name="drivers_license_back">
                                                <small class="text-danger"><strong>Upload Driver's License
                                                        (BACK)</strong></small>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="inputPassport" class="col-sm-2 control-label">Passport</label>

                                            <div class="col-sm-5">
                                                <input type="file" class="form-control"
                                                    name="international_passport_front">
                                                <small class="text-danger"><strong>Upload International Passport
                                                        (FRONT)</strong></small>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="file" class="form-control"
                                                    name="international_passport_back">
                                                <small class="text-danger"><strong>Upload International Passport
                                                        (BACK)</strong></small>
                                            </div>
                                        </div>





                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="button" class="btn btn-primary btn-block"
                                                    onclick="handShake('merchantprofile')" id="updatemyProfile">Update
                                                    Profile</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="transpin" role="tabpanel" aria-labelledby="transpin-tab">
                                <form action="#" method="post" class="card" id="formElemtransactionpinsettings">
                                    <div class="container">
                                        <hr>
                                        <div class="form-group">
                                            <label for="oldpin">Old Pin <strong>
                                                    <p class="text-danger" style="cursor: pointer;" onclick='#'>
                                                        Have you forgotten your old transaction pin? <span
                                                            style="text-decoration: underline;">Click here to reset</span>
                                                    </p>
                                                </strong></label>
                                            <input type="password" name="oldpin" id="oldpin" class="form-control"
                                                placeholder="Pin" maxlength="4">
                                        </div>
                                        <div class="form-group">
                                            <label for="newpin">New Pin</label>
                                            <input type="password" name="newpin" id="newpin" class="form-control"
                                                placeholder="New Pin" maxlength="4">
                                        </div>
                                        <div class="form-group">
                                            <label for="confirmpin">Confirm Pin</label>
                                            <input type="password" name="confirmpin" id="confirmpin" class="form-control"
                                                placeholder="Confirm Pin" maxlength="4">
                                        </div>

                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-block" id="transactionBtn"
                                                onclick="handShake('transactionpinsettings')">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="bvn" role="tabpanel" aria-labelledby="bvn-tab">
                                <form action="#" method="post" class="card" id="formElembvnverification">
                                    <div class="container">
                                        <hr>
                                        <div class="form-group">
                                            <label for="bvn">Bank Verification Number <strong>
                                                    <p class="text-warning" style="cursor: pointer;">Enter your bank
                                                        verification number</p>
                                                </strong> </label>
                                            <input type="number" name="bvn" id="bvn" class="form-control"
                                                value="080645783" readonly placeholder="BVN">
                                        </div>



                                        <div class="form-group">
                                            <label for="account_number">Bank Account Number <strong>
                                                    <p class="text-warning" style="cursor: pointer;">Enter your bank
                                                        account number</p>
                                                </strong></label>
                                            <input type="number" name="account_number" id="account_number"
                                                class="form-control" placeholder="Account Number">
                                        </div>

                                        <div class="form-group">
                                            <label for="bank_code">Select Bank <strong>
                                                    <p class="text-warning" style="cursor: pointer;">Select your bank
                                                    </p>
                                                </strong></label>
                                            <select name="bank_code" id="bank_code" class="form-control">


                                                <option value="">Select your bank</option>

                                                <option value="UBA">
                                                    UBA
                                                </option>


                                            </select>
                                        </div>




                                        <div class="form-group">
                                            <label for="account_name">Account Name</label>
                                            <input type="text" name="account_name" id="account_name" class="form-control"
                                                value="" readonly>
                                        </div>


                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-block" id="bvnBtn"
                                                onclick="handShake('bvnverification')">Save</button>
                                        </div>




                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                                <form action="#" method="post" class="card" id="formElempasswordsettings">
                                    <div class="container">
                                        <hr>
                                        <div class="form-group">
                                            <label for="oldpassword">Old Password <strong>
                                                    <p class="text-danger" style="cursor: pointer;" onclick='#'>
                                                        Have you forgotten your old password? <span
                                                            style="text-decoration: underline;">Click here to reset</span>
                                                    </p>
                                                </strong></label>
                                            <input type="password" name="oldpassword" id="oldpassword"
                                                class="form-control" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="newpin">New Password</label>
                                            <input type="password" name="newpassword" id="newpassword"
                                                class="form-control" placeholder="New Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="confirmpin">Confirm Password</label>
                                            <input type="password" name="confirmpassword" id="confirmpassword"
                                                class="form-control" placeholder="Confirm Password">
                                        </div>

                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-block" id="passwordBtn"
                                                onclick="handShake('passwordsettings')">Save</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                                <form action="#" method="post" class="card" id="formElemsecurityquestans">
                                    <div class="container">
                                        <hr>
                                        <div class="form-group">

                                            <label for="securityQuestion">Question</label>



                                            <select name="securityQuestion" id="securityQuestion" class="form-control">
                                                <option value="">Select Question</option>
                                                <option value="What was your first pet's name?">
                                                    What was your first pet's name?</option>
                                                <option value="What is the name of the city where you were born?">
                                                    What is the name of the city where you were born?</option>
                                                <option value="What was your childhood nickname?">
                                                    What was your childhood nickname?</option>
                                                <option value="What is the name of the city where your parents met?">
                                                    What is the name of the city where your parents met?</option>
                                                <option value="What is the first name of your oldest cousin?">
                                                    What is the first name of your oldest cousin?</option>
                                                <option value="What is the name of the first school you attended?">
                                                    What is the name of the first school you attended?</option>
                                            </select>

                                        </div>
                                        <div class="form-group">
                                            <label for="securityAnswer">Answer</label>
                                            <input type="text" name="securityAnswer" id="securityAnswer"
                                                class="form-control" placeholder="Answer">
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-block" id="securityBtn"
                                                onclick="handShake('securityquestans')">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>




                    </div>
                </div>



            </div>
        </div>
    </div>
    </div>



    <!-- Container-fluid Ends-->
@endsection
