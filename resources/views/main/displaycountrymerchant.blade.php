@extends('layouts.app')
<style>
   .header {
    position: -webkit-sticky;
  position: sticky;
  top: 0;
  z-index: 2;
           
        }
.topnav .search-container {
float: left;
padding-top: 10px;

}

.topnav input[type=text] {
padding: 6px;
margin-top: 10px;
font-size: 17px;
border: 1px;
}

.topnav .search-container button {
float: right;
padding: 6px 10px;
margin-top: 8px;
margin-right: 16px;
background: #ddd;
font-size: 17px;
border:1px;
cursor: pointer;
}

.topnav .search-container button:hover {
background: #ffe29f;
}

@media screen and (max-width: 600px) {
.topnav .search-container {
  float: none;
}
.topnav a, .topnav input[type=text], .topnav .search-container button {
  float: none;
  display: block;
  text-align: left;
  width: 100%;
  margin: 0;
  padding: 14px;
}
.topnav input[type=text] {
  border: 1px solid #ffe29f;  
}
}
</style>


@section('content')
    <!-- Banner area -->
    <section class="banner_area" data-stellar-background-ratio="0.5">
        <h2>SEARCH COUNTRY</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('display country') }}" class="active">Search Country</a></li>
        </ol>
    </section>
    <!-- End Banner area -->

   

    <!-- All contact Info -->
    <section class="all_contact_info">
      <div class="container">
        <div class="col-xl-5 col-lg-6 col-md-8">
          <div class="topnav">
          <div class="search-container">
              <form action="{{route('search')}}" method="post" id="searchform">
                  @csrf
                <input type="text" placeholder="Search for Country" name="search" id="search" value="">
                <button type="submit" id="submit"><i class="fa fa-search"></i></button>
              </form>
          </div>
          </div>
      </div>
        <div class="row">
          <div class="col-md-12 mt-4">
              {{-- <h3 class="text-center" style="font-weight: bold">SPECIAL PROMO DATES</h3> --}}
              <hr>
             
              <table class="table table-striped table-responsive" id="promousers">
                  <thead>
                      <tr style="postion:sticky">
                    
                        <th class="header" scope="col"></th>
                        <th class="header" scope="col">Country</th>
                        <th class="header" scope="col">Payout Method</th>
                        <th class="header"  scope="col">Action</th>
                        
                      </tr>
                  </thead>
                  <tbody id="myTable">
                      @php
                          $counter=1;
                      @endphp
                      @if (count($data['availablecountry']) > 0)
                     
                          @foreach ( $data['availablecountry'] as $country )
                          
                              <tr>
                                  <td><img style="width:60px;height:60px;border-radius:8px" src="{{$country->logo}}"></td>
                                  <td>{{ $country->name}} </td>
                                  <td> 
                                    @foreach (json_decode($country->payoutmethod) as $paymentmethod)
                                      {{$paymentmethod}}
                                    @endforeach
                                  </td>
                                  <td><a class="nav-link" href="{{ route('login') }}" role="button"
                                  aria-expanded="false">LOGIN/SIGNUP</a></td>
                                 
                              </tr>
                          @endforeach
                      @endif
                      
                  </tbody>
              </table>
              
          </div>
      </div>
     </div>
    </section>
    <!-- End All contact Info -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
@endsection
