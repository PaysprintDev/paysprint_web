<style>
     .tab-menu { 
        margin-top:34px; 
    }
   .tab-menu ul {
    margin:0;
    padding:0;
    list-style:none;
    display: -webkit-box; 
    display: -webkit-flex; display: -ms-flexbox; 
    display: flex;
     }
  .tab-menu ul li {
     -ms-flex-preferred-size: 0;
      flex-basis: 0;
     -ms-flex-positive: 1;
     flex-grow: 1;
      max-width: 100%;
    text-align:center;
   }
.tab-menu ul li a {
    color: #fff; 
    text-transform: uppercase; 
    letter-spacing: 0.44px; 
    
    font-weight:bold; 
    display:inline-block;
    padding:18px 26px;
    display:block; 
    text-decoration:none;
    transition:0.5s all;
    background: #e8aa07; 
    border: 2px solid #e8aa07;
    border-bottom: 0;
     }
.tab-menu ul li a:hover {
 background:#e8aa07;
color:#fff; 
text-decoration:none; }
.tab-menu ul li a.active {
background:#f2f2f2;
color:#000;
 text-decoration:none; 
}
.tab-box {
 display:none;
 }

*/.tab-teaser {
max-width:100%;
width:100%; 
margin:0 auto; 

 } 
 .tab-main-box { 
background:##f2f2f2;
padding: 10px 30px;
border:2px solid #f8ca56;
margin-top:-2px  */
} 
</style>

{{-- Box tab --}}
<div class="container mt-4 mb-5">
    <div class="row justify-content-center align-items-start">
      <h2 class="title gr-text-4 ">Do you need to:</h2><br>
    </div>
    <div class="tab-teaser">
        <div class="tab-menu">
          <ul>
            <li><a href="#" class="active" data-rel="tab-1" style="font-size:12px">Send money</a></li>
            <li><a href="#" data-rel="tab-2" class=""style="font-size:12px">Receive Money</a></li>
            <li><a href="#" data-rel="tab-3" class="" style="font-size:12px">Hold FX Wallets</a></li>
            <li><a href="#" data-rel="tab-4" class="" style="font-size:12px">Get FX Offer</a></li>
            <li><a href="#" data-rel="tab-5" class="" style="font-size:12px">Cross Border Invoice</a></li>
          </ul>
        </div>
    
    <div class="tab-main-box">
        <div class="tab-box" id="tab-1" style="display:block;" id="send_money">
            <form action="" method="get" id="formelem">
                <div class="currencyShow">
                <div class="row">

                  <div class="col-md-4">
                    <label for="text" class="form-label">Send From</label>
                   
                  <select class="form-control" name="sendingcountry" id="sendingcountry">
                    @if (count($data['availablecountry']))

                    @foreach ($data['availablecountry'] as $country)
                    <option value="{{$country->currencyCode}}">{{$country->name.' ('.$country->currencyCode.')' }}</option>

                    @endforeach
                    @endif
                  </select>
                  </div>
               
                      <div class="col-md-4">

                        <label for="text" class="form-label">Send To</label>
                        
                        <select class="form-control" name="receivingcountry" id="receivingcountry" 
                        >
                          @if (count($data['availablecountry']))

      
                          @foreach ($data['availablecountry'] as $country)
                          
                          <option value="{{$country->currencyCode}}">{{$country->name.' ('.$country->currencyCode.')' }}</option>
      
                          @endforeach
                          @endif
                        </select>   
                      
                      </div>

                      <div class="col-md-4">
                        <label for="text" class="form-label">Amount to Send</label>
                        <input type="number" class="form-control" name="amount" id="amount" aria-describedby="select" placeholder="Input your amount">
                          </div>
                   
                  
                </div>
                </div><br>
                <button type="button" class="btn btn-warning " id="shift" onclick="convertFee()">Convert</button>
                <br>
                 
                <div class="currencyResult disp-0">
                    <div class="row" style="margin-top: 2rem">
                        <div class="col-md-12">
                        {{-- <h4>Charge Fee<span>0.00</span></h4> --}}
                        <h4><span id="totalprice"></span></h4>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-4">
                          <h6 style="font-size:13px"><span id="rate"></span></h6>
                          <h6 style="font-size:13px"><span id="local"></span></h6>
                         
                        </div>
                        <div class="col-md-4 mx-auto">
                          
                        </div>
                        <div class="col-md-4">
                            <a class="btn btn-warning" href="{{ route('AdminLogin') }}" role="button">Click to Send Now</a>
                        </div>
                        </div>
                </div>
                
               
            </form>
        </div>

        <!-- receive money -->
        <div class="tab-box" id="tab-2" style="display:none" id="receive_money">
        <form >
            <div class="row">
              <div class="col-md-4">
                <label for="text" class="form-label">Receive From</label>
                {{-- <img src="{{$country->logo}}"> --}}
               <select class="form-control" name="localcountry" id="localcountry">
                @if (count($data['availablecountry']))

                @foreach ($data['availablecountry'] as $country)
                <option value="{{$country->currencyCode}}">{{$country->name}}({{$country->currencyCode}})</option>

                @endforeach
                @endif
              </select>
              </div>

              <div class="col-md-4">
                <label for="text" class="form-label">Receive To</label>
                {{-- <img src="{{$country->logo}}"> --}} 
                 <select class="form-control" name="foreigncountry" id="foreigncountry">
                    @if (count($data['availablecountry']))

                    @foreach ($data['availablecountry'] as $country)
                    <option value="{{$country->currencyCode}}">{{$country->name}}({{$country->currencyCode}})</option>

                    @endforeach
                    @endif
                  </select>
              </div>
                <div class="col-md-4">
                <label for="text" class="form-label">Amount to Receive</label>
                <input type="number" step="0.01" min="0.01" class="form-control" name="paying" id="paying" aria-describedby="select" placeholder="Input your amount">
                  </div>
                 
                 
          
               
              
            </div><br>
            <button type="button" class="btn btn-warning " id="shift2" onClick='rateFee()'>Convert</button>
            <br>
            <div class="currencyDisplay disp-0">
            <div class="row" style="margin-top: 2rem">

                <div class="col-md-12" >
                <h4><span id="totalpricerate"></span></h4>
                </div>
                </div>
                <div class="row">
                <div class="col-md-4" >
                  <h6 style="font-size:13px"><span id="rates"></span></h6>
                  <h6 style="font-size:13px"><span id="locals"></span></h6>
                 
                </div>
                <div class="col-md-4 mx-auto" >
                  
                </div>
                <div class="col-md-4">
                    <a class="btn btn-warning" href="{{ route('AdminLogin') }}" role="button">Click to Send Now</a>
                </div>
                </div>
            </div>
                
            
        </form>  
        </div>

    <!-- end of receive money -->
        <div class="tab-box" id="tab-3">
           
               <p>Holding currencies when rates are low is a smart way to hedge against adverse rates. With PaySprint FX,you can create multipie currency wallets when the rates are low to save on exchange rate when the rates are high</p>
        </div>
        <div class="tab-box" id="tab-4">
            
               <p>Buy and Sell Foreign Currencies at your own desired rate and make huge Profit</p>
        </div>
        <div class="tab-box" id="tab-5">
         
               <p>Do you need to pay invoices in other currencies other than your local currency? No problem! Pay invoices directly from your FX walet and take advantage of great exchange rates</p>
        </div>
    </div>
    </div>
</div>

