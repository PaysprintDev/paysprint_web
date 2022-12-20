@extends('layouts.newpage.app')

@section('content')
<!-- navbar- -->
<style>
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}



.wrapper{
    max-width: 1090px;
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    margin: auto;
    justify-content: space-between;
}

.wrapper .table{
    background: #fff;
    width: calc(33% - 20px);
    padding: 30px 30px;
    position: relative;
    box-shadow: 0 5px 10px rgba(0,0,0,0.1);
}

@media (max-width: 1020px){
    .wrapper .table{
        width: calc(50% - 20px);
        margin-bottom: 40px;
    }
}

@media (max-width: 698px){
    .wrapper .table{
        width: 100%;
    }
}

.table .price-section{
   display: flex;
   justify-content: center;
}

.price-section .price-area{
    height: 120px;
    width: 120px;
    background: #ffd861;
    border-radius: 50%;
    padding: 2px;
}

.price-section .price-area .inner-area{
    height: 100%;
    width: 100%;
    border-radius: 50%;
    border: 3px solid #fff;
    color: #fff;
    line-height: 117px;
    text-align: center;
    position: relative;
}

.price-area .inner-area .text{
    font-size: 20px;
    /* font-weight: 200; */
    position: absolute;
    top: -10px;
    left: 17px;
}

.price-area .inner-area .price{
    font-size: 25px;
    font-weight: 500;
}

.table .package-name{
    width: 100%;
    height: 2px;
    background: #ffecb3;
    margin: 35px 0;
    position: relative;
}

.table .package-name::before{
    position: absolute;
    content: "Freemium";
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    font-size: 25px;
    padding: 0 10px;
    font-weight: bolder;
}

