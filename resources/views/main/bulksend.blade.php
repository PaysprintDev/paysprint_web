<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

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
                                           
                                            <td> {{$data['record']['receiver'][$i]}}</td>
                                            <td> {{$data['record']['purpose'][$i]}}</td>
                                            <td> {{$data['record']['amount'][$i]}}</td>
                                           
                                          
                                            <td>
                                                <a href="" class="btn btn-primary">Edit</a>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger" id="btns"
                                                >Delete</button>
                                            
                                                <input type="hidden" name="postid"
                                                    value="">
                                            
                                            </td>
                                        </tr> 
                                            
                                        {{-- @endfor --}}


                                        

                                        
                                        @endfor
                                       
                                      
                                        {{-- @endif --}}
                                       
                                              
                                           
    
    
    
    
                                </table>
    
                            </div> 

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>