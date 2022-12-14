<!doctype html>
<html lang="en">
<?php use App\Http\Controllers\User; ?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Favicon -->
    <link rel="icon"
        href="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg"
        type="image/x-icon" />

    <link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <script src="https://kit.fontawesome.com/384ade21a6.js"></script>

    <title>PaySprint | {{ $pages }}</title>

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

        .disp-0 {
            display: none !important;
        }

        .fas {
            font-size: 12px;
        }

    </style>

</head>

<body>
    <div class="container py-5">
        <!-- For demo purpose -->
        <div class="row mb-4">
            <div class="col-lg-10 mx-auto text-center">
                <h1 class="display-4">{{ $pages }}</h1>
            </div>
        </div> <!-- End -->
        <div class="row row-cols-1">
            <div class="col-lg-8 mx-auto">


                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">

                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item"> <a data-toggle="pill" href="{{ route('home') }}"
                                        class="nav-link active "> <i class="fas fa-home"></i> Go Back </a>
                                </li>

                            </ul>



                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">

                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">

                                <div class="table table-responsive">
                                    <table class="table table-bordered table-striped" id="example3">
                                        <thead>
                                            <tr>
                                                <td>
                                                    #
                                                </td>
                                                <td>
                                                    Referred Name
                                                </td>
                                                <td>
                                                    Email
                                                </td>
                                                <td>
                                                    Telephone
                                                </td>
                                                <td>
                                                    Country
                                                </td>
                                                <td>
                                                    Date Added
                                                </td>


                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if (count($data['referlist']))
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @foreach ($data['referlist'] as $refList)
                                                    @if ($user = \App\User::where('email', $refList->referred_user)->first())
                                                        <tr>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $user->name }}</td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>{{ $user->telephone }}</td>
                                                            <td>{{ $user->country }}</td>
                                                            <td>{{ date('d/M/Y', strtotime($user->created_at)) }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @else
                                                <tr>

                                                    <td align="center" colspan="7">No record</td>


                                                </tr>


                                            @endif



                                        </tbody>

                                        </tbody>

                                    </table>


                                    <nav aria-label="...">
                                        <ul class="pagination pagination-md">

                                            <li class="page-item">
                                                {{ $data['referlist']->links() }}

                                            </li>
                                        </ul>
                                    </nav>


                                </div>



                            </div> <!-- End -->

                        </div>
                    </div>
                </div>
                <div class="col-lg-8 mx-auto">
                <div class="card">
                    <table class="table  table-bordered table-striped">
                       
                        <thead>
                            <h4 style="text-align: center">Referral Points</h4>
                       
                        <tbody>
                          <tr>
                            <th scope="row"> Total Points to Redeem</th>
                            <td></td>
                            <td>500</td>
                          </tr>
                          <tr>
                            <th scope="row">Value of Points to Redeem</th>
                            <td># or $</td>
                            <td>100</td>

                          </tr>
                          <tr>
                            <th scope="row">Points per each referal</th>
                            <td></td>
                            <td>10</td>
                          </tr>
                          <tr>
                            <th scope="row">Number of Users Referred</th>
                            <td></td>
                            <td>150</td>
                          </tr>
                          <tr>
                            <th scope="row">Total Points Earned</th>
                            <td>Date</td>
                            <td>1500</td>
                          </tr>
                          <tr>
                            <th scope="row">Total Reward Claimed</th>
                            <td></td>
                            <td>-1500</td>

                          </tr>
                          <tr>
                            <th scope="row">Balance</th>
                            <td></td>
                            <td>0</td>
                          </tr>
                          
                        </tbody>
                        
                      </table>
                      <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">

                        <!-- Credit card form tabs -->
                        <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                            <div class="col-md-6">
                                
                                <a class="btn btn-primary" href="{{route}}" role="button">Show Claimed History</a>
                            </div>
                            <div class="col-md-6 ">
                                
                                <button type="button" class="btn btn-danger ">Claim Reward</button>
                            </div>
                           

                        </ul>



                    </div>
                      

                </div>
                </div>
            </div>


            <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>

            @include('include.message')


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"
                        integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous">
            </script>
            <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

            <script src="{{ asset('pace/pace.min.js') }}"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

</body>

</html>
