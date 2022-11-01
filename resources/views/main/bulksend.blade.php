<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Favicon -->
    <link rel="icon" href="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_icon_png_rhxm1e_sqhgj0.png" type="image/x-icon" />

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

        .disp-0 {
            display: none !important;
        }
    </style>

</head>

<body>
    <div class="container-wrapper">
        <!-- For demo purpose -->
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4">Confirm Receiver</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item" onclick="location.href='{{ route('payorganization') }}'">
                                    <a data-toggle="pill" href="{{ route('payorganization') }}" class="nav-link active "> <i class="fas fa-home"></i> Go Back </a>
                                </li>
                              
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">
                            <div class="box-body">


                                <table class="table table-bordered table-striped" id="example3">
                                    <thead>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h3 id="period_start"></h3>
                                            </div>
                                            <div class="col-md-6">
                                                <h3 id="period_stop"></h3>
                                            </div>
                                        </div>
    
                                        <tr>
    
                                            <th>S/N</th>
                                            <th>Name</th>
                                            <th>Purpose</th>
                                            <th>Amount to Send</th>
                                            <th colspan="2">Action</th>
                                            
    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @if (count($data) > 0) --}}
                                        @php
                                        // $i = 0;
                                        // dd($data);
                                        //  exit;
                                       
                                        @endphp
                                        @for ( $i = 1; $i <= count($data['record']['receiver']); $i++)
                                          
                                        


                                        {{-- @for ($j = 1; $j < count($data['record']); $j++) --}}

                                        <tr>
                                            <td>{{$i}}</td>
                                           
                                            <td id="myname{{$i}}"> {{$data['record']['receiver'][$i]}}</td>
                                            <td id="mypurpose{{$i}}"> {{$data['record']['purpose'][$i]}}</td>
                                            <td id="myamount{{$i}}"> {{$data['record']['amount'][$i]}}</td>
                                            

                                           
                                          
                                            <td>
                                                <a href="javascript:void()" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop{{$i}}">Edit</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('delete bulk send') }}" class="btn btn-danger" id="btns"
                                                >Delete</a>
                                            
                                                <input type="hidden" name="postid"
                                                    value="">
                                            
                                            </td>
                                        </tr> 
                                       
                                            
                                        {{-- @endfor --}}

                                      <!-- Button trigger modal -->

    <!-- Modal -->
                                    <div class="modal fade" id="staticBackdrop{{$i}}" data-backdrop="static" data-keyboard="false" tabindex="-1"
                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5>{{$data['record']['receiver'][$i]}}</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            
                                                            <form>
                                                                <label for="receiver_name">Name</label>
                                                                <input type="text" name="receiver_name" id="receiver_name{{$i}}" value="{{$data['record']['receiver'][$i]}}" class="form-control">
                                                                <label for="receiver_purpose">Purpose</label>
                                                                <input type="text" name="receiver_purpose" id="receiver_purpose{{$i}}" value="{{$data['record']['purpose'][$i]}}" class="form-control">
                                                                <label for="receiver_amount">Amount</label>
                                                                <input type="text" name="receiver_amount" id="receiver_amount{{$i}}" value="{{$data['record']['amount'][$i]}}" class="form-control">
                                                            </form>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary" onclick="updateReceiver({{$i}})"
                                                        id="cardSubmit">Update</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
    <!--end -->


                                       @endfor
                                       
                                      
                                        {{-- @endif --}}
                                       
                                    </tbody>         
                                      
                                              
    
    
    
    
                                </table>
                                <div class="form-group"> <label for="transaction_pin">
                                    <h6>Transaction Pin</h6>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fas fa-lock"></i> </span> </div> <input type="password" name="transaction_pin" id="transaction_pin" class="form-control" maxlength="4" required>

                                </div>
                                 </div>

                                 <input type="hidden" id="receiverrecord" value="{{ json_encode($data["record"]["receiver"]) }}">
                                 <input type="hidden" id="purposerecord" value="{{ json_encode($data["record"]["purpose"]) }}">
                                 <input type="hidden" id="amountrecord" value="{{ json_encode($data["record"]["amount"]) }}">

                                 <button type="submit" class="subscribe btn btn-primary btn-block shadow-sm sendmoneyBtn" onclick='payBulk()'>
                                    Send Money 
                                </button> 
    

                            </div> 

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function updateReceiver(id)
        {
            var name = $("#receiver_name"+id).val();
            var purpose = $("#receiver_purpose"+id).val();
            var amount = $("#receiver_amount"+id).val();


            $("#myname"+id).text(name);
            $("#mypurpose"+id).text(purpose);
            $("#myamount"+id).text(amount);
        } 
        
        function payBulk(){
            

            var thisdata;

            var receiver = $('#receiverrecord').val();
            var purpose = $('#purposerecord').val();
            var amount = $('#amountrecord').val();
            var route = "{{ route('Ajaxmakebulkpayment') }}";
            thisdata = {
                receiver: JSON.parse(receiver),
                purpose: JSON.parse(purpose),
                amount: JSON.parse(amount)
            };


            console.log(thisdata);

            setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: thisdata,
                    dataType: 'JSON',
                    success: function(result) {

                       


                    }

                });
        }

        function setHeaders() {
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Authorization': "Bearer " + "{{ Auth::user()->api_token }}"
                    }
                });
        }
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.3/js/bootstrap.min.js" integrity="sha512-8qmis31OQi6hIRgvkht0s6mCOittjMa9GMqtK9hes5iEQBQE/Ca6yGE5FsW36vyipGoWQswBj/QBm2JR086Rkw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    

</body>


</html>