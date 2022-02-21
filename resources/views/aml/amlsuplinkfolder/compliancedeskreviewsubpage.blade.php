@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\AddCard; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Compliance Desk Review
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Compliance Desk Review</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <br>
          <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
      <br>

      <div class="row">
        <div class="col-xs-12">
          <div class="box">

            <div class="box-body">
                  <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Name:</label>
                    
                  </div>
                  <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Phone:</label>
                    
                  </div>
                  <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Email:</label>
                    
                  </div>
                  <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Acount Type:</label>
                    
                  </div>
                    <div class="row">

                      <div class="col-md-4 mb-2"><a class="btn btn-primary mb-2 " style="width: 100%" href="#">Profile Information</a></div>
                      <div class="col-md-4"><a class="btn btn-primary mb-2" style="width: 100%" href="{{ route('viewdocument',) }}"> View Document</a></div>
                      <div class="col-md-4"><a class="btn btn-primary mb-2" style="width: 100%" href="{{ route('viewkyckybreport',) }}">View KYC/KYB Report</a></div>
                      
                    </div>
                    <div class="row">

                      <div class="col-md-4 mb-2"><a class="btn btn-primary mb-2" style="width: 100%" href="{{ route('viewcomplianceinformation',) }}">View Compliance Information</a></div>
                      <div class="col-md-4"><a class="btn btn-primary mb-2" style="width: 100%" href="{{ route('viewindustry',) }}"> View Industry</a></div>
                      <div class="col-md-4"><a class="btn btn-primary mb-2" style="width: 100%" href="{{ route('linkedaccount',) }}">Linked Account</a></div>
                      
                    </div>
                    <div class="row">

                      <div class="col-md-4 mb-2"><a class="btn btn-primary mb-2" style="width: 100%" href="{{ route('connectedaccounts',) }}">Connected Accounts</a></div>
                      
                    </div>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection


