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

    <title>PaySprint | Money Transfer</title>

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
            <div class="col-lg-6 mx-auto">
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

                                    
                                    
                                    
                                    <div class="form-group"> <label for="card_id">
                                            <h6>Select Card</h6>
                                        </label>
                                        <div class="input-group"> 
                                            <div class="input-group-append"> <span class="input-group-text text-muted"> <img src="https://img.icons8.com/fluent/20/000000/bank-card-back-side.png"/> </span> </div>
                                            <select name="card_id" id="card_id" class="form-control" required>
                                                @if (count($data['getCard']) > 0)
                                                    @foreach ($data['getCard'] as $mycard)


                                                        <option value="{{ $mycard->id }}">{!! wordwrap($mycard->card_number, 4, '-', true) !!}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">Add a new card</option>
                                                @endif
                                            </select>
                                            
                                        </div>
                                    </div>


                                        
                                    
                                    
                                    <div class="form-group"> <label for="amount">
                                            <h6>Amount to Withdraw</h6>
                                        </label>
                                        <div class="input-group"> <div class="input-group-append"> <span class="input-group-text text-muted"> {{ $data['currencyCode'][0]->currencies[0]->symbol }} </span> </div> <input type="number" min="0.00" max="10000.00" step="0.01" name="amount" id="amount" class="form-control" required>
                                            
                                        </div>
                                    </div>

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
                                                        <h6>Login Password <br> <small class="text-danger">We need to be sure it's you</small></h6>
                                                    </label>
                                                    <div class="input-group"> <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fas fa-lock"></i> </span> </div> <input type="password" name="password" id="password" class="form-control" required>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    

                                        
                                    @endif


                                    <input type="hidden" name="currencyCode" class="form-control" id="curCurrency" value="{{ $data['currencyCode'][0]->currencies[0]->code }}" readonly>

                                    <input type="hidden" name="mode" class="form-control" id="mode" value="live" readonly>

                                    <div class="card-footer"> 
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" onclick="handShake('withdrawmoney')" class="subscribe btn btn-primary btn-block shadow-sm withdrawmoneyBtn"> Withdraw Money </button>
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
function handShake(val){

var route;

var formData = new FormData(formElem);

if('withdrawmoney'){

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
                    setTimeout(function(){ location.href="{{ route('my account') }}"; }, 2000);
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