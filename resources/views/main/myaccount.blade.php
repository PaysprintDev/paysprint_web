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

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

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
.nav-tabs .nav-link{
    border: 1px solid #6c757d !important;
    width: 20%;
}
    </style>

  </head>
  <body>
    <div class="container py-5">
        <!-- For demo purpose -->
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4">My Wallet</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-12 mx-auto">
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
                                                            <h6 class="font-sm">
                                                                Wallet Balance
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <h4>
                                                                {{ $data['currencyCode'][0]->currencies[0]->symbol."".number_format(Auth::user()->wallet_balance, 2) }}
                                                            </h4>
                                                        </div>
                                                    </div>
                                            </div>

                                            <p>

                                                @if (isset($data['getCard']) && count($data['getCard']) > 0)

                                                @php
                                                    $others = count($data['getCard']) - 1;
                                                    $cardNo = wordwrap($data['getCard'][0]->card_number, 4, '-', true);
                                                @endphp

                                                @switch($data['getCard'][0]->card_type)
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

                                                <div class="alert {{ $alertInfo }}">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6 class="font-sm">
                                                                {{ (strlen($cardNo) < 10) ? $cardNo : substr($cardNo, 0, 10)."***" }} {{ ($others > 0) ? "& ".$others." others" : "" }}

                                                                
                                                            </h6>
                                                        </div>
                                                        <br>
                                                        <div class="col-md-6">
                                                            <h6>
                                                               Expiry: {{ $data['getCard'][0]->month."/".$data['getCard'][0]->year }}
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>
                                                               CVV: ***
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6>
                                                                {{ (strlen($data['getCard'][0]->card_name) < 18) ? strtoupper($data['getCard'][0]->card_name) : substr(strtoupper($data['getCard'][0]->card_name), 0, 18)."..." }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            {!! $cardImage !!}
                                                        </div>
                                                    </div>
                                            </div>
                                                    
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <strong>
                                                            <a type="button" class="btn btn-warning" style="color: purple; font-weight: bold; background-color: #fff3cd !important; border-color: #fff3cd !important;" href="{{ route('Add card', 'card=Credit Card') }}">Add a new Credit Card <i class="fas fa-plus-square" title="Add Credit Card" style="font-size: 16px; color: black"></i></a>
                                                        </strong>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <strong>
                                                            <a type="button" class="btn btn-warning" style="color: purple; font-weight: bold; background-color: #d1ecf1 !important; border-color: #d1ecf1 !important;" href="{{ route('Add card', 'card=Prepaid Card') }}"> Add a new Prepaid Card <i class="fas fa-plus-square" title="Add Prepaid Card" style="font-size: 16px; color: black"></i></a>
                                                        </strong>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <strong>
                                                            {{--  <a type="button" class="btn btn-warning" style="color: #f7f7f7; font-weight: bold; background-color: #6c757d !important; border-color: #6c757d !important;" href="javascript:void()" onclick="comingSoon('bank')"> Add a new Bank Account <i class="fas fa-plus-square" title="Add card" style="font-size: 16px; color: black"></i></a>  --}}

                                                            <a type="button" class="btn btn-warning" style="color: #f7f7f7; font-weight: bold; background-color: #6c757d !important; border-color: #6c757d !important;" href="{{ route('Add bank detail') }}"> Add a new Bank Account <i class="fas fa-plus-square" title="Add Bank Account" style="font-size: 16px; color: black"></i></a>
                                                        </strong>
                                                    </div>
                                                </div>

                                                @else

                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <strong>
                                                            <a type="button" class="btn btn-warning" style="color: purple; font-weight: bold; background-color: #fff3cd !important; border-color: #fff3cd !important;" href="{{ route('Add card', 'card=Credit Card') }}">Add a new Credit Card <i class="fas fa-plus-square" title="Add Credit Card" style="font-size: 16px; color: black"></i></a>
                                                        </strong>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <strong>
                                                            <a type="button" class="btn btn-warning" style="color: purple; font-weight: bold; background-color: #d1ecf1 !important; border-color: #d1ecf1 !important;" href="{{ route('Add card', 'card=Prepaid Card') }}"> Add a new Prepaid Card <i class="fas fa-plus-square" title="Add Prepaid Card" style="font-size: 16px; color: black"></i></a>
                                                        </strong>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        {{-- {{ route('Add card', 'card=Bank Account') }} --}}
                                                        <strong>
                                                            {{--  <a type="button" class="btn btn-warning" style="color: #f7f7f7; font-weight: bold; background-color: #6c757d !important; border-color: #6c757d !important;" href="javascript:void()" onclick="comingSoon('bank')"> Add a new Bank Account <i class="fas fa-plus-square" title="Add card" style="font-size: 16px; color: black"></i></a>  --}}
                                                            <a type="button" class="btn btn-warning" style="color: #f7f7f7; font-weight: bold; background-color: #6c757d !important; border-color: #6c757d !important;" href="{{ route('Add bank detail') }}"> Add a new Bank Account <i class="fas fa-plus-square" title="Add Bank Account" style="font-size: 16px; color: black"></i></a>
                                                        </strong>
                                                    </div>
                                                </div>

                                                
                                                
                                                
                                                    
                                                @endif

                                                
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="alert alert-info">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6 class="font-sm">
                                                                Total Withdrawals
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <h4>
                                                                {{ number_format(Auth::user()->number_of_withdrawals) }}
                                                            </h4>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="alert alert-success">
                                                    <div class="row">
                                                        

                                                        @if (isset($data['getBank']) && count($data['getBank']) > 0)
                                                        
                                                        @php
                                                            $otherBanks = count($data['getBank']) - 1;
                                                            $accountNumber = $data['getBank'][0]->accountNumber;
                                                        @endphp

                                                            <div class="col-md-12">
                                                                <h6>
                                                                    {{ (strlen($accountNumber) < 15) ? $accountNumber : substr($accountNumber, 0, 15)."***" }} {{ ($otherBanks > 0) ? "& ".$otherBanks." others" : "" }}
                                                                </h6>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <h4>
                                                                    {{ $data['getBank'][0]->bankName }}
                                                                </h4>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>
                                                                Transit Number: {{ $data['getBank'][0]->transitNumber }}
                                                                </h6>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>
                                                                Branch Code: {{ $data['getBank'][0]->branchCode }}
                                                                </h6>
                                                            </div>

                                                        @else

                                                        <div class="col-md-12">
                                                            <h6 class="font-sm">
                                                                Bank Account
                                                                {{--  getBank  --}}
                                                            </h6>
                                                        </div>

                                                            <div class="col-md-12">
                                                                <h4>
                                                                    <a href="{{ route('Add bank detail') }}">Add your Bank Account</a>
                                                                </h4>
                                                            </div>

                                                        @endif
                                                        
                                                        <div class="row">
                                                        <div class="col-md-6">
                                                            <img src="https://img.icons8.com/emoji/30/000000/bank-emoji.png"/>
                                                        </div>
                                                    </div>
                                                    </div>
                                            </div>
                                        </div>

                                        
                                    </div>

                                    
                                    
                                    
                                    <div class="form-group row"> 
                                        <div class="col-md-6">
                                            <a type="button" href="{{ route('Add Money') }}" class="btn btn-info btn-block">Add Money <i class="fa fa-plus"></i></a>
                                        </div>

                                        @if (Auth::user()->approval == 1)
                                            <div class="col-md-6">
                                                <a type="button" href="{{ route('Withdraw Money') }}" class="btn btn-secondary btn-block">Withdraw Money <i class="fa fa-credit-card"></i></a>
                                            </div>
                                        @else

                                        <div class="col-md-6">
                                                <a type="button" href="javascript:void()" class="btn btn-secondary btn-block" onclick="restriction('withdrawal', '{{ Auth::user()->name }}')">Withdraw Money <i class="fa fa-credit-card"></i></a>
                                            </div>
                                            
                                        @endif

                                        
                                    </div>

                                    

                                    <div class="form-group"> 
                                        <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Wallet Statement <i class="fas fa-circle text-secondary"></i></button>
                                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Credit <i class="fas fa-circle text-success"></i></button>
                                                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Debit <i class="fas fa-circle text-danger"></i></button>
                                                    <button class="nav-link" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" onclick="location.href='{{ url('payorganization?type=local') }}'">Send Money <i class="fas fa-circle text-warning"></i></button>

                                                    @if (Auth::user()->country == "Canada")
                                                        <button class="nav-link" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" onclick="location.href='{{ route('request exbc card') }}'">Get a Prepaid Card <i class="fas fa-circle text-info"></i></button>
                                                    @endif

                                                    
                                                </div>
                                        </nav>
                                        <br>
                                        <div class="tab-content" id="nav-tabContent">

                                            @if (count($data['walletStatement']) > 0)

                                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <div class="container">
                                                    <div class="table table-responsive">
                                                        <table class="table table-striped" id="myTableAll">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Description</th>
                                                                    <th>Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($data['walletStatement'] as $walletstatements)

                                                                
                                                                    <tr>
                                                                        <td><i class="fas fa-circle {{ ($walletstatements->credit != 0) ? "text-success" : "text-danger" }}"></i></td>
                                                                        <td>

                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        {!! $walletstatements->activity !!}
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <small>
                                                                                            {{ $walletstatements->reference_code }}
                                                                                        </small><br>
                                                                                        <small>
                                                                                            {{ date('d/m/Y h:i a', strtotime($walletstatements->created_at)) }}
                                                                                        </small>
                                                                                    </div>
                                                                                </div>

                                                                            </td>
                                                                        <td style="font-weight: 700" class="{{ ($walletstatements->credit != 0) ? "text-success" : "text-danger" }}">{{ ($walletstatements->credit != 0) ? "+".$data['currencyCode'][0]->currencies[0]->symbol.number_format($walletstatements->credit, 2) : "-".$data['currencyCode'][0]->currencies[0]->symbol.number_format($walletstatements->debit, 2) }}</td>
                                                                    </tr>
                                                
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                <div class="container">
                                                    <div class="table table-responsive">
                                                        <table class="table table-striped" id="myTableCredit">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Description</th>
                                                                    <th>Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($data['walletStatement'] as $walletstatements)

                                                                    @if ($walletstatements->credit != 0)
                                                                        <tr>
                                                                            <td><i class="fas fa-circle text-success"></i></td>
                                                                            <td>

                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        {!! $walletstatements->activity !!}
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <small>
                                                                                            {{ $walletstatements->reference_code }}
                                                                                        </small><br>
                                                                                        <small>
                                                                                            {{ date('d/m/Y h:i a', strtotime($walletstatements->created_at)) }}
                                                                                        </small>
                                                                                    </div>
                                                                                </div>

                                                                            </td>
                                                                            <td style="font-weight: 700" class="text-success">{{ "+".$data['currencyCode'][0]->currencies[0]->symbol.number_format($walletstatements->credit, 2) }}</td>
                                                                        </tr>

                                                                    @endif
                                                                
                                                                    
                                                
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                                <div class="container">
                                                    <div class="table table-responsive">
                                                        <table class="table table-striped" id="myTableDebit">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Description</th>
                                                                    <th>Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                @foreach ($data['walletStatement'] as $walletstatements)

                                                                    @if ($walletstatements->debit != 0)
                                                                        <tr>
                                                                            <td><i class="fas fa-circle text-danger"></i></td>
                                                                            <td>

                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        {!! $walletstatements->activity !!}
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <small>
                                                                                            {{ $walletstatements->reference_code }}
                                                                                        </small><br>
                                                                                        <small>
                                                                                            {{ date('d/m/Y h:i a', strtotime($walletstatements->created_at)) }}
                                                                                        </small>
                                                                                    </div>
                                                                                </div>

                                                                            </td>
                                                                            <td style="font-weight: 700" class="text-danger">
                                                                                {{ "-".$data['currencyCode'][0]->currencies[0]->symbol.number_format($walletstatements->debit, 2) }}
                                                                            </td>
                                                                        </tr>

                                                                    @endif
                                                                
                                                                    
                                                
                                                                @endforeach
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>




                                                
                                            @else

                                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <div class="container">
                                                    <div class="table table-responsive">
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="3">No record</td>
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
                                                                    <td colspan="3">No record</td>
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
                                                                    <td colspan="3">No record</td>
                                                                </tr>
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                                
                                            @endif

                                            
                                            
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

        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script src="{{ asset('pace/pace.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



    <script>

        $(document).ready(function(){
            $('#myTableAll').DataTable();
            $('#myTableCredit').DataTable();
            $('#myTableDebit').DataTable();

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


function comingSoon(val){
    if(val == 'bank'){
        swal('Feature available soon', 'Add a new bank account will be available soon', 'info');
    }
    else{
     swal('Hey', 'This feature is coming soon', 'info');

    }
 }

 function restriction(val, name){
    if(val == "withdrawal"){
        swal('Hello '+name, 'Your account need to be verified before you can make withdrawal', 'info');
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