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

            <div class="box-body table table-responsive">

              <table class="table table-bordered table-striped" id="example3">

                <form class="d-flex">
                    <input class="form-control mt-6" type="search" name="search" aria-label="Search" placeholder="Search by PS number"><br>
                    {{-- <button class=" btn btn-primary btn-block bg-primary" type="{{ route('aml transaction analysis subpage') }}">Get Transcaton Acount</button> --}}
                    <a type="button" href="{{ route('aml compliance desk review subpage',) }}" class="btn btn-primary btn-block">Get Transcaton Acount</a>
                  </form>
             
                <tbody>

                   
                   
                </tbody>
              </table>
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


