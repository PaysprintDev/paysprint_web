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

    <title>PaySprint | Add Bank Detail</title>

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
                <h1 class="display-4">{{ Request::get('card') }}</h1>
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

                                        @if (count($data['getBankDetail']) > 0)

                                        @foreach ($data['getBankDetail'] as $myBank)

                                        <div class="col-md-6">


                                            <div class="alert alert-info">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h4>
                                                                    {{ $myBank->accountNumber }}
                                                                </h4>
                                                            </div>
                                                            <br>
                                                            <div class="col-md-12">
                                                                <h6>
                                                                {{ $myBank->bankName }}
                                                                </h6>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>
                                                                Transit No: {{ $myBank->transitNumber }}
                                                                </h6>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>
                                                                Branch Code: {{ $myBank->branchCode }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h5>

                                                                    {{ (strlen($myBank->accountName) < 18) ? strtoupper($myBank->accountName) : substr(strtoupper($myBank->accountName), 0, 18)."..." }}
                                                                </h5>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="hidden" name="bank_id" value="{{ $myBank->id }}" id="bank_id">
                                                                <a href="{{ route('Edit bank', $myBank->id) }}" title="Edit Bank Detail"><i class="far fa-edit text-secondary"></i></a>
                                                                <a href="javascript:void(0)" title="Delete Bank Detail" onclick="handShake('deletebank')"><i class="far fa-trash-alt text-danger"></i></a>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <img src="https://img.icons8.com/emoji/30/000000/bank-emoji.png"/>
                                                            </div>
                                                        </div>
                                            </div>
                                            
                                            
                                        </div>
                                        
                                            
                                        @endforeach
                                            
                                        @else

                                        <div class="col-md-12">
                                            <div class="alert alert-info">
                                                        <center>
                                                            <div class="row">
                                                            <div class="col-md-12">
                                                                <h4>
                                                                    No Bank Account!!
                                                                </h4>
                                                                <p>
                                                                    You are yet to add any bank account, start adding your bank account by clicking the add bank account below.
                                                                </p>
                                                            </div>
                                                        </div>
                                                        </center>
                                            </div>
                                        </div>
                                            
                                        @endif

                                        

                                        
                                    </div>

                                    
                                    
                                    
                                    <div class="form-group row pickCard"> 
                                        <div class="col-md-12">
                                            <button class="btn btn-secondary btn-block" onclick="showForm('card')">Add Bank Account <i class="fas fa-university"></i></button>
                                        </div>
                                    </div>

                                    

                                    <div class="form-group cardform disp-0"> 
                                       <form action="#" method="POST" id="formElem">
                                           @csrf

                                           <div class="form-group">
                                               <label for="bankName">Bank Name</label>

                                            <div class="input-group">
                                                
                                                @if (Auth::user()->country == "Canada")
                                                    

                                                <select name="bankName" id="bankName" class="form-control" required>
                                                    <option data-tokens="RBC ROYAL BANK" value="RBC ROYAL BANK"> RBC ROYAL BANK</option>
                                                    <option data-tokens="TD CANADA TRUST" value="TD CANADA TRUST">TD CANADA TRUST</option>
                                                    <option data-tokens="SCOTIABANK" value="SCOTIABANK">SCOTIABANK</option>
                                                    <option data-tokens="DESJARDINS" value="DESJARDINS">DESJARDINS</option>
                                                    <option data-tokens="NATIONAL BANK OF CANADA" value="NATIONAL BANK OF CANADA">NATIONAL BANK OF CANADA</option>
                                                    <option data-tokens="TANGERINE" value="TANGERINE">TANGERINE</option>
                                                    <option data-tokens="SIMPLII FINANCIAL" value="SIMPLII FINANCIAL">SIMPLII FINANCIAL</option>
                                                    <option data-tokens="ENVISION FINANCIAL, A DIVISION OF FIRST WEST CU" value="ENVISION FINANCIAL, A DIVISION OF FIRST WEST CU">ENVISION FINANCIAL, A DIVISION OF FIRST WEST CU</option>
                                                    <option data-tokens="VANCITY" value="VANCITY">VANCITY</option>
                                                    <option data-tokens="PROSPERA CREDIT UNION" value="PROSPERA CREDIT UNION">PROSPERA CREDIT UNION</option>
                                                    <option data-tokens="DUCA" value="DUCA">DUCA</option>
                                                    <option data-tokens="TD CANADA TRUST" value="TD CANADA TRUST">TD CANADA TRUST</option>
                                                </select>
                                                <div class="input-group-append"> 
                                                    <span class="input-group-text text-muted"> <i class="fas fa-university"></i></span> 
                                                </div>

                                                @else

                                                <input type="text" name="bankName" id="bankName" class="form-control" required>
                                                <div class="input-group-append"> 
                                                    <span class="input-group-text text-muted"> <i class="fas fa-university"></i></span> 
                                                </div>
                                                
                                                @endif
                                                
                                                


                                            </div>

                                           </div>

                                           <div class="form-group">
                                               <label for="accountName">Account Name</label>

                                            <div class="input-group"> <input type="text" name="accountName" id="accountName" class="form-control" required>
                                                <div class="input-group-append"> 
                                                    <span class="input-group-text text-muted"> <i class="fas fa-university"></i></span> 
                                                </div>
                                            </div>

                                           </div>


                                           <div class="form-group">
                                               <label for="transitNumber">Transit Number</label>

                                            <div class="input-group"> <input type="text" name="transitNumber" id="transitNumber" class="form-control" required>
                                                <div class="input-group-append"> 
                                                    <span class="input-group-text text-muted"> <i class="fas fa-sort-numeric-up-alt"></i></span> 
                                                </div>
                                            </div>

                                           </div>


                                           <div class="form-group">
                                               <label for="branchCode">Branch Code</label>

                                            <div class="input-group"> <input type="text" name="branchCode" id="branchCode" class="form-control" required>
                                                <div class="input-group-append"> 
                                                    <span class="input-group-text text-muted"> <i class="fas fa-code-branch"></i></span> 
                                                </div>
                                            </div>

                                           </div>


                                           
                                           <div class="form-group">
                                               <label for="accountNumber">Account Number</label>

                                            <div class="input-group"> <input type="text" name="accountNumber" id="accountNumber" class="form-control" required>
                                                <div class="input-group-append"> 
                                                    <span class="input-group-text text-muted"> <i class="fas fa-university"></i></span> 
                                                </div>
                                            </div>

                                           </div>


                                           <div class="form-group">
                                               <button type="button" class="btn btn-primary btn-block" onclick="handShake('addbank')" id="cardSubmit">Submit</button>
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

function handShake(val){


var route;

if(val == 'addbank'){

var formData = new FormData(formElem);


    route = "{{ URL('/api/v1/addnewbank') }}";

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


else if(val == "deletebank"){

    // Ask Are you sure

    swal({
  title: "Are you sure you want to delete bank account?",
  text: "This bank account will be deleted and can not be recovered!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    
    // Run Ajax

    var thisdata = {id: $("#bank_id").val()};

    route = "{{ URL('/api/v1/deletebank') }}";

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