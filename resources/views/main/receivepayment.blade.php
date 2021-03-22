<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <!-- Favicon -->
<link rel="icon" href="https://res.cloudinary.com/pilstech/image/upload/v1602675914/paysprint_icon_png_ol2z3u.png" type="image/x-icon" />

<link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />

<script src="https://kit.fontawesome.com/384ade21a6.js"></script>

    <title>PaySprint | Receive Money</title>

    <style>
        body {
    background: #f5f5f5
}

.rounded {
    border-radius: 1rem
}

.nav-pills .nav-link {
    color: #555
}

.nav-pills .nav-link.active {
    color: white
}

input[type="radio"] {
    margin-right: 5px
}

.bold {
    font-weight: bold
}
.disp-0{
    display: none !important;
}
    </style>

  </head>
  <body>
    <div class="container py-5">
        <!-- For demo purpose -->
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4">Receive Money</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item"> <a data-toggle="pill" href="#credit-card" class="nav-link active "> <i class="fas fa-credit-card mr-2"></i> It's Fast and Safe... </a> </li>
                                {{-- <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i class="fab fa-paypal mr-2"></i> Debit Card </a> </li>
                                <li class="nav-item"> <a data-toggle="pill" href="#net-banking" class="nav-link "> <i class="fas fa-mobile-alt mr-2"></i> EXBC Card </a> </li> --}}
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">

                            @if (isset($data))
                                
                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">
                                <form role="form" action="{{ route('receivemoneyProcess') }}" method="POST">
                                    

                                    @csrf
                                    <input type="hidden" class="form-control" name="pay_id" id="pay_id" value="{{ $data['getpay']->orgId }}">
                                    <input type="hidden" class="form-control" name="sender_id" id="sender_id" value="{{ $data['getpay']->ref_code }}">
                                    <input type="hidden" class="form-control" name="receiver_id" id="receiver_id" value="{{ Auth::user()->ref_code }}">

                                    <div class="form-group">
                                        <div class="alert alert-info">
                                            <ul>
                                                <li>
                                                    Sender's Name: <b>{{ $data['getpay']->name }}</b>
                                                </li>
                                                <li>
                                                    Address: <b>{{ $data['getpay']->address }}</b>
                                                </li>
                                                <li>
                                                    City: <b>{{ $data['getpay']->city }}</b> | State/Province: <b>{{ $data['getpay']->state }}</b>
                                                </li>
                                                <li>
                                                    Country: <b>{{ $data['getpay']->country }}</b>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="alert alert-warning">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4>
                                                        Wallet Balance
                                                    </h4>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4>
                                                        {{ $data['currencyCode'][0]->currencies[0]->symbol."".number_format(Auth::user()->wallet_balance, 2) }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>

                                    
                                    
                                    
                                        <div class="form-group"> <label for="purpose">
                                            <h6>Purpose of Payment</h6>
                                        </label>
                                        <div class="input-group"> 
                                            <input type="text" name="purpose" id="purpose" value="{{ $data['getpay']->purpose }}" readonly class="form-control">
                                        </div>
                                    </div>

                                        
                                    
                                    <div class="form-group disp-0"> <label for="payment_method">
                                            <h6>Payment Method</h6>
                                        </label>
                                        <div class="input-group"> 
                                            <select name="payment_method" id="payment_method" class="form-control" required>
                                                {{--  <option value="Bank">Direct Bank Transfer</option>  --}}
                                                <option value="Wallet">My Wallet</option>
                                                <option value="EXBC Card">EXBC Card</option>
                                            </select>
                                            
                                        </div>
                                    </div>

                                    <div class="form-group disp-0 bizInfo">
                                        <small class="text-danger"><b>It may take up to two (2) business days for money to reflect in your card</b></small>
                                    </div>

                                    <div class="form-group"> <label for="currency">
                                            <h6>Currency</h6>
                                        </label>
                                        <div class="input-group"> 
                                            <select name="currency" id="currency" class="form-control">
                                                <option value="{{ $data['currencyCode'][0]->currencies[0]->code }}" selected>{{ $data['currencyCode'][0]->currencies[0]->code }}</option>
                                            </select>
                                            
                                        </div>
                                    </div>

                                    

                                    <div class="form-group"> <label for="amount_to_receive">
                                            <h6>Amount to Receive (USD)</h6>
                                        </label>
                                        <div class="input-group"> <input type="text" name="amount_to_receive" id="amount_to_receive" value="{{ $data['getpay']->amountindollars }}" class="form-control" maxlength="16" readonly>
                                            <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fas fa-money-check mx-1"></i> <i class="fab fa-cc-mastercard mx-1"></i> <i class="fab fa-cc-amex mx-1"></i> </span> </div>
                                        </div>
                                    </div>


                                    <div class="form-group"> <label for="netwmount">
                                            <h6>Currency Conversion <br><small class="text-info"><b>Exchange rate today according to currencylayer.com</b></small></h6>
                                            <p style="font-weight: bold;">
                                                USD <=> {{ $data['currencyCode'][0]->currencies[0]->code }}
                                            </p>
                                        </label>
                                        <div class="input-group"> 
                                            <input type="text" name="conversionamount" class="form-control" id="conversionamount" value="" placeholder="0.00" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                            <span class="text-danger" style="font-weight: 800">International transfers are received in USD{{ $data['currencyCode'][0]->currencies[0]->code }} rates</span>
                                        </div>
                                    
                                    <div class="bank_info disp-0">
                                        <hr>
                                            <h5 class="text-primary">Bank Information</h5>
                                            <hr>

                                            <div class="form-group"> <label for="accountname">
                                                <h6>Account Name</h6>
                                            </label>
                                            <div class="input-group"> 
                                                <input type="text" name="accountname" id="accountname" placeholder="Bank Account Name" class="form-control" >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <span class="text-danger">Please ensure the name on the card is the same as the <b>Account Name</b></span>
                                        </div>

                                            <div class="form-group"> <label for="account_number">
                                                <h6>Account Number</h6>
                                            </label>
                                            <div class="input-group"> 
                                                <input type="number" name="account_number" id="account_number" placeholder="Bank Account Number" class="form-control" >
                                            </div>
                                        </div>
                                            <div class="form-group"> <label for="bank_name">
                                                <h6>Bank Name</h6>
                                            </label>
                                            <div class="input-group"> 
                                                <input type="text" name="bank_name" id="bank_name" placeholder="Bank Name" class="form-control" >
                                            </div>
                                        </div>
                                    </div>

                                    

                                    <div class="card_info disp-0">
                                        <hr>
                                        <h5 class="text-primary">Card Information</h5>
                                        <hr>

                                        <div class="form-group"> <label for="orgpaycreditcard">
                                                <h6>Card number</h6>
                                            </label>
                                            <div class="input-group"> <input type="number" name="creditcard_no" id="orgpaycreditcard" placeholder="5199 - 3924 - 2100 - 5430" class="form-control" maxlength="16">
                                                <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fab fa-cc-visa mx-1"></i> <i class="fab fa-cc-mastercard mx-1"></i> <i class="fab fa-cc-amex mx-1"></i> </span> </div>
                                            </div>
                                        </div>
                                    </div>


                                    
                                    
                                    <div class="card-footer"> <button type="submit" class="subscribe btn btn-primary btn-block shadow-sm"> Receive Money </button>
                                </form>
                            </div>

                            @else


                            <div class="alert alert-danger">
                                No record for this invoice number
                            </div>

                            @endif

                        </div> <!-- End -->
                        
                    </div>
                </div>
            </div>
        </div>

    
        <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>

        @include('include.message')

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script src="{{ asset('pace/pace.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



    <script>

        $(document).ready(function(){

            $('#orgpaycreditcard').attr('value', '0');
            // Run Ajax
            currencyConvert();
        });

        $("#payment_method").change(function(){

            if($("#payment_method").val() == "EXBC Card"){
                $(".bizInfo").removeClass('disp-0');
                

                $(".bank_info").addClass('disp-0');
                $(".card_info").removeClass('disp-0');

                $("#accountname").val("NILL");
                $('#account_number').attr('value', '0');
                $("#bank_name").val("NILL");

            }
            else{
                $(".bizInfo").addClass('disp-0');

                $(".bank_info").removeClass('disp-0');
                $(".card_info").addClass('disp-0');

                $('#orgpaycreditcard').attr('value', '0');

            }
        });


        function currencyConvert(){

        $("#conversionamount").val("");

        var currency = "{{ $data['currencyCode'][0]->currencies[0]->code }}";
        var route = "{{ URL('Ajax/getconversion') }}";
        var thisdata = {currency: currency, amount: $("#amount_to_receive").val(), val: "receive"};

            setHeaders();
            jQuery.ajax({
            url: route,
            method: 'post',
            data: thisdata,
            dataType: 'JSON',
            success: function(result){

                if(result.message == "success"){
                    $("#conversionamount").val(result.data);
                }
                else{
                    $("#conversionamount").val("");
                }


            }

        });
    }

        //Set CSRF HEADERS
    function setHeaders(){
    jQuery.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': "{{csrf_token()}}"
      }
    });
 }

    </script>

  </body>
</html>