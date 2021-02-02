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

    <title>PaySprint | Payment</title>

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
                <h1 class="display-4">Send Money</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item"> <a data-toggle="pill" href="#credit-card" class="nav-link active "> <i class="fas fa-credit-card mr-2"></i> Be Payment Ready... </a> </li>
                                {{-- <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i class="fab fa-paypal mr-2"></i> Debit Card </a> </li>
                                <li class="nav-item"> <a data-toggle="pill" href="#net-banking" class="nav-link "> <i class="fas fa-mobile-alt mr-2"></i> EXBC Card </a> </li> --}}
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">

                            @if (isset($data))
                                
                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">
                                <form role="form" action="{{ route('orgPaymentInvoice') }}" method="POST" id="paymentForm">

                                    @csrf
                                    <input type="hidden" class="form-control" name="user_id" id="orgpayuser_id" value="{{ $data->ref_code }}">
                                    <input type="hidden" name="orgpayname" id="orgpayname" value="{{ $name }}"> 

                                    <input type="hidden" name="orgpayemail" id="orgpayemail" value="{{ $email }}">

                                    <div class="form-group">
                                        <div class="alert alert-info">
                                            <ul>
                                                <li>
                                                    Receiver's Name: <b>{{ $data->name }}</b>
                                                </li>
                                                <li>
                                                    Address: <b>{{ $data->address }}</b>
                                                </li>
                                                <li>
                                                    City: <b>{{ $data->city }}</b> | State/Province: <b>{{ $data->state }}</b>
                                                </li>
                                                <li>
                                                    Country: <b>{{ $data->country }}</b>
                                                </li>
                                            </ul>
                                        </div>

                                        
                                    </div>

                                    
                                    
                                    
                                        <div class="form-group"> <label for="orgpayservice">
                                            <h6>Purpose of Payment</h6>
                                        </label>
                                        <div class="input-group"> 
                                            <select name="service" id="orgpayservice" class="form-control" required>
                                                <option value="">Select Option</option>
                                                <option value="Offering">Offering</option>
                                                <option value="Tithe">Tithe</option>
                                                <option value="Seed">Seed</option>
                                                <option value="Contribution">Contribution</option>
                                                <option value="Others">Others</option>
                                            </select>
                                            
                                        </div>
                                    </div>


                                        <div class="form-group others disp-0"> <label for="orgpaypurpose">
                                            <h6>Specify Purpose</h6>
                                        </label>
                                        <div class="input-group"> 
                                            <input type="text" name="purpose" id="orgpaypurpose" placeholder="Specify Purpose" class="form-control">
                                            
                                        </div>
                                    </div>
                                        
                                    
                                    <div class="form-group"> <label for="make_payment_method">
                                            <h6>Payment Method</h6>
                                        </label>
                                        <div class="input-group"> 
                                            <select name="payment_method" id="make_payment_method" class="form-control" required>
                                                <option value="Credit Card">Credit Card</option>
                                                {{--  <option value="Debit Card">Debit Card</option>  --}}
                                                <option value="EXBC Card">EXBC Card</option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group"> <label for="currency">
                                            <h6>Currency</h6>
                                        </label>
                                        <div class="input-group"> 
                                            <select name="currency" id="currency" class="form-control">
                                                <option value="CAD">CAD</option>
                                                <option value="USD">USD</option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group"> <label for="orgpayamount">
                                            <h6>Amount to Pay</h6>
                                        </label>
                                        <div class="input-group"> <input type="number" name="amount" id="orgpayamount" placeholder="50.00" class="form-control" maxlength="16" required>
                                            <input type="hidden" name="amounttosend" id="amounttosend" value="">
                                            <input type="hidden" name="commissiondeduct" id="commissiondeduct" value="">
                                            <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fas fa-money-check mx-1"></i> <i class="fab fa-cc-mastercard mx-1"></i> <i class="fab fa-cc-amex mx-1"></i> </span> </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                    <div class="input-group"> 
                                        <p style="color: red; font-weight: bold;"><input type="checkbox" name="commission" id="commission"> Payment with commission</p>
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="commissionInfo"></div>
                                </div>

                                    <div class="form-group"> <label for="orgpaycreditcard">
                                            <h6>Card number</h6>
                                        </label>
                                        <div class="input-group"> <input type="number" name="creditcard_no" id="orgpaycreditcard" placeholder="5199 - 3924 - 2100 - 5430" class="form-control" maxlength="16" required>
                                            <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fab fa-cc-visa mx-1"></i> <i class="fab fa-cc-mastercard mx-1"></i> <i class="fab fa-cc-amex mx-1"></i> </span> </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group"> <label><span class="hidden-xs">
                                                        <h6>Month</h6>
                                                    </span></label>
                                                <div class="input-group"> <select name='month' id="orgmonth" class='form-control'>
                                                    <option selected value='01'>January</option>
                                                    <option value='02'>February</option>
                                                    <option value='03'>March</option>
                                                    <option value='04'>April</option>
                                                    <option value='05'>May</option>
                                                    <option value='06'>June</option>
                                                    <option value='07'>July</option>
                                                    <option value='08'>August</option>
                                                    <option value='09'>September</option>
                                                    <option value='10'>October</option>
                                                    <option value='11'>November</option>
                                                    <option value='12'>December</option>
                                                </select>
                                            </div>

                                        </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label><span class="hidden-xs">
                                                    <h6>Year</h6>
                                                </span></label>
                                                <div class="input-group">
                                                    <select name='expirydate' id="orgpayyear" class='form-control'>
                                                        @for ($i = 21; $i <= 50; $i++)
                                                        <option value='{{ $i }}'>{{ $i }}</option>
                                                        @endfor
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group mb-4"> <label data-toggle="tooltip" title="Three digit CV code on the back of your card">
                                                    <h6>CVV <i class="fa fa-question-circle d-inline"></i></h6>
                                                </label> <input type="number" required class="form-control" name="cvv" placeholder="435"> </div>
                                        </div>
                                    </div>
                                    <div class="card-footer"> <button type="button" onclick="orgmonerisPay()" class="subscribe btn btn-primary btn-block shadow-sm"> Confirm Payment </button>
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
            $(function() {
                $('[data-toggle="tooltip"]').tooltip();


                $("#orgpayamount").on("keyup", function() {
                    runCommission();
                });

                });

