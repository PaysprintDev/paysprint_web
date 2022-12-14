@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\Statement; ?>
<?php use \App\Http\Controllers\MonthlyFee; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Wallet Credit
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Wallet Credit</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="row">
                <div class="col-md-2 col-md-offset-0">
                <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
            </div>
            </div>

              <h3 class="box-title">&nbsp;</h3> <br>

              
            </div>
            <!-- /.box-header -->
            {!! session('msg') !!}
            <div class="container-fluid">
                <div class="row">
                <form action="{{route('upload promo users')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12 mb-2">
                        <label>Import List</label>
                        <input type="file" name="promo_docs" class="form-control" >
                    </div>
                    <div class="col-md-12 mt-3" style="margin-top: 30px; margin-bottom:10px">
                        <button type="submit" class="btn btn-success form-control">Import List</button>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
              <p><a href="images/file_sample.PNG" target="_blank">Click here to view sample of excel format</a></p>
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


