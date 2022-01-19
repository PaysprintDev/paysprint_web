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

.nav-link.active, .nav-pills .show>.nav-link{
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
                                <li class="nav-item" style="background-color: #007bff !important;"> <a data-toggle="pill" href="{{ route('community') }}" class="nav-link active" style="background-color: #007bff !important;"> <i class="fas fa-home"></i> Goto Community </a> </li>
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">

                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">
                                    

                                    <div class="form-group row">

                                        <div class="col-md-12">
                                            
                                            <p>
                                                {{ (date('A') == "AM") ? "Good Morning! Welcome to PaySprint developers community.☕" : "Good day! Welcome to PaySprint developers community.👏" }}
                                            </p>
                                        </div>


                                        
                                    </div>

                                    
                                    


                                    
                                    

                                    <div class="form-group"> 

                                        <div class="row">
                                            <div class="col-md-8">
                                               
                                                <div class="card">
                                                    
                                                    <div class="card-body">
                                                        <div class="content-title">
                                                            <h5><strong>This is my title</strong></h5>
                                                        </div>
                                                      
                                                        <div class="content-description">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis
obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam
nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,
tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,
quia.
                                                        </div>
                                                        <hr>
                                                        
                                                        <div class="content-actions">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p>Action</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p>Usmanu Danfodio |
                                                                        <small>
                                                                            12hrs ago
                                                                        </small>
                                                                    </p>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                       
                                                      
                                                       
                                                       
                                                        
                                                                
                                                        
                                                            
                                                    </div>
                                                </div>
                                                <br>
                                                  

                                            <div>
                                                <h5>1 Answer</h5>
                                            </div>
                                              
                                            <br>
                                                <div class="card">
                                                    
                                                    <div class="card-body">
                                                        <div class="content-description">
                                                            Hi, unfortunately, you are not allowed to just gather anyone's public information. You are only allowed to take the information of user's that has allowed permission on your application (for whatever permission/data they allow you to)
                                                        </div>
                                                        <hr>
                                                    
                                                       
                                                        <div class="content-actions">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p>Jan 17, 2022 at <small>
                                                                        12hrs ago
                                                                    </small></p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p>Usmanu Danfodio 
                                                                        
                                                                    </p>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                                
                                                    </div>
                                                </div>
                                                  <br>

                                                <div>
                                                    <h5>Your Answer</h5>
                                                </div>
                                                  <br>
                                                  
                                                <div class="form-group">
                                                    <textarea type="text" class="form-control" id="inputAddress2" rows="7"></textarea>
                                                  </div>

                                                  <div class="content-actions">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="float-right btn btn-primary mt-3 btn-md" >Post Answer</button>
                                                        </div>
                                                        
                                                    </div>
                                                </div>


                                            </div>
                                            
                                            <div class="col-md-4">
                                                {{-- Bootstrap card --}}
                                                <h4>Categories</h4>
                                                <div class="card" style="width: 18rem;">
                                                    <ul class="list-group list-group-flush">
                                                        <a href="#"><li class="list-group-item">All Message</li></a>
                                                        <a href="{{ route('askquestion') }}"><li class="list-group-item">Ask a Question</li></a>
                                                     
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
        

    
        <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>

        @include('include.message')


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>

        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script src="{{ asset('pace/pace.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



  </body>
</html>