$('#orgpayservice').change(function(){
    if($('#orgpayservice').val() == "Others"){
        $('.others').removeClass('disp-0');
    }
    else{
        $('.others').addClass('disp-0');
    }
});

// Moneris Payment
function orgmonerisPay(){
    var name = $('#orgpayname').val();
    var email = $('#orgpayemail').val();
    var user_id = $('#orgpayuser_id').val();
    var service = $('#orgpayservice').val();
    var purpose = $('#orgpaypurpose').val();
    var amount = $('#orgpayamount').val();
    var month = $('#orgmonth').val();
    var expirydate = $('#orgpayyear').val();
    var payment_method = $('#payment_method').val();
    var creditcard_no = $('#orgpaycreditcard').val();

    if(service == ""){
        swal('Oops!', 'Please select payment purpose', 'info');
        return false;
    }
    else if(amount == ""){
        swal('Oops!', 'Please enter amount', 'info');
        return false;
    }
    else if(month == ""){
        swal('Oops!', 'Please select month', 'info');
        return false;
    }

    else if(payment_method == ""){
        swal('Oops!', 'Please select payment method', 'info');
        return false;
    }
    else if(creditcard_no == ""){
        swal('Oops!', 'Please insert card number', 'info');
        return false;
    }

    else if(creditcard_no.length != 16){
        swal('Oops!', 'Invalid card number', 'info');
        return false;
    }
    else if(expirydate == ""){
        swal('Oops!', 'Please select year', 'info');
        return false;
    }
    else{


        $("#paymentForm").submit();

            
    }


}





$('#commission').click(function(){
    runCommission();
});


function runCommission(){
    
    $('.commissionInfo').html("");

    var route = "{{ URL('Ajax/getCommission') }}";
    var thisdata = {check: $('#commission').prop("checked"), amount: $('#orgpayamount').val()};

    if($('#orgpayamount').val() == ""){
        swal("Oops", "Please provide amount to send", "info");
    }
    else{
        
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

            if(result.message == "success"){

                if(result.state == "commission available"){

                    $('.commissionInfo').addClass('alert alert-success');
                    $('.commissionInfo').removeClass('alert alert-danger');

                    $('.commissionInfo').html("<ul><li><span style='font-weight: bold;'>Amount to send: "+result.data+"</span></li><li><span style='font-weight: bold;'>Commission: "+result.collection+"</span></li></ul>");

                    $("#amounttosend").val(result.data);
                    $("#commissiondeduct").val(result.collection);
                }
                else{

                    $('.commissionInfo').addClass('alert alert-danger');
                    $('.commissionInfo').removeClass('alert alert-success');

                    $('.commissionInfo').html("<ul><li><span style='font-weight: bold;'>Kindly note that a commission charge of: "+result.collection+" will be deducted from your credit card.</span></li></li></ul>");

                    $("#amounttosend").val(result.data);
                    $("#commissiondeduct").val(result.collection);

                }


            }


        }

    });

    });
    }
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