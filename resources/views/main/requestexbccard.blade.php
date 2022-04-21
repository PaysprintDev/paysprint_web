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

    <title>PaySprint | EXBC Card Request</title>

    <style>
        body {
    background: #f5f5f5
}

.rounded {
    border-radius: 1rem
}

.nav-pills .nav-link {
    color: rgb(255, 255, 255)
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
.fas{
    font-size: 12px;
}
    </style>

  </head>
  <body>
    <div class="container py-5">
        <!-- For demo purpose -->
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4">Get Prepaid Card</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item"> <a data-toggle="pill" href="{{ route('my account') }}" class="nav-link active "> <i class="fas fa-home"></i> Go Back </a> </li>
                                {{-- <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i class="fab fa-paypal mr-2"></i> Debit Card </a> </li>
                                <li class="nav-item"> <a data-toggle="pill" href="#net-banking" class="nav-link "> <i class="fas fa-mobile-alt mr-2"></i> EXBC Card </a> </li> --}}
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">

                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">
                                    
                                <div class="alert alert-warning">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5>
                                                        Wallet Balance
                                                    </h5>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4>
                                                        {{ Auth::user()->currencySymbol."".number_format(Auth::user()->wallet_balance, 2) }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>


                                    

                                    <div class="form-group cardform"> 
                                       <form action="#" method="POST" id="formElem">
                                           @csrf
                                           <div class="form-group">
                                               <label for="card_name">Card Provider</label>

                                            <div class="input-group"> 
                                                <select name="card_provider" id="card_provider" class="form-control" required>
                                                    <option value="">Select card provider</option>
                                                    <option value="EXBC Prepaid Card">EXBC Prepaid Card</option>
                                                </select>
                                                <div class="input-group-append"> 
                                                    <span class="input-group-text text-muted"> <i class="fas fa-credit-card"></i></span> 
                                                </div>
                                            </div>

                                           </div>
                                           <div class="form-group">
                                               <label for="card_name">Name that will be on the Card</label>

                                               <input type="hidden" name="ref_code" value="{{ Auth::user()->ref_code }}">
                                               <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                               <input type="hidden" name="address" value="{{ Auth::user()->address }}">
                                               <input type="hidden" name="city" value="{{ Auth::user()->city }}">
                                               <input type="hidden" name="province" value="{{ Auth::user()->state }}">
                                               <input type="hidden" name="postal_code" value="{{ Auth::user()->zip }}">
                                               <input type="hidden" name="country" value="{{ Auth::user()->country }}">
                                               <input type="hidden" name="amount" value="20">
                                               <input type="hidden" name="phone" value="{{ Auth::user()->code.Auth::user()->telephone }}">

                                            <div class="input-group"> <input type="text" name="name_on_card" id="name_on_card" class="form-control" required value="{{ Auth::user()->name }}" readonly>
                                                <div class="input-group-append"> 
                                                    <span class="input-group-text text-muted"> <i class="far fa-user"></i></span> 
                                                </div>
                                            </div>

                                           </div>
                                           
                                           <div class="form-group">

                                                <div class="alert alert-success cardInfo">
                                                     
                                                </div>

                                           </div>


                                           <div class="form-group">
                                               <button type="button" class="btn btn-primary btn-block" onclick="externalhandShake('requestexbccard')" id="cardSubmit">Submit Request</button>
                                           </div>

                                       </form>
                                    </div>


                            

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
            var textData = "Please select a card provider";

        $('#card_provider').change(function(){

            if($('#card_provider').val() != null){
                textData = "Amount payable to get "+$('#card_provider').val()+" is $20.00. This will be deducted from your wallet. "+$('#card_provider').val()+" issuer would issue the card using your name and address on file";
                $('.cardInfo').text(textData);
            }
        });

function externalhandShake(val){

var route;

if(val == 'requestexbccard'){

var formData = new FormData(formElem);

var walletBal = "{{ Auth::user()->wallet_balance }}";

var amount = 20;
var provider = $("#card_provider").val();



if(amount > walletBal){
    swal("Oops!", "Insufficient wallet fund.", "error");
}
else if(provider == ""){
    swal("Oops!", "Select Card Provider", "info");
}
else{
    route = "{{ URL('/api/v1/requestcard') }}";
    

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
        async: true,
        crossDomain: true,
        dataType: 'JSON',
        beforeSend: function(){
            $('#cardSubmit').text('Please wait...');
        },
        success: function(result){

            $('#cardSubmit').text('Submit');

            if(result.status == 200){
                swal("Success", result.message, "success");
                setTimeout(function(){ location.href = "{{ route('my account') }}"; }, 5000);
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


}


// function debitWalletForCard(provider){
//     var thisData = {ref_code: "{{ Auth::user()->ref_code }}", card_provider: provider};

//     var route = "{{ URL('/api/v1/debitwalletforcard') }}";

//     setHeaders();
//         jQuery.ajax({
//         url: route,
//         method: 'post',
//         data: thisData,
//         dataType: 'JSON',
        
//         success: function(result){

//             if(result.status == 200){
//                     swal("Success", result.message, "success");
//                     setTimeout(function(){ location.href = "{{ route('my account') }}"; }, 2000);
//                 }
//                 else{
//                     swal("Oops", result.message, "error");
//                 }

//         },
//         error: function(err) {
//             swal("Oops", err.responseJSON.message, "error");

//         } 

//     });

// }


function showForm(val){
    $(".cardform").removeClass('disp-0');
    $(".pickCard").addClass('disp-0');
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