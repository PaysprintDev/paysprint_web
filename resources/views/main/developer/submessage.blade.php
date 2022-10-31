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

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

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
                                        data-toggle="pill" href="{{ route('community') }}" class="nav-link active"
                                        style="background-color: #007bff !important;"> <i class="fas fa-home"></i>
                                        Goto Community </a> </li>
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

                                            <div class="card">

                                                <div class="card-body">
                                                    <div class="content-title">
                                                        <h5><strong>{{ $data['community']->question }}</strong></h5>
                                                    </div>

                                                    <div class="content-description">
                                                        {!! $data['community']->description !!}
                                                    </div>
                                                    <img src="{{ $data['community']->file }}">
                                                    <hr>

                                                    <div class="content-actions">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <p>{{ $data['community']->categories }}</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p>{{ $data['community']->name }} |
                                                                    <small>
                                                                        {{ $data['community']->created_at->diffForHumans() }}
                                                                    </small>
                                                                </p>

                                                            </div>
                                                        </div>
                                                    </div>








                                                </div>
                                            </div>
                                            <br>



                                            <div class="some-list">

                                                @if (count($data['answer']) > 0)
                                                    <div class="red">
                                                        <h5>{{ count($data['answer']) }} Answer</h5>
                                                    </div>

                                                    <br>

                                                    @foreach ($data['answer'] as $item)
                                                        <div class="card postcard">
                                                            <div class="card-body">
                                                                <div class="content-description">
                                                                    {!! $item->comment !!}
                                                                </div>



                                                                <div class="content-actions">
                                                                    <div class="row">

                                                                        <div class="col-md-8"
                                                                            style="color: #6c757d">
                                                                            <small>{{ $item->name }}</small>

                                                                        </div>
                                                                        <div class="col-md-4"
                                                                            style="color: #6c757d">
                                                                            <small>
                                                                                {{ $item->created_at->diffForHumans() }}
                                                                            </small>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <br>
                                                @else
                                                    <div class="card">

                                                        <div class="card-body">
                                                            <div class="content-title">
                                                                <h5><strong>No answer available yet</strong></h5>
                                                            </div>




                                                        </div>
                                                    </div>
                                                @endif

                                            </div>

                                            <br>
                                            <br>

                                            <form action="{{ route('storeanswer') }}" method="POST">
                                                @csrf
                                                <div>
                                                    <h5>Your Answer</h5>
                                                </div>
                                                <br>

                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="name">Name</label>
                                                        <input type="hidden" name="questionId" class="form-control"
                                                            id="questionId" value="{{ Request::segment(3) }}">
                                                        <input type="text" name="name" class="form-control" id="name">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <textarea type="text" name="comment" class="form-control" id="comment" rows="7"></textarea>
                                                </div>



                                                <div class="content-actions">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit"
                                                                class="float-right btn btn-primary mt-3 btn-md">Post
                                                                Answer</button>
                                                        </div>

                                                    </div>
                                                </div>

                                            </form>






                                        </div>

                                        <div class="col-md-4">
                                            {{-- Bootstrap card --}}
                                            <h4>Categories</h4>
                                            <div class="card" style="width: 18rem;">
                                                <ul class="list-group list-group-flush">

                                                    <a href="{{ route('askquestion') }}">
                                                        <li class="list-group-item">Ask a Question</li>
                                                    </a>

                                                </ul>
                                            </div>
                                        </div>

                                    </div>





                                </div>






                            </div> <!-- End -->


                        </div>

                    </div>
                </div>
            </div><br>



            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            @include('include.message')

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"
                        integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous">
            </script>
            <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
            <script src="{{ asset('js/jquery.simpleLoadMore.js') }}"></script>
            <script>
                $(document).ready(function() {
                    $('#comment').summernote();
                });

                $('.some-list').simpleLoadMore({
                    item: '.postcard',
                    count: 3,
                    btnHTML: '<a href="#" class="load-more__btn btn btn-primary">View More</a>',


                });
                // $('.some-list-2').simpleLoadMore({
                //   item: 'div',
                //   count: 5
                // });
                // $('.some-list-counter-1').simpleLoadMore({
                //   item: 'div',
                //   count: 5,
                //   counterInBtn: true,
                //   btnText: 'View More {showing}/{total}',
                // });


                // Easing
                // $('.easing-1').simpleLoadMore({
                //   item: 'div',
                //   count: 5,
                //   itemsToLoad: 2,
                //   easing: 'fade'
                // });
            </script>


            @include('include.message')


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"
                        integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous">
            </script>

            <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

            <script src="{{ asset('pace/pace.min.js') }}"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>



</body>

</html>
