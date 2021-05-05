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
        Debit VISA/Mastercard
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Debit VISA/Mastercard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
                      <div class="box-body">

                    <div class="form-group cardform"> 
                            <form action="#" method="POST" id="formElem">
                                @csrf

                                <div class="form-group">
                                    <label for="card_name">Name on Card</label>

                                    <input type="hidden" name="id" value="{{ $data['getthisCard']->id }}">

                                <input type="text" name="card_name" id="card_name" class="form-control" value="{{ $data['getthisCard']->card_name }}" required>
                                    

                                </div>



                                <div class="form-group">
                                    <label for="card_name">Card Provider</label>


                                    <select name="card_provider" id="card_provider" class="form-control" required>
                                        <option value="">Select Card Issuer</option>
                                        <option value="{{ $data['getthisCard']->card_provider }}" selected>{{ $data['getthisCard']->card_provider }}</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Debit Card">Debit VISA/Mastercard</option>
                                        @if (count($data['cardIssuer']) > 0)

                                            @foreach ($data['cardIssuer'] as $cardIssuers)
                                                <option value="{{ $cardIssuers->issuer_card }}">{{ $cardIssuers->issuer_card.' from '.$cardIssuers->issuer_name }}</option>
                                            @endforeach

                                        @else
                                            <option value="EXBC Prepaid Card">EXBC Prepaid Card from EXBC</option>
                                        @endif
                                    </select>
                                    

                                </div>



                                <div class="form-group">
                                    <label for="card_number">Card Number</label>

                                <input type="text" name="card_number" id="card_number" class="form-control" maxlength="16" value="{{ $data['getthisCard']->card_number }}" required>
                                    

                                </div>
                                <div class="form-group">

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="month">Month</label>

                                            <select name="month" id="month" class="form-control" required>

                                                            @switch($data['getthisCard']->month)
                                                                    @case("01")
                                                                        @php
                                                                            $month = "January";
                                                                        @endphp
                                                                        @break
                                                                    @case("02")
                                                                        @php
                                                                            $month = "February";
                                                                        @endphp
                                                                        @break
                                                                    @case("03")
                                                                        @php
                                                                            $month = "March";
                                                                        @endphp
                                                                        @break
                                                                    @case("04")
                                                                        @php
                                                                            $month = "April";
                                                                        @endphp
                                                                        @break
                                                                    @case("05")
                                                                        @php
                                                                            $month = "May";
                                                                        @endphp
                                                                        @break
                                                                    @case("06")
                                                                        @php
                                                                            $month = "June";
                                                                        @endphp
                                                                        @break
                                                                    @case("07")
                                                                        @php
                                                                            $month = "July";
                                                                        @endphp
                                                                        @break
                                                                    @case("08")
                                                                        @php
                                                                            $month = "August";
                                                                        @endphp
                                                                        @break
                                                                    @case("09")
                                                                        @php
                                                                            $month = "September";
                                                                        @endphp
                                                                        @break
                                                                    @case("10")
                                                                        @php
                                                                            $month = "October";
                                                                        @endphp
                                                                        @break
                                                                    @case("11")
                                                                        @php
                                                                            $month = "November";
                                                                        @endphp
                                                                        @break
                                                                    @case("12")
                                                                        @php
                                                                            $month = "December";
                                                                        @endphp
                                                                        @break
                                                                    @default
                                                                        @php
                                                                            $month = "January";
                                                                        @endphp
                                                                @endswitch

                                                            <option value="{{ $data['getthisCard']->month }}" selected>{{ $month }}</option>
                                                            
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
                                                <option value="{{ $data['getthisCard']->year }}" selected>{{ "20".$data['getthisCard']->year }}</option>
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
                                    <button type="button" class="btn btn-primary btn-block" onclick="handShake('editcard')" id="cardSubmit">Submit</button>
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