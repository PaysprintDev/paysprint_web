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
    <link rel="icon" href="https://res.cloudinary.com/pilstech/image/upload/v1602675914/paysprint_icon_png_ol2z3u.png"
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
                <h1 class="display-4">Ask Questions</h1>
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
                                            {{ date('A') == 'AM'? 'Good Morning! Welcome to PaySprint developers community.☕': 'Good day! Welcome to PaySprint developers community.👏' }}
                                        </p>
                                    </div>



                                </div>








                                <form action="{{ route('askquestion') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="categories">Categories</label>
                                            <select name="categories" id="categories" class="form-control">
                                                <option>Choose a category</option>
                                                <option>App Review</option>
                                                <option>PaySprint Login </option>
                                                <option>Developer Tools</option>
                                                <option>API Integration</option>
                                                <option>Payment</option>
                                                <option>Platform Policy</option>
                                                <option value="others">Other</option>
                                            </select>
                                        </div>

                                        <div class="form-group has-feedback specify_Categories disp-0">
                                            <label for="specify_categories">Specify Categories</label>
                                            <input type="text" name="specify_categories" id="specify_categories"
                                                class="form-control">
                                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="your_question">Your question</label>
                                            <input type="text" name="question" class="form-control"
                                                placeholder="What is your question">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="about_what">What's this about</label>
                                        <input type="file" name="file" class="file-input form-control"
                                            placeholder="insert image">
                                    </div>

                                    <div class="form-group">
                                        <textarea type="text" name="description" class="form-control" id="summernote"
                                            placeholder="Share additional details about your question or issue to help the community provide you with the best answer possible"
                                            rows="7"></textarea>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="name">Name</label>
                                            <input type="text/email" name="name" class="form-control" id="inputCity">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="email">Email</label>
                                            <input type="Email" name="email" class="form-control" id="inputCity">
                                        </div>


                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">


                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary col-md-12"
                                        href="{{ route('community') }}">Submit</button>
                                </form>


                            </div> <!-- End -->

                        </div>
                    </div>
                </div>
            </div>



            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            @include('include.message')

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"
                        integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous">
            </script>
            <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

            <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

            <script src="{{ asset('pace/pace.min.js') }}"></script>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


            <script>
                $(document).ready(function() {
                    $('#summernote').summernote();
                });

                $('#Categories').change(function() {

                    if ($('#categories').val() == "Other") {
                        // Show a specify input field
                        $('.specify_categories').removeClass('disp-0');
                    } else {
                        // Remove the specified input field
                        $('.specify_categories').addClass('disp-0');
                    }

                });

                $('#Categories').change(function() {

                    if ($('#Categories').val() == "Others") {
                        // Show a specify input field
                        $('.specify_categories').removeClass('disp-0');
                    } else {
                        // Remove the specified input field
                        $('.specify_categories').addClass('disp-0');
                    }

                });
            </script>

</body>

</html>
