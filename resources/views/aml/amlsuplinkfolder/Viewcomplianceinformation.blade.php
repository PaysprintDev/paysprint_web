@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\AddCard; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View Compliance Information
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> View Compliance Information</li>
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
              <table class="table table-bordered table-striped" >
               

                
                <tbody>
                   
                  <tr>
                    <td><strong> How do you know about us:</strong></td>
                    <td>@if(isset($data['users']->knowAboutUs) && $data['users']->knowAboutUs != NULL){{ ($data['users']->knowAboutUs) }} @else NA @endif</td>
                  </tr>
                  <tr>
                    <td><strong>Size of Transaction to be expected:</strong></td>
                    <td>@if( isset($data['users']->knowAboutUs )&& $data['users']->knowAboutUs != NULL){{ $data['users']->transactionSize }} @else NA @endif</td>
                  </tr>
                  <tr>
                    <td><strong>Source of Funds:</strong></td>

                    <td>@if( isset($data['users']->knowAboutUs) && $data['users']->knowAboutUs != NULL){{ $data['users']->sourceOfFunding }} @else NA @endif</td>
                  </tr>
                </tbody>
              </table>

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


