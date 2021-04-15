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

    <title>PaySprint | Card</title>

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
                <h1 class="display-4">Edit Card</h1>
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
                                    

                                    <div class="form-group row">

                                        @if (isset($data['getthisCard']))


                                        

                                        @switch($data['getthisCard']->card_type)
                                                @case("Mastercard")
                                                    @php
                                                        $alertInfo = "alert-danger";
                                                        $cardImage = '<img src="https://img.icons8.com/color/30/000000/mastercard.png"/>';
                                                    @endphp
                                                    @break
                                                @case("Visa")
                                                    @php
                                                        $alertInfo = "alert-info";
                                                        $cardImage = '<img src="https://img.icons8.com/color/30/000000/visa.png"/>';
                                                    @endphp
                                                    @break
                                                @default
                                                    @php
                                                        $alertInfo = "alert-success";
                                                        $cardImage = '<img src="https://img.icons8.com/fluent/30/000000/bank-card-back-side.png"/>';
                                                    @endphp
                                            @endswitch

                                        <div class="col-md-6">
                                            
                                            <div class="alert {{ $alertInfo }}">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h4>
                                                                {{ wordwrap($data['getthisCard']->card_number, 4, ' - ', true) }}
                                                            </h4>
                                                        </div>
                                                        <br>
                                                        <div class="col-md-6">
                                                            <h6>
                                                               Expiry: {{ $data['getthisCard']->month."/".$data['getthisCard']->year }}
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>
                                                               CVV: ***
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="hidden" name="card_id" value="{{ $data['getthisCard']->id }}" id="card_id">
                                                            <a href="#" title="Edit Card"><i class="far fa-edit text-secondary"></i></a>
                                                            <a href="javascript:void(0)" title="Delete Card" onclick="handShake('deletecard')"><i class="far fa-trash-alt text-danger"></i></a>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {!! $cardImage !!}
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        
                                            
                                            
                                        @else

                                        <div class="col-md-12">
                                            <div class="alert alert-info">
                                                        <center>
                                                            <div class="row">
                                                            <div class="col-md-12">
                                                                <h4>
                                                                   Card not found!!!
                                                                </h4>
                                                                
                                                            </div>
                                                        </div>
                                                        </center>
                                            </div>
                                        </div>
                                            
                                        @endif

                                        

                                        
                                    </div>

                                    
                                    @if (isset($data['getthisCard']))
                                    <div class="form-group"> 
                                       <form action="#" method="POST" id="formElem">
                                           @csrf

                                           <div class="form-group">
                                               <label for="card_name">Name on Card</label>

                                               <input type="hidden" name="id" value="{{ $data['getthisCard']->id }}">

                                            <div class="input-group"> <input type="text" name="card_name" id="card_name" value="{{ $data['getthisCard']->card_name }}" class="form-control" required>
                                                <div class="input-group-append"> 
                                                    <span class="input-group-text text-muted"> <i class="far fa-user"></i> </span> 
                                                </div>
                                            </div>

                                           </div>

                                           <div class="input-group"> 
                                                <select name="card_provider" id="card_provider" class="form-control" required>
                                                    <option value="">Select Card Issuer</option>
                                                    <option value="{{ $data['getthisCard']->card_provider }}" selected>{{ $data['getthisCard']->card_provider }}</option>
                                                    <option value="Credit Card">Credit Card</option>
                                                    @if (count($data['cardIssuer']) > 0)

                                                        @foreach ($data['cardIssuer'] as $cardIssuers)
                                                            <option value="{{ $cardIssuers->issuer_card }}">{{ $cardIssuers->issuer_card.' from '.$cardIssuers->issuer_name }}</option>
                                                        @endforeach

                                                    @else
                                                        <option value="EXBC Prepaid Card">EXBC Prepaid Card from EXBC</option>
                                                    @endif
                                                </select>
                                                <div class="input-group-append"> 
                                                    <span class="input-group-text text-muted"> <i class="fas fa-credit-card"></i></span> 
                                                </div>
                                            </div>

                                           <div class="form-group">
                                               <label for="card_number">Card Number</label>

                                            <div class="input-group"> <input type="text" name="card_number" id="card_number" value="{{ $data['getthisCard']->card_number }}" class="form-control" maxlength="16" required>
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

                                                            @switch($data['getthisCard']->month)
                                                                    @case("01")
                                                                        @php
                                                                            $month = "January";
                                                                        @endphp
                                                                        @break
                                                                    @case("02")
                                                                        @php
                                                                            $month = "February";
                                                                        @endphp
                                                                        @break
                                                                    @case("03")
                                                                        @php
                                                                            $month = "March";
                                                                        @endphp
                                                                        @break
                                                                    @case("04")
                                                                        @php
                                                                            $month = "April";
                                                                        @endphp
                                                                        @break
                                                                    @case("05")
                                                                        @php
                                                                            $month = "May";
                                                                        @endphp
                                                                        @break
                                                                    @case("06")
                                                                        @php
                                                                            $month = "June";
                                                                        @endphp
                                                                        @break
                                                                    @case("07")
                                                                        @php
                                                                            $month = "July";
                                                                        @endphp
                                                                        @break
                                                                    @case("08")
                                                                        @php
                                                                            $month = "August";
                                                                        @endphp
                                                                        @break
                                                                    @case("09")
                                                                        @php
                                                                            $month = "September";
                                                                        @endphp
                                                                        @break
                                                                    @case("10")
                                                                        @php
                                                                            $month = "October";
                                                                        @endphp
                                                                        @break
                                                                    @case("11")
                                                                        @php
                                                                            $month = "November";
                                                                        @endphp
                                                                        @break
                                                                    @case("12")
                                                                        @php
                                                                            $month = "December";
                                                                        @endphp
                                                                        @break
                                                                    @default
                                                                        @php
                                                                            $month = "January";
                                                                        @endphp
                                                                @endswitch

                                                            <option value="{{ $data['getthisCard']->month }}" selected>{{ $month }}</option>
                                                            
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
                                                            <option value="{{ $data['getthisCard']->year }}" selected>{{ "20".$data['getthisCard']->year }}</option>
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
                                               <button type="button" class="btn btn-primary btn-block" onclick="handShake('editcard')" id="cardSubmit">Submit</button>
                                           </div>

                                       </form>
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

if(val == 'editcard'){

var formData = new FormData(formElem);


    route = "{{ URL('/api/v1/editcard') }}";

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
                    setTimeout(function(){ location.href="{{ route('my account') }}"; }, 2000);
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


else if(val == "deletecard"){

    // Ask Are you sure

    swal({
  title: "Are you sure you want to delete card?",
  text: "This card will be deleted and can not be recovered!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    
    // Run Ajax

    var thisdata = {id: $("#card_id").val()};

    route = "{{ URL('/api/v1/deletecard') }}";

        Pace.restart();
    Pace.track(function(){
        setHeaders();
        jQuery.ajax({
        url: route,
        method: 'post',
        data: thisdata,
        dataType: 'JSON',
        
        success: function(result){

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


  } else {
    
  }
});

}

}


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