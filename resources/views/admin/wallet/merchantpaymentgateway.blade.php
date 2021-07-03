@extends('layouts.dashboard')


@section('dashContent')

<?php use \App\Http\Controllers\ClientInfo; ?>
<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\InvoicePayment; ?>
  <!-- Content Wrapper. Contains page content -->


  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <h1>
        {{ Request::get('gateway') }} Gateway
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">{{ Request::get('gateway') }} Gateway</li>
      </ol>
    </div>

    <!-- Main content -->
    <div class="content body">
      
      <!-- ============================================================= -->

      <section id="download">

        

        <div class="row">

            <div class="col-md-2 col-md-offset-0">
                <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
            <br>

            </div>


          <div class="col-md-12">
            <div class="box box-primary">


              
              <div class="box-body">

                
                                  <!-- ./col -->
                <div class="row">
                    <center>
                        <div class="col-lg-12 col-xs-12">
          <!-- small box -->
          <div class="small-box">

              @if (session('country') != "Nigeria")

                  <div @if (session('country') != 'Canada') class="col-md-6 mb-3" @else class="col-md-3 mb-3" @endif>
                  <strong>
                    <a type="button" class="btn btn-warning" style="color: purple; font-weight: bold; background-color: #fff !important;" href="{{ route('merchant credit card', $data['getUserDetail']->id) }}"><img src="https://img.icons8.com/fluent/53/000000/credit-card-cash-withdrawal.png" title="Credit Card"/> <i class="fas fa-plus-square" title="Credit Card" style="font-size: 16px; color: black"></i>
                        <br>
                        Credit Card
                    </a>
                  </strong>
              </div>
              @endif

              @if (session('country') == "Canada")

                  <div class="col-md-3">
                    <strong>
                      <a type="button" class="btn btn-warning" style="color: purple; font-weight: bold; background-color: #fff !important;" href="{{ route('merchant debit card', $data['getUserDetail']->id) }}"><img src="https://img.icons8.com/color/53/000000/bank-card-front-side.png" title="Credit Card"/> <i class="fas fa-plus-square" title="Credit Card" style="font-size: 16px; color: black"></i>
                          <br>
                          Debit VISA/Mastercard
                      </a>
                    </strong>
                </div>

                <div class="col-md-3">
                  <strong>
                      <a type="button" class="btn btn-warning" style="color: purple; font-weight: bold; background-color: #fff !important;" href="{{ route('merchant prepaid card', $data['getUserDetail']->id) }}"> <img src="https://img.icons8.com/cotton/53/000000/bank-cards--v2.png" title="Prepaid Card"/> <i class="fas fa-plus-square" title="Prepaid Card" style="font-size: 16px; color: black"></i>
                          <br>
                          Prepaid Card
                      </a>
                  </strong>
                </div>

              @endif

              @if (session('country') == "Nigeria")
                <div class="col-md-6 mb-3">
                    <strong>
                      <a type="button" class="btn btn-warning" style="color: purple; font-weight: bold; background-color: #fff !important;" href="{{ route('merchant debit card', $data['getUserDetail']->id) }}"><img src="https://img.icons8.com/color/53/000000/bank-card-front-side.png" title="Credit Card"/> <i class="fas fa-plus-square" title="Credit Card" style="font-size: 16px; color: black"></i>
                          <br>
                          Debit VISA/Mastercard
                      </a>
                    </strong>
                </div>
              @endif

              

              

              <div @if (session('country') != 'Canada') class="col-md-6 mb-3" @else class="col-md-3 mb-3" @endif>
                <strong>
                    <a type="button" class="btn btn-warning" style="color: purple; font-weight: bold; background-color: #fff !important;" href="{{ route('merchant bank account', $data['getUserDetail']->id) }}"> <img src="https://img.icons8.com/dusk/53/000000/merchant-account.png" title="Bank Account"/> <i class="fas fa-plus-square" title="Bank Account" style="font-size: 16px; color: black"></i>
                        <br>
                        Bank Account
                    </a>
                </strong>
              
              </div>
          </div>
        </div>
                    </center>
                </div>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </div><!-- /.col -->
          
        </div><!-- /.row -->
        



    </div><!-- /.content -->
  </div><!-- /.content-wrapper -->

  @endsection