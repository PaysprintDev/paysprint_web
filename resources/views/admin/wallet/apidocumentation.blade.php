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
        PaySprint API Integration
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">API Integration</li>
      </ol>
    </div>

    <!-- Main content -->
    <div class="content body">
      
      <section id="introduction">
        <h2 class="page-header"><a href="#introduction">Introduction</a></h2>
        <p class="lead">
          <b>PaySprint</b> is the fastest and affordable method of Sending and Receiving money, Paying Invoice and Getting Paid at anytime!
        </p>
      </section><!-- /#introduction -->


      <!-- ============================================================= -->

      <section id="download">
        <div class="row">
          <div class="col-sm-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">UNIQUE API TOKEN</h3>
                <span class="label label-primary pull-right"><i class="fas fa-code"></i></span>
              </div><!-- /.box-header -->
              <div class="box-body">
                <p>Copy merchant api secrete key and send to your developer for integration on the website</p>

                <p>
                  <strong>API SECRETE KEY: </strong> <pre><strong>{{ $data['getbusinessDetail']->api_secrete_key }}</strong></pre>
                </p>

                <a href="#" target="_blank" class="btn btn-primary"><i class="fas fa-book-reader"></i> Share with developer</a>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
          </div><!-- /.col -->
          
        </div><!-- /.row -->
        



    </div><!-- /.content -->
  </div><!-- /.content-wrapper -->

  @endsection