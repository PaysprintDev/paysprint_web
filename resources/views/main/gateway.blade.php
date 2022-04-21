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

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

<script src="https://kit.fontawesome.com/384ade21a6.js"></script>

    <title>PaySprint | {{ Request::get('gateway').' Gateway' }}</title>

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
            <div class="col-lg-10 mx-auto text-center">
                <h1 class="display-4">{{ Request::get('gateway').' Gateway' }}</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-10 mx-auto">
                
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

                                <center>
                                    <div class="row">

                                        @if (Auth::user()->country != 'Nigeria')
                                            <div @if (Auth::user()->country != 'Canada') class="col-md-6 mb-3" @else class="col-md-3 mb-3" @endif>
                                                <strong>
                                                    <a type="button" class="btn btn-warning" style="color: purple; font-weight: bold; background-color: #fff !important;" href="{{ route('Add card', 'card=Credit Card') }}"><img src="https://img.icons8.com/fluent/53/000000/credit-card-cash-withdrawal.png" title="Credit Card"/> <i class="fas fa-plus-square" title="Credit Card" style="font-size: 16px; color: black"></i><br><br>
                                                    Credit Card</a>
                                                </strong>
                                            </div>
                                        @endif
                                    

                                    @if (Auth::user()->country == 'Canada')
                                        <div class="col-md-3 mb-3">
                                            <strong>
                                                <a type="button" class="btn btn-warning" style="color: purple; font-weight: bold; background-color: #fff !important; font-size: 15px;" href="{{ route('Add card', 'card=Debit Card') }}"><img src="https://img.icons8.com/color/53/000000/bank-card-front-side.png" title="Debit VISA/Mastercard"/> <i class="fas fa-plus-square" title="Debit VISA/Mastercard" style="font-size: 16px; color: black"></i><br><br>
                                                Debit VISA/Mastercard</a>
                                            </strong>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <strong>
                                                <a type="button" class="btn btn-warning" style="color: purple; font-weight: bold; background-color: #fff !important;" href="{{ route('Add card', 'card=Prepaid Card') }}"> <img src="https://img.icons8.com/cotton/53/000000/bank-cards--v2.png" title="Prepaid Card"/> <i class="fas fa-plus-square" title="Prepaid Card" style="font-size: 16px; color: black"></i><br><br>Prepaid Card</a>
                                            </strong>
                                        </div>
                                    @endif


                                    @if (Auth::user()->country == 'Nigeria')
                                        <div class="col-md-6 mb-3">
                                            <strong>
                                                <a type="button" class="btn btn-warning" style="color: purple; font-weight: bold; background-color: #fff !important; font-size: 15px;" href="{{ route('Add card', 'card=Debit Card') }}"><img src="https://img.icons8.com/color/53/000000/bank-card-front-side.png" title="Debit VISA/Mastercard"/> <i class="fas fa-plus-square" title="Debit VISA/Mastercard" style="font-size: 16px; color: black"></i><br><br>
                                                Debit VISA/Mastercard</a>
                                            </strong>
                                        </div>
                                        
                                    @endif

                                    


                                    <div @if (Auth::user()->country != 'Canada') class="col-md-6 mb-3" @else class="col-md-3 mb-3" @endif>
                                        <strong>

                                            <a type="button" class="btn btn-warning" style="color: purple; font-weight: bold; background-color: #fff !important;" href="{{ route('Add bank detail') }}"> <img src="https://img.icons8.com/dusk/53/000000/merchant-account.png" title="Bank Account"/> <i class="fas fa-plus-square" title="Bank Account" style="font-size: 16px; color: black"></i><br><br>Bank Account</a>
                                        </strong>
                                    </div>
                                </div>

                                    
                                </center>
                                    
                                
                        </div> <!-- End -->
                            
                    </div>
                    
                </div>

                
            </div>

            <p class="text-center mt-4">
                <strong><img src="https://img.icons8.com/cotton/40/000000/cloud-alert.png"/> Note: Name on the Card or Bank Account must match your PaySprint profile</strong>
            </p>
        </div>

    
        <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>

        @include('include.message')


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script src="{{ asset('pace/pace.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


  </body>
</html>