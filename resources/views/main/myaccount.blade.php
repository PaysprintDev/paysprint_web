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

    <title>PaySprint | Wallet</title>

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
                <h1 class="display-4">My Account</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item"> <a data-toggle="pill" href="{{ route('home') }}" class="nav-link active "> <i class="fas fa-home"></i> Goto HomePage </a> </li>
                                {{-- <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i class="fab fa-paypal mr-2"></i> Debit Card </a> </li>
                                <li class="nav-item"> <a data-toggle="pill" href="#net-banking" class="nav-link "> <i class="fas fa-mobile-alt mr-2"></i> EXBC Card </a> </li> --}}
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">

                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">
                                    

                                    <div class="form-group row">

                                        <div class="col-md-12">
                                            <h5>Hello {{ (strlen($name) < 10) ? $name : substr($name, 0, 10)."." }},</h5>
                                            <p>
                                                {{ (date('A') == "AM") ? "Good Morning! Hope you took some coffee.☕" : "Good day! Remember to wash your hands.👏" }}
                                            </p>
                                        </div>

                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
                                            <div class="alert alert-info">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h4>
                                                                Total Withdrawals
                                                            </h4>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <h4>
                                                                {{ number_format(Auth::user()->number_of_withdrawals) }}
                                                            </h4>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>

                                        
                                    </div>

                                    
                                    
                                    
                                    <div class="form-group row"> 
                                        <div class="col-md-6">
                                            <button class="btn btn-info btn-block">Add Money <i class="fa fa-plus"></i></button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-secondary btn-block">Withdraw Money <i class="fa fa-credit-card"></i></button>
                                        </div>
                                    </div>

                                    

                                    <div class="form-group"> 
                                        <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Wallet Statement <i class="fas fa-circle text-secondary"></i></button>
                                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Credit <i class="fas fa-circle text-success"></i></button>
                                                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Debit <i class="fas fa-circle text-danger"></i></button>
                                                </div>
                                        </nav>
                                        <br>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <div class="container">
                                                    <div class="table table-responsive">
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                <tr>
                                                                    <td><i class="fas fa-circle text-success"></i></td>
                                                                    <td>Received credit from Jane Doe</td>
                                                                    <td>+500.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><i class="fas fa-circle text-danger"></i></td>
                                                                    <td>Transfered to Jane Doe</td>
                                                                    <td>-200.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><i class="fas fa-circle text-success"></i></td>
                                                                    <td>Credit to wallet</td>
                                                                    <td>+20.00</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                <div class="container">
                                                    <div class="table table-responsive">
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                <tr>
                                                                    <td><i class="fas fa-circle text-success"></i></td>
                                                                    <td>Received credit from Jane Doe</td>
                                                                    <td>+500.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><i class="fas fa-circle text-success"></i></td>
                                                                    <td>Credit to wallet</td>
                                                                    <td>+20.00</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                                <div class="container">
                                                    <div class="table table-responsive">
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                
                                                                <tr>
                                                                    <td><i class="fas fa-circle text-danger"></i></td>
                                                                    <td>Transfered to Jane Doe</td>
                                                                    <td>-200.00</td>
                                                                </tr>
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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