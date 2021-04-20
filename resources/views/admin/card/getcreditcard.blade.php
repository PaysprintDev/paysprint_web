@extends('layouts.dashboard')


@section('dashContent')

<?php use \App\Http\Controllers\ClientInfo; ?>
<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\InvoicePayment; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Credit Card
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Credit Card</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">

        @if (count($data['getmycreditCard']) > 0)

        <div class="row" style="margin-top: 5px; margin-bottom:20px;">
            <div class="col-md-3 col-md-offset-9">
                <button class="btn btn-secondary btn-block bg-black" onclick="showForm('card')">Add new Card <i class="fa fa-credit-card"></i></button>
            </div>
        </div>

        @foreach ($data['getmycreditCard'] as $mycard)

        @switch($mycard->card_type)
            @case("Mastercard")
                @php
                    $alertInfo = "bg-danger";
                    $cardImage = '<i class="fab fa-cc-mastercard"></i>';
                @endphp
                @break
            @case("Visa")
                @php
                    $alertInfo = "bg-info";
                    $cardImage = '<i class="fab fa-cc-visa"></i>';
                @endphp
                @break
            @default
                @php
                    $alertInfo = "bg-success";
                    $cardImage = '<i class="fas fa-credit-card"></i>';
                @endphp
        @endswitch

        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box {{ $alertInfo }}">
            <div class="inner">
            <h4><strong>{{ wordwrap($mycard->card_number, 4, ' - ', true) }}</strong></h4>

            <div class="row">
                <div class="col-md-6">
                    <strong>Expiry: {{ $mycard->month."/".$mycard->year }}</strong>
                </div>
                <div class="col-md-6">
                    <strong>CVV: ***</strong>
                </div>
                <div class="col-md-12">
                    <h4><strong>{{ (strlen($mycard->card_name) < 18) ? strtoupper($mycard->card_name) : substr(strtoupper($mycard->card_name), 0, 18)."..." }}</strong></h4>
                </div>
                <div class="col-md-6">
                    <input type="hidden" name="card_id" value="{{ $mycard->id }}" id="card_id">
                    <a href="{{ route('Edit merchant credit card', $mycard->id) }}" title="Edit Card"><i class="far fa-edit text-secondary"></i></a>
                    <a href="javascript:void(0)" title="Delete Card" onclick="handShake('deletecard')"><i class="far fa-trash-alt text-danger"></i></a>
                </div>
                
            </div>

              {{-- <p>Total Withdrawal</p> --}}
            </div>
            <div class="icon">
              {!! $cardImage !!}
            </div>
        {{--  <a href="{{ route('Otherpay') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>  --}}
          </div>
        </div>
        <!-- /.col -->

        @endforeach
            
        @else
        <div class="col-md-12">
            <div class="alert bg-info">
                        <center>
                            <div class="row">
                            <div class="col-md-12">
                                <h4>
                                    No Card Found!!
                                </h4>
                                <p>
                                    You are yet to add any credit card, start adding your card by clicking the add new card below.
                                </p>
                                <div class="col-md-6 col-md-offset-3">
                                    <button class="btn btn-secondary btn-block bg-black" onclick="showForm('card')">Add new Card <i class="fa fa-credit-card"></i></button>
                                </div>
                            </div>
                        </div>
                        </center>
            </div>
        </div>

        @endif

        

      </div>
      <!-- /.row -->
      <div class="row">
                      <div class="box-body">

                    <div class="form-group cardform disp-0"> 
                            <form action="#" method="POST" id="formElem">
                                @csrf

                                <div class="form-group">
                                    <label for="card_name">Name on Card</label>

                                <input type="text" name="card_name" id="card_name" class="form-control" required>
                                    

                                </div>



                                <div class="form-group disp-0">
                                    <label for="card_name">Card Provider</label>

                                    <select name="card_provider" id="card_provider" class="form-control" required>
                                        <option value="Credit Card" selected>Credit Card</option>

                                    </select>
                                    

                                </div>



                                <div class="form-group">
                                    <label for="card_number">Card Number</label>

                                <input type="text" name="card_number" id="card_number" class="form-control" maxlength="16" required>
                                    

                                </div>
                                <div class="form-group">

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="month">Month</label>

                                            <select name="month" id="month" class="form-control" required>
                                                <option value="01">January</option>
                                                <option value="02">February</option>
                                                <option value="03">March</option>
                                                <option value="04">April</option>
                                                <option value="05">May</option>
                                                <option value="06">June</option>
                                                <option value="07">July</option>
                                                <option value="08">August</option>
                                                <option value="09">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>
                                            
                                    </div>
                                    <div class="col-md-4">
                                        <label for="year">Year</label>

                                        
                                            <select name="year" id="year" class="form-control" required>
                                                @for ($i = date('y'); $i <= date('y')+10; $i++)
                                                    <option value="{{ $i }}">{{ "20".$i }}</option>
                                                @endfor
                                            </select>
                                            
                                    </div>
                                    <div class="col-md-4">
                                        <label for="month">CVV <small class="text-danger">3 digit at the back of your card</small></label>

                                        
                                            <input type="password" name="cvv" id="cvv" class="form-control" maxlength="3" required>
                                            
                                    </div>
                                </div>

                                    

                                </div>


                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-block" onclick="handShake('addcard')" id="cardSubmit">Submit</button>
                                </div>

                            </form>
                        </div>
                </div>
    </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @endsection