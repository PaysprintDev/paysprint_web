<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <!-- Favicon -->
<link rel="icon" href="https://res.cloudinary.com/pilstech/image/upload/v1618251695/paysprint_icon_new_kg2h3j.png" type="image/x-icon" />

<link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />

<script src="https://kit.fontawesome.com/384ade21a6.js"></script>

    <title>PaySprint | Airtime & Utility</title>

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
                <h1 class="display-4">{{ $pages }}</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item"> <a data-toggle="pill" href="{{ route('utility bills') }}" class="nav-link active "> <i class="fas fa-home"></i> Go Back </a> </li>
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">


                            @if (isset($data))

                            {{-- 234-90695 --}}
                                
                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">
                                <form role="form" action="#" method="POST" id="formElem">
                                    @csrf
                                    
                                    <div class="form-group">
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

                                    
                                    
                                    @if (count($data['getCard']) > 0)
                                    <div class="form-group"> <label for="card_id">
                                            <h6>Select Card Type/ Bank Account</h6>
                                        </label>
                                        <div class="input-group"> 
                                            <div class="input-group-append"> <span class="input-group-text text-muted"> <img src="https://img.icons8.com/cotton/20/000000/money--v4.png"/> </span> </div>
                                            <select name="card_type" id="card_type" class="form-control" required>
                                                <option value="">Select option</option>
                                                {{-- <option value="Credit Card">Credit Card</option> --}}
                                                <option value="Debit Card">Debit Visa/Mastercard</option>
                                                {{-- <option value="Prepaid Card">Prepaid Card</option> --}}
                                                 {{-- <option value="Bank Account">Bank Account</option>  --}}
                                            </select>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group"> <label for="card_id">
                                            <h6>Select Card/Bank</h6>
                                        </label>
                                        <div class="input-group"> 
                                            <div class="input-group-append"> <span class="input-group-text text-muted"> <img src="https://img.icons8.com/fluent/20/000000/bank-card-back-side.png"/> </span> </div>
                                            <select name="card_id" id="card_id" class="form-control" required>
                                                
                                            </select>
                                            
                                        </div>
                                    </div>

                                    @else

                                    <div class="form-group"> <label for="amount">
                                                <h5>Add a new card</h5>
                                            </label>

                                            <form action="#" method="POST" id="formCardElem">
                                           @csrf

                                           <div class="form-group">
                                               <label for="card_number">Card Number</label>

                                            <div class="input-group"> <input type="text" name="card_number" id="card_number" class="form-control" maxlength="16" required>
                                                <div class="input-group-append"> 
                                                    <span class="input-group-text text-muted"> <i class="fas fa-money-check mx-1"></i> <i class="fab fa-cc-mastercard mx-1"></i> <i class="fab fa-cc-amex mx-1"></i> </span> 
                                                </div>
                                            </div>

                                           </div>
                                           <div class="form-group">

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="month">Month</label>

                                                    <div class="input-group"> 
                                                        <select name="month" id="month" class="form-control" required>
                                                            <option value="01">January</option>
                                                            <option value="02">February</option>
                                                            <option value="03">March</option>
                                                            <option value="04">April</option>
                                                            <option value="05">May</option>
                                                            <option value="06">June</option>
                                                            <option value="07">July</option>
                                                            <option value="08">August</option>
                                                            <option value="09">September</option>
                                                            <option value="10">October</option>
                                                            <option value="11">November</option>
                                                            <option value="12">December</option>
                                                        </select>
                                                        <div class="input-group-append"> 
                                                            <span class="input-group-text text-muted"> <i class="fas fa-table"></i> </span> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="year">Year</label>

                                                    <div class="input-group"> 
                                                        <select name="year" id="year" class="form-control" required>
                                                            @for ($i = date('y'); $i <= date('y')+10; $i++)
                                                                <option value="{{ $i }}">{{ "20".$i }}</option>
                                                            @endfor
                                                        </select>
                                                        <div class="input-group-append"> 
                                                            <span class="input-group-text text-muted"> <i class="fas fa-calendar-week"></i> </span> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="month">CVV <small class="text-danger">3 digit at the back of your card</small></label>

                                                    <div class="input-group"> 
                                                        <input type="password" name="cvv" id="cvv" class="form-control" maxlength="3" required>
                                                        <div class="input-group-append"> 
                                                            <span class="input-group-text text-muted"> <i class="fas fa-closed-captioning"></i> </span> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                               

                                           </div>


                                           <div class="form-group">
                                               <button type="button" class="btn btn-primary btn-block" onclick="handShake('addcard')" id="cardSubmit">Submit</button>
                                           </div>

                                       </form>
                                        </div>


                                    @endif

                                        

                                    @foreach ($data['getutilityproduct'] as $dataProduct)

                                        <div class="form-group"> <label for="amount">
                                            <h6>{{ $dataProduct->FieldName }}</h6>
                                            </label>
                                            <div class="input-group">
                                                
                                                @if (isset($dataProduct->ListItems))

                                                @if ($dataProduct->FieldName == "Number of Months")
                                                    <select name="{{ $dataProduct->PaymentInputKey }}" id="{{ $dataProduct->PaymentInputKey }}" class="form-control">
                                                        @foreach ($dataProduct->ListItems as $listItem)
                                                            <option value="{{ $listItem->ItemType }}">{{ $listItem->ItemName.' month' }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <select name="{{ $dataProduct->PaymentInputKey }}" id="{{ $dataProduct->PaymentInputKey }}" class="form-control">
                                                        @foreach ($dataProduct->ListItems as $listItem)
                                                            <option value="{{ $listItem->ItemType }}">{{ $listItem->ItemName.': '.Auth::user()->currencySymbol.$listItem->Amount.' ('.$listItem->ItemDesc.')' }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif

                                                    

                                                @else

                                                
                                                    @if ($dataProduct->FieldName == "Email")
                                                        <div class="input-group-append"> </div> <input type="text" name="{{ $dataProduct->PaymentInputKey }}" id="{{ $dataProduct->PaymentInputKey }}" class="form-control" readonly value="{{ Auth::user()->email }}">
                                                    @elseif ($dataProduct->FieldName == "Amount")
                                                        <div class="input-group-append"> </div> <input type="number" min="0.00" max="{{ $dataProduct->MaxAmount }}" step="0.01" name="{{ $dataProduct->PaymentInputKey }}" id="{{ $dataProduct->PaymentInputKey }}" class="form-control" required>
                                                    @else
                                                        <div class="input-group-append"> </div> <input type="text" name="{{ $dataProduct->PaymentInputKey }}" id="{{ $dataProduct->PaymentInputKey }}" class="form-control" required>
                                                    @endif

                                                @endif

                                                

                                            </div>
                                        </div>


                                    @endforeach
                                        

                                    
                                    
                                   

                                    @if (Auth::user()->transaction_pin != null)

                                    <div class="form-group"> <label for="transaction_pin">
                                            <h6>Transaction Pin</h6>
                                        </label>
                                        <div class="input-group"> <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fas fa-lock"></i> </span> </div> <input type="password" name="transaction_pin" id="transaction_pin" class="form-control" maxlength="4" required>
                                            
                                        </div>
                                    </div>

                                    @else
                                    <hr>
                                    <h5>
                                        Set up transaction pin
                                    </h5>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group"> <label for="new_transaction_pin">
                                                    <h6>New Transaction Pin</h6>
                                                </label>
                                                <div class="input-group"> <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fas fa-lock"></i> </span> </div> <input type="password" name="transaction_pin" id="new_transaction_pin" class="form-control" maxlength="4" required>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group"> <label for="confirm_transaction_pin">
                                                    <h6>Confirm Transaction Pin</h6>
                                                </label>
                                                <div class="input-group"> <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fas fa-lock"></i> </span> </div> <input type="password" name="confirm_transaction_pin" id="confirm_transaction_pin" class="form-control" maxlength="4" required>
                                                    
                                                </div>
                                            </div>
                                        </div>


                                            <div class="col-md-12">
                                                <div class="form-group"> <label for="password">
                                                        <h6>Provide Your Login Password <br> <small class="text-danger">We need to be sure it's you</small></h6>
                                                    </label>
                                                    <div class="input-group"> <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fas fa-lock"></i> </span> </div> <input type="password" name="password" id="password" class="form-control" required>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    

                                        
                                    @endif


                                    <div class="card-footer"> 
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" onclick="handShake('payutility')" class="subscribe btn btn-primary btn-block shadow-sm payutilityBtn"> Pay </button>
                                            </div>
                                        </div>
                                    
                                    
                                    </div>

                                </form>
                            </div>

                            @else


                            <div class="alert alert-danger">
                                Something went wrong, Please try again in 24 hours
                            </div>

                            @endif

                        </div> <!-- End -->
                        
                    </div>
                </div>
            </div>
        </div>

    
        <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>

        @include('include.message')


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>

    <script src="{{ asset('pace/pace.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script>


$(function() {

$("#amount").on("keyup", function() {
    runCommission();
});


});

$('#card_type').change(function(){
    runCardType();

    if($("#amount").val() != ""){
        runCommission();
    }
});


function runCardType(){

    $('#card_id').html("");

    var route = "{{ URL('/api/v1/getmycarddetail') }}";
    var thisdata = {card_provider: $('#card_type').val()};


    Pace.restart();
    Pace.track(function(){

        setHeaders();
        
        jQuery.ajax({
        url: route,
        method: 'get',
        data: thisdata,
        dataType: 'JSON',
        
        success: function(result){
            if(result.message == "success"){
                var res = result.data;

                console.log(res);

                if(result.action == "Bank Account"){
                    $.each(res, function(v, k){
                        $('#card_id').append(`<option value="${k.id}">${k.bankName} - ${k.accountNumber}</option>`);
                    });
                }
                else{
                    $.each(res, function(v, k){
                        $('#card_id').append(`<option value="${k.id}">${k.card_number} - ${k.card_provider}</option>`);
                    });
                }


                

            }
            else{
                $('#card_id').append(`<option value="">${$('#card_type').val()} not available</option>`);
            }

        },
        error: function(err) {
            $('#card_id').append(`<option value="">${$('#card_type').val()} not available</option>`);
            // swal("Oops", err.responseJSON.message, "error");
        } 

    });

    });

}

function runCommission(){
    
    $('.commissionInfo').html("");
    var amount = $("#amount").val();
    var structure;

    if($('#card_type').val() == "Prepaid Card"){
        structure = "EXBC Prepaid Card";
    }
    else{
        structure = "CC/Bank";
    }


    var route = "{{ URL('Ajax/getCommission') }}";
    var thisdata = {check: $('#commission').prop("checked"), amount: amount, pay_method: $('#card_type').val(), localcurrency: "{{ $data['currencyCode'][0]->currencies[0]->code }}", foreigncurrency: "USD", structure: "Withdrawal", structureMethod: structure};


    Pace.restart();
    Pace.track(function(){

        setHeaders();
        
        jQuery.ajax({
        url: route,
        method: 'post',
        data: thisdata,
        dataType: 'JSON',
        beforeSend: function(){
            $('.commissionInfo').addClass('');
        },
        
        success: function(result){

            var totalCharge;

            if(result.message == "success"){


                $(".wallet-info").html(result.walletCheck);
                $('.withWallet').removeClass('disp-0');

                if(result.walletCheck != ""){
                    $(".sendmoneyBtn").attr("disabled", true);
                    

                }
                else{
                    $(".sendmoneyBtn").attr("disabled", false);
                }


                if(result.state == "commission available"){

                    $('.commissionInfo').addClass('alert alert-success');
                    $('.commissionInfo').removeClass('alert alert-danger');

                    $('.commissionInfo').html("<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['currencyCode'][0]->currencies[0]->symbol }}"+result.data.toFixed(2)+" will be credited to your "+$('#card_type').val()+". Fee charge inclusive</span></li></li></ul>");

                    $("#amounttosend").val(result.data);
                    $("#commissiondeduct").val(result.collection);

                    $("#totalcharge").val(result.data);

                    totalCharge = $("#amount").val();


                    currencyConvert(totalCharge);


                }
                else{

                    $('.commissionInfo').addClass('alert alert-danger');
                    $('.commissionInfo').removeClass('alert alert-success');

                    $('.commissionInfo').html("<ul><li><span style='font-weight: bold;'>Kindly note that a total amount of: {{ $data['currencyCode'][0]->currencies[0]->symbol }}"+(+result.data + +result.collection).toFixed(2)+" will be charged from your "+$('#card_type').val()+".</span></li></li></ul>");

                    $("#amounttosend").val(result.data);
                    $("#commissiondeduct").val(result.collection);
                    $("#totalcharge").val((+result.data + +result.collection));

                    totalCharge = $("#amount").val();


                    currencyConvert(totalCharge);

                }


            }


        }

    });

    });
}


function currencyConvert(amount){

    $("#conversionamount").val("");

    var currency = "CAD";
    var localcurrency = "{{ $data['currencyCode'][0]->currencies[0]->code }}";
    var route = "{{ URL('Ajax/getconversion') }}";
    var thisdata = {currency: currency, amount: amount, val: "send", localcurrency: localcurrency};

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


function handShake(val){

var route;

var formData;

if(val == 'withdrawmoney'){

    formData = new FormData(formElem);

    route = "{{ URL('/api/v1/moneywithdrawal') }}";

        Pace.restart();
    Pace.track(function(){
        setHeaders();
        jQuery.ajax({
        url: route,
        method: 'post',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        beforeSend: function(){
            $('.withdrawmoneyBtn').text('Please wait...');
        },
        success: function(result){
            console.log(result);

            $('.withdrawmoneyBtn').text('Withdraw Money');

            if(result.status == 200){
                    swal("Success", result.message, "success");
                    setTimeout(function(){ location.href="{{ route('my account') }}"; }, 15000);
                }
                else{
                    swal("Oops", result.message, "error");
                }

        },
        error: function(err) {
            $('.withdrawmoneyBtn').text('Withdraw Money');
            swal("Oops", err.responseJSON.message, "error");

        } 

    });
    });

}

else if(val == 'addcard'){
    formData = new FormData();

    formData.append('card_number', $("#card_number").val());
    formData.append('month', $("#month").val());
    formData.append('year', $("#year").val());
    formData.append('cvv', $("#cvv").val());

        route = "{{ URL('/api/v1/addnewcard') }}";

        Pace.restart();
    Pace.track(function(){
        setHeaders();
        jQuery.ajax({
        url: route,
        method: 'post',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        beforeSend: function(){
            $('#cardSubmit').text('Please wait...');
        },
        success: function(result){
            console.log(result);

            $('#cardSubmit').text('Submit');

            if(result.status == 200){
                    swal("Success", result.message, "success");
                    setTimeout(function(){ location.reload(); }, 2000);
                }
                else{
                    swal("Oops", result.message, "error");
                }

        },
        error: function(err) {
            swal("Oops", err.responseJSON.message, "error");

        } 

    });
    });

}

}

function goBack() {
  window.history.back();
}


function setHeaders(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}",
            'Authorization': "Bearer "+"{{ Auth::user()->api_token }}"
        }
        });

}


        </script>

  </body>
</html>