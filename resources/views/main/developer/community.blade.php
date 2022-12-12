<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Favicon -->
    <link rel="icon"
        href="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_icon_png_rhxm1e_sqhgj0.png"
        type="image/x-icon" />

    <link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <script src="https://kit.fontawesome.com/384ade21a6.js"></script>

    <title>PaySprint | Developer's Community</title>

    <style>
        body {
            background: #d4d3d3
        }

        .rounded {
            border-radius: 1rem
        }

        .nav-pills .nav-link {
            color: rgb(255, 255, 255)
        }

        .nav-pills .nav-link.active {
            color: rgb(228, 226, 226)
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

        .nav-tabs .nav-link {
            border: 1px solid #6c757d !important;
            width: 20%;
        }

        .nav-link.active,
        .nav-pills .show>.nav-link {
            background-color: #bb992b !important;
        }

    </style>

</head>

<body>
    <div class="container py-5">
        <!-- For demo purpose -->
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4">Community</h1>
            </div>
        </div> <!-- End -->
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-seconadery shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item" style="background-color: #007bff !important;"> <a
                                        data-toggle="pill" href="{{ route('home') }}" class="nav-link active"
                                        style="background-color: #007bff !important;"> <i class="fas fa-home"></i>
                                        Goto HomePage </a> </li>
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">

                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">


                                <div class="form-group row">

                                    <div class="col-md-12">

                                        <p>
                                            {{ date('A') == 'AM' ? 'Good Morning! Welcome to PaySprint developers community.☕' : 'Good day! Welcome to PaySprint developers community.👏' }}
                                        </p>
                                    </div>



                                </div>








                                <div class="form-group">

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="content-actions">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h4>All Post</h4>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <a type="button" href="{{ route('askquestion') }}"
                                                            class="float-right btn btn-secondary mb-2">Ask a
                                                            Question</a>

                                                    </div>

                                                </div>
                                            </div>

                                            @if (count($data['community']) > 0)

                                                @foreach ($data['community'] as $post)
                                                    <div class="card">

                                                        <div class="card-body">
                                                            <div class="content-title">
                                                                <a href="{{ route('submessage', $post->id) }}">
                                                                    <h5><strong>{{ $post->question }}</strong></h5>
                                                                </a>
                                                            </div>

                                                            <div class="content-description">
                                                                {!! \Illuminate\Support\Str::limit($post->description, 200, $end = '.......') !!}
                                                            </div>
                                                            <hr>
                                                            <div class="content-actions">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <p>{{ $post->categories }}</p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <p>{{ $post->name }} |
                                                                            <small>
                                                                                {{ $post->created_at->diffForHumans() }}
                                                                            </small>
                                                                        </p>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach


                                                <div class="row mt-4 mx-auto">
                                                    <div class="col-md-12">
                                                        <nav>
                                                            <ul class="pagination pagination-md">

                                                                <li class="page-item">
                                                                    {{ $data['community']->links() }}
                                                                </li>
                                                            </ul>
                                                        </nav>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="card">

                                                    <div class="card-body">
                                                        <div class="content-title">
                                                            <h5><strong>No Post available yet</strong></h5>
                                                        </div>

                                                        <div class="content-description">
                                                            <a href="{{ route('askquestion') }}">Click here to ask a
                                                                question</a>
                                                        </div>
                                                        <hr>

                                                    </div>
                                                </div>

                                            @endif





                                        </div>
                                        <div class="col-md-4">
                                            {{-- Bootstrap card --}}
                                           
                                            <div class="card" style="width: 18rem;">
                                                <ul class="list-group list-group-flush mb-4">
                                                    <a href="{{ route('askquestion') }}">
                                                        <li class="list-group-item">Ask a Question</li>
                                                    </a>
                                                </ul>
                                                <div>
                                                    <h4 class="text-center">Categories</h4>    
                                                <ul class="list-group">
                                                    <li class="list-group-item">App Review</li>
                                                    <li class="list-group-item">PaySprint Login</li>
                                                    <li class="list-group-item">Developer Tools</li>
                                                    <li class="list-group-item">API Integration</li>
                                                    <li class="list-group-item">Platform Policy</li>
                                                    <li class="list-group-item">Others</li>
                                                </ul>
                                                </div>
                                                


                                            </div>
                                        </div>




                                    </div>






                                </div> <!-- End -->


                            </div>

                        </div>
                        <hr>
                        <div class="tab-content">
                            <h2 class="text-center mb-4 mt-4">Frequently Asked Questions</h2>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                  Accordion Item #1
                                </button>
                              </h2>
                              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                  <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                </div>
                              </div>
                            </div>
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                  Accordion Item #2
                                </button>
                              </h2>
                              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                  <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                </div>
                              </div>
                            </div>
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                  Accordion Item #3
                                </button>
                              </h2>
                              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                  <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                </div>
                              </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    
                </div><br>



                <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>

                @include('include.message')


                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"
                                integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG"
                                crossorigin="anonymous"></script>

                <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

                <script src="{{ asset('pace/pace.min.js') }}"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>



</body>

</html>