.table .features li{
    list-style: none;
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.features li .list-name{
    font-size: 17px;
    font-weight: 400;
}

.features li .icon{
    font-size: 15px;
}

.features li .icon.check{
    color: #2db94d;
}

.features li .icon.cross{
    color: #cd3241;
}

.table .btn{
    display: flex;
    justify-content: center;
    margin-top: 35px;
}

.table .btn button{
    width: 80%;
    height: 50px;
    font-weight: 700;
    color: #fff;
    font-size: 20px;
    border: none;
    outline: none;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.basic .price-area,
.basic .inner-area{
    background: #ffd861;
}

.basic .btn button{
    background: #fff;
    color: #ffd861;
    border: 2px solid #ffd861;
}

.basic .btn button:hover{
    border-radius: 6px;
    background: #ffd861;
    color: #fff;
}

.Premium .price-area,
.Premium .inner-area{
    background: #a26bfa;
}

.Premium .btn button{
    background: #fff;
    color: #a26bfa;
    border: 2px solid #a26bfa;
}

.Premium .btn button:hover{
    border-radius: 6px;
    background: #a26bfa;
    color: #fff;
}

.Ultimate .price-area,
.Ultimate .inner-area{
    background: #43ef8b;
}

.Ultimate .btn button{
    background: #fff;
    color: #43ef8b;
    border: 2px solid #43ef8b;
}

.Ultimate .btn button:hover{
    border-radius: 6px;
    background: #43ef8b;
    color: #fff;
}

.basic .package-name{
    background: #ffecb3;
}

.Premium .package-name{
    background: #a26bfa;
}

.Ultimate .package-name{
    background: #43ef8b;
}

.basic .package-name::before{
    content: "Freemium";
}

.Premium .package-name::before{
    content: "Basic";
}

.Ultimate .package-name::before{
    content: "Classic";
}

.basic ::selection,
.basic .price-area,
.basic .inner-area{
    background: #ffd861;
}

.Premium ::selection,
.Premium .price-area,
.Premium .inner-area{
    background: #a26bfa;
}

.Ultimate ::selection,
.Ultimate .price-area,
.Ultimate .inner-area{
    background: #43ef8b;
}
</style>


<div style="overflow-y: auto !important;">
    <div class="inner-banner pt-29 pt-lg-30 pb-9 pb-lg-12 bg-default-6">
        <div class="container">
            <div class="row  justify-content-center pt-5">
                <div class="col-xl-8 col-lg-9">
                    <div class="px-md-15 text-center">
                        <h2 class="title gr-text-2 mb-8 mb-lg-10">Plan and Pricing</h2>
                        {{-- <p class="gr-text-7 mb-0 mb-lg-13">Full Time, Remote</p> --}}
                    </div>
                </div>

                <div class="col-12">
                    <table class="table table-striped table-bordered">

                        <tbody>
                            <tr>
                                <td>
                                    <p class="gr-text-7 font-weight-bold mb-9">Select Country</p>

                                    <select name="country" id="pricing_country2" class="form-control" style="overflow-y: auto">
                                        <option value="">Select Country</option>
                                        @foreach ($data['activecountries'] as $country)
                                        <option value="{{ $country->name }}" {{ $country->name == Request::get('country') ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="main-block pb-6 pb-lg-17 bg-default-6">
        <div class="container">
            <div class="row justify-content-center">

                <div class="table table-responsive">


                </div>
                <div class="table table-responsive">




                        @if ($thisprices = \App\TransactionCost::where('country', $data['country'])->where('structure', 'Merchant Monthly Subscription')->first())

                        @php
                        $monthlyBased = $thisprices->fixed;
                        $yearlyBased = $thisprices->fixed * 10;
                        $basic = $thisprices->basic;
                        $classic = $thisprices->classic;
                        @endphp

                        @else
                        @php
                        $monthlyBased = 0;
                        $yearlyBased = 0;
                        $basic = 0;
                        $classic = 0;                      
                         @endphp
                        @endif



                    <div class="wrapper">
                        <div class="table basic">
                            <div class="price-section">
                                <div class="price-area">
                                    <div class="inner-area">

                                        </span>
                                        <span class="price">00</span>
                                    </div>

                                </div>

                            </div>
                            <div class="package-name">

                            </div>
                            <div class="features">

                                <div class="accordion" id="accordionPanelsStayOpenExample">
                                    <div class="accordion-item">
                                        <p style="font-size: .8rem" class="text-danger">
                                            Unimited Transactions
                                        </p>
                                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                          <h6 >
                                            Receive Payments from Customers
  
                                          </h6>
  
                                        </h2>
                                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                          <div class="accordion-body">
                                              <li>
                                                  <span class="list-name">Display QR Code to Receive Face-to-Face Payment</span>
                                                  <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                              </li>
                                              <p style="font-size: .8rem">(Customer Scan QR to make payments. No need for a Point of Sale Terminal)</p>
                                              <li>
                                                  <span class="list-name">Share Payment Links</span>
                                                  <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                              </li>
                                              <p style="font-size: .8rem">(Send Payment link via emails,SMS or Whatsapp for remote Customers to make payment)</p>
                                              <li>
                                                  <span class="list-name">Receive Online Payment</span>
                                                  <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                              </li>
                                              <p style="font-size: .8rem">(Install the App on the business website to receive payment from customers)</p>
                                           
                                          </div>
                                        </div>
                                      </div>
                                    <div class="accordion-item">
                                    
                                    </div>
                                    <div class="accordion-item">
                                        <div >
                                      <h2 class="accordion-header" id="panelsStayOpen-headingThree">

                                        <h6 >
                                          Pay Invoice

                                        </h6>
                                      </h2>
                                      <div >
                                        <div>
                                            <li>
                                                <span class="list-name">to other businesses on PaySprint(B2B)</span>
                                                <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                            </li>
                                            <p style="font-size: .8rem">(Pay Vendors and suppliers that are on PaySprint at a click of button)</p>
                                            <li>
                                                <span class="list-name">to other businesses not on PaySprint(B2B)</span>
                                                <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                            </li>
                                            <p style="font-size: .8rem">(Pay Vendors and suppliers that are  not on PaySprint at a click of button)</p>
                                           
                                        </div>
                                      </div>
                                    </div>
                                    </div>
                                </div>


                                <div class="">
                                    <h6 >
                                        Business Tools

                                      </h6>
                                      <li class="">
                                        <span class="list-name">Invoicing</span>
                                        <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                    </li>
                                    <p style="font-size: .8rem">(Create and  Send invoice to customers with any mobile device)</p>
                                    <li>
                                        <span class="list-name">Merchant Cash Advance</span>
                                        <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                    </li>
                                    <p style="font-size: .8rem">(Access additional funds to boost your cashflow)</p>
                                    <li>
                                        <span class="list-name">Bill Payments</span>
                                        <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                    </li>
                                    <p style="font-size: .8rem">(Pay Utility bills on time)</p>
                                </div>
                                <div class="mt-34 pt-31">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                        <h6>
                                            Money Transfer(Wallet-to-Wallet. Fee Apply)
                                            {{-- <span class="icon check"><i class="fas fa-arrow-down"></i></span> --}}
                                          </h6>
                                    </h2>
                                    <div>
                                        <div>
                                            <li>
                                                <span class="list-name">Local Money Transfer</span>
                                                <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                            </li>
                                         
                                           
                                        </div>
                                    </div>
                                  </div>
                            </div>
                        </div>
                        <div class="table Premium">
                            <div class="price-section">
                                <div class="price-area">
                                    <div class="inner-area">

                                        </span>
                                        <span class="price">{{ $data['currency'] . number_format($basic, 2)}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="package-name">

                            </div>
                            <div class="features">
                                <div class="accordion" id="accordionPanelsStayOpenExample">
                                    <div class="accordion-item">
                                        <p style="font-size: .8rem" class="text-danger">
                                            Unimited Transactions
                                        </p>
                                      <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                        <h6 >
                                          Receive Payments from Customers

                                        </h6>

                                      </h2>
                                      <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                        <div class="accordion-body">
                                            <li>
                                                <span class="list-name">Display QR Code to Receive Face-to-Face Payment</span>
                                                <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                            </li>
                                            <p style="font-size: .8rem">(Customer Scan QR to make payments. No need for a Point of Sale Terminal)</p>
                                            <li>
                                                <span class="list-name">Share Payment Links</span>
                                                <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                            </li>
                                            <p style="font-size: .8rem">(Send Payment link via emails,SMS or Whatsapp for remote Customers to make payment)</p>
                                            <li>
                                                <span class="list-name">Receive Online Payment</span>
                                                <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                            </li>
                                            <p style="font-size: .8rem">(Install the App on the business website to receive payment from customers)</p>
                                         
                                        </div>
                                      </div>
                                    </div>
                                   
                                   
                                </div>
                             
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                      <h6 >
                                        Pay Invoice

                                      </h6>
                                    </h2>
                                    <div >
                                        <div>
                                            <li>
                                                <span class="list-name">to other businesses on PaySprint(B2B)</span>
                                                <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                            </li>
                                            <p style="font-size: .8rem">(Pay Vendors and suppliers that are on PaySprint at a click of button)</p>
                                            <li>
                                                <span class="list-name">to other businesses not on PaySprint(B2B)</span>
                                                <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                            </li>
                                            <p style="font-size: .8rem">(Pay Vendors and suppliers that are  not on PaySprint at a click of button)</p>
                                           
                                        </div>
                                    </div>
                                    <div class="">
                                        <h6 >
                                            Business Tools
    
                                          </h6>
                                          <li class="">
                                            <span class="list-name">Invoicing</span>
                                            <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                        </li>
                                        <p style="font-size: .8rem">(Create and  Send invoice to customers with any mobile device)</p>
                                        <li>
                                            <span class="list-name">Merchant Cash Advance</span>
                                            <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                        </li>
                                        <p style="font-size: .8rem">(Access additional funds to boost your cashflow)</p>
                                        <li>
                                            <span class="list-name">Bill Payments</span>
                                            <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                        </li>
                                        <p style="font-size: .8rem">(Pay Utility bills on time)</p>
                                    </div>
                                    <div class="mt-34 pt-31">
                                    <div class="accordion-item ">
                                      <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                        <h6>
                                            Money Transfer(Wallet-to-Wallet with No Fee)
                                            {{-- <span class="icon check"><i class="fas fa-arrow-down"></i></span> --}}
                                          </h6>
                                      </h2>
                                      <div>
                                        <div>
                                            <li>
                                                <span class="list-name">Local Money Transfer</span>
                                                <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                            </li>
                                            <li>
                                                <span class="list-name"> Cross Border Money Transfer </span>
                                                <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                            </li>
                                           
                                        </div>
                                      </div>
                                    </div>
                                    <div class="accordion-item">
                                     
                                        <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                          <h6>
                                            Money Transfer(Wallet-to-Wallet. Fee Apply)
                                            {{-- <span class="icon check"><i class="fas fa-arrow-down"></i></span> --}}
                                          </h6>
                                        </h2>
                                        <div>
                                          <div>
                                              <li>
                                                  <span class="list-name">Local Money Transfer</span>
                                                  <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                              </li>
                                              <li>
                                                  <span class="list-name"> Cross Border Money Transfer </span>
                                                  <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                              </li>
                                             
                                          </div>
                                        </div>
                                  </div>
                                </div>
                                  </div>


                            </div>
                        </div>
                        <div class="table Ultimate">
                            <div class="price-section">
                                <div class="price-area">
                                    <div class="inner-area">

                                        </span>
                                        <span class="price">{{ $data['currency'] . number_format($classic, 2)}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="package-name">

                            </div>
                            <div class="features">
                                <div class="accordion" id="accordionPanelsStayOpenExample">
                                    <div class="accordion-item">
                                        <p style="font-size: .8rem" class="text-danger">
                                            Unimited Transactions
                                        </p>
                                      <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                        <h6 >
                                          Receive Payments from Customers
                                        
                                        </h6>

                                      </h2>
                                      <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                        <div class="accordion-body">
                                            <li>
                                                <span class="list-name">Display QR Code to Receive Face-to-Face Payment</span>
                                                <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                            </li>
                                            <p style="font-size: .8rem">(Customer Scan QR to make payments. No need for a Point of Sale Terminal)</p>
                                            <li>
                                                <span class="list-name">Share Payment Links</span>
                                                <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                            </li>
                                            <p style="font-size: .8rem">(Send Payment link via emails,SMS or Whatsapp for remote Customers to make payment)</p>
                                            <li>
                                                <span class="list-name">Receive Online Payment</span>
                                                <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                            </li>
                                            <p style="font-size: .8rem">(Install the App on the business website to receive payment from customers)</p>
                                         
                                        </div>
                                      </div>
                                    </div>
                                   
                                    <div class="accordion-item">
                                      <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                        <h6 >
                                          Pay Invoice
                                          {{-- <span class="icon check"><i class="fas fa-arrow-down"></i></span> --}}
                                        </h6>
                                      </h2>
                                      <div >
                                        <div>
                                            <li>
                                                <span class="list-name">to other businesses on PaySprint(B2B)</span>
                                                <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                            </li>
                                            <p style="font-size: .8rem">(Pay Vendors and suppliers that are on PaySprint at a click of button)</p>
                                            <li>
                                                <span class="list-name">to other businesses not on PaySprint(B2B)</span>
                                                <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                            </li>
                                            <p style="font-size: .8rem">(Pay Vendors and suppliers that are  not on PaySprint at a click of button)</p>
                                           
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="extras">
                                    <h6 >
                                        Business Tools

                                      </h6>
                                <li class="">
                                    <span class="list-name">Invoicing</span>
                                    <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                </li>
                                <p style="font-size: .8rem">(Create and  Send invoice to customers with any mobile device)</p>
                                <li>
                                    <span class="list-name">Merchant Cash Advance</span>
                                    <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                </li>
                                <p style="font-size: .8rem">(Access additional funds to boost your cashflow)</p>
                                <li>
                                    <span class="list-name">Bill Payments</span>
                                    <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                </li>
                                <p style="font-size: .8rem">(Pay Utility bills on time)</p>
                                <li>
                                    <span class="list-name">Sell Online</span>
                                    <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                </li>
                                <p style="font-size: .8rem">(Utilize additional outlet to sell more to customers)</p>
                                <li>
                                    <span class="list-name">Manage Rental Property</span>
                                    <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                </li>
                                <p style="font-size: .8rem">(Manage your rental property with ease)</p>
                                <li>
                                    <span class="list-name">Working Capital Support</span>
                                    <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                </li>
                                <p style="font-size: .8rem">(Easily access additional funds based on transaction history in your business account with PaySprint)</p>
                                <li>
                                    <span class="list-name">Cross Border Business Payment</span>
                                    <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                </li>
                                <p style="font-size: .8rem">(Pay Invoice or bills of foreign supplies or venders with ease)</p>
                                </div>
                                <div class="accordion-item mt-4">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                        <h6>
                                          Money Transfer(Wallet-to-Wallet with No Fee)
                                          {{-- <span class="icon check"><i class="fas fa-arrow-down"></i></span> --}}
                                        </h6>
                                      </h2>
                                      <div>
                                        <div>
                                            <li>
                                                <span class="list-name">Local Money Transfer</span>
                                                <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                            </li>
                                            <li>
                                                <span class="list-name"> Cross Border Money Transfer </span>
                                                <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                            </li>
                                           
                                        </div>
                                      </div>
                                    </div>
                                    <div class="accordion-item">
                                       
                                        <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                          <h6>
                                            Money Transfer(Wallet-to-Wallet. Fee Apply)
                                            {{-- <span class="icon check"><i class="fas fa-arrow-down"></i></span> --}}
                                          </h6>
                                        </h2>
                                        <div>
                                          <div>
                                              <li>
                                                  <span class="list-name">Local Money Transfer</span>
                                                  <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                              </li>
                                              <li>
                                                  <span class="list-name"> Cross Border Money Transfer </span>
                                                  <span class="icon check"><i class="fas fa-check-circle"></i></span>
                                              </li>
                                             
                                          </div>
                                        </div>
                                  </div>
                                  </div>

                            </div>
                        </div>
                    </div>
                    <p class="text-center text-danger">7days Free Subscription. Cancel Subscription at any time.</p>
                    <p class="text-center text-danger">Where PaySprint has no office, Partner fee may apply</p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
