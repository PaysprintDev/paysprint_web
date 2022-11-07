<style>
  .tab-menu {
    margin-top: 34px;
  }

  .tab-menu ul {
    margin: 0;
    padding: 0;
    list-style: none;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
  }

  .tab-menu ul li {
    -ms-flex-preferred-size: 0;
    flex-basis: 0;
    -ms-flex-positive: 1;
    flex-grow: 1;
    max-width: 100%;
    text-align: center;
  }

  .tab-menu ul li p {
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 0.44px;
    font-weight: bold;
    display: inline-block;
    padding: 18px 26px;
    display: block;
    text-decoration: none;
    cursor: pointer;
    transition: 0.5s all;
    background: #e8aa07;
    border: 2px solid #e8aa07;
    border-bottom: 0;
  }

  .tab-menu ul li p:hover {
    background: #e8aa07;
    color: #fff;
    text-decoration: none;
  }

  .tab-menu ul li p.active {
    background: #f2f2f2;
    color: #000;
    text-decoration: none;
  }

  .tab-box {
    display: none;
  }

  .tab-teaser {
    max-width: 100%;
    width: 100%;
    margin: 0 auto;

  }

  .tab-main-box {
    background: #f2f2f2;
    padding: 10px 30px;
    border: 2px solid #f8ca56;
    margin-top: -2px;
  }
</style>

{{-- Box tab --}}
<div class="container mt-4 mb-5">
  <div class="row align-items-start">
    <h5 class="title ps-3" style="text-align: left; margin-left:18px;">Do you need to:</h5><br>
  </div>
  <div class="tab-teaser" style="margin-top:-20px">
    <div class="tab-menu">
      <ul>
        <li>
          <p class="active" data-rel="tab-1" style="font-size:12px" id="sender_money">Send money</p>
        </li>
        <li>
          <p data-rel="tab-2" class="" style="font-size:12px" id="receiver_money">Receive Money</p>
        </li>
        <li>
          <p data-rel="tab-3" class="" style="font-size:12px" id="hold_fx">Hold FX Wallets</p>
        </li>
        <li>
          <p data-rel="tab-4" class="" style="font-size:12px" id="get_fx">Get FX Offer</p>
        </li>
        <li>
          <p data-rel="tab-5" class="" style="font-size:12px" id="cross_border">Cross Border Invoice</p>
        </li>
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

                <select class="form-control" name="receivingcountry" id="receivingcountry">
                  @if (count($data['availablecountry']))


                  @foreach ($data['availablecountry'] as $country)

                  <option value="{{$country->currencyCode}}">{{$country->name.' ('.$country->currencyCode.')' }}</option>

                  @endforeach
                  @endif
                </select>

              </div>

              <div class="col-md-4">
                <label for="text" class="form-label">Amount to Send</label>
                <input type="number" class="form-control" name="amount" id="amount" aria-describedby="select" placeholder="Type amount">
              </div>


            </div>
          </div><br>
          <div class="row">
            <div class="col-md-2">
              <button type="button" class="btn" style="background-color:#e8aa07;" id="shift" onClick='convertFee("selling");'>Get Result</button>
            </div>
            <div class="col-md-10 ps-2 pt-3">
              <span id="rate" style="font-size:15px; font-weight:bolder; color:#000"></span> <br> <span id="local" style="font-size:15px; font-weight:bolder; color:#000"></span>
            </div>
          </div>

          <div class="currencyResult disp-0">
            <div class="row" style="margin-top: 2rem">
              <div class="col-md-4">
                {{-- <h4>Charge Fee<span>0.00</span></h4> --}}
                <h6><span id="totalamount" style="font-style: underline;"></span></h6>
                <h6 id="totalprice"></h6>
                <h6 id="paymethod1" style="font-style: underline;"></h6>
                <h6 id="paymethod"></h6>

              </div>
              <div class="col-md-4"></div>
              <div class="col-md-4">
                <a class="btn" style="background-color:#e8aa07;" href="{{ route('login') }}" role="button">Click to Send Now</a>
              </div>
            </div>
            <!-- <div class="row">
              <div class="col-md-4">
                <h6 style="font-size:13px"><span id="rate"></span></h6>
                <h6 style="font-size:13px"><span id="local"></span></h6>

              </div>
              <div class="col-md-4 mx-auto">

              </div>

            </div> -->
          </div>


        </form>
      </div>

      <!-- receive money -->
      <div class="tab-box" id="tab-2" style="display:none" id="receive_money">
        <form>
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
              <label for="text" class="form-label">Receive In</label>
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
              <input type="number" step="0.01" min="0.01" class="form-control" name="paying" id="paying" aria-describedby="select" placeholder="Type Amount">
            </div>





          </div><br>
          <div class="row">
            <div class="col-md-2">
              <button type="button" class="btn" style="background-color:#e8aa07;" id="shift2" onClick='rateFee("buying")'>Get Result</button>
            </div>
            <div class="col-md-10 ps-2 pt-3">
              <span id="rates" style="font-size:15px; font-weight:bolder; color:#000;"></span> <br> <span id="locals" style="font-size:15px; font-weight:bolder; color:#000 ;"></span>
            </div>
          </div>
          <div class="currencyDisplay disp-0">
            <div class="row" style="margin-top: 2rem">

              <div class="col-md-4">
                <h6 id="totalpricerate1"></h6>
                <h6><span id="totalpricerate"></span></h6>
                <h6 id="paysmethod1"></h6>
                <h6 id="paysmethod"></h6>
              </div>
              <div class="col-md-4 mx-auto">
              </div>
              <div class="col-md-4">
                <a class="btn" style="background-color:#e8aa07;" href="{{ route('login') }}" role="button">Click to Receive Now</a>
              </div>
            </div>
            <!-- <div class="row">
              <div class="col-md-4">
              </div>

            </div> -->
          </div>


        </form>
      </div>
      <!-- end of receive money -->

      <div class="tab-box" id="tab-3">

        <p>Holding currencies when rates are low is a smart way to hedge against adverse rates. With PaySprint FX, you can create multipie currency wallets when the rates are low to save on exchange rate when the rates are high</p>
      </div>

      <div class="tab-box" id="tab-4">

        <p>Buy and Sell Foreign Currencies at your own desired rate and make huge Profit.</p>
      </div>

      <div class="tab-box" id="tab-5">

        <p>Do you need to pay invoices in other currencies other than your local currency? No problem! Pay invoices directly from your FX wallet and take advantage of great exchange rates.</p>
      </div>

    </div>
  </div>
</div>
