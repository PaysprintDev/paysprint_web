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
        Promo Date
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Promo Date</li>
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
              
            </div>
            </div>

              <h3 class="box-title">&nbsp;</h3> <br>

              
            </div>
            <!-- /.box-header -->
           
            <div class="container-fluid">
                {!! session('msg') !!}
                <div class="row">
                <form action="{{route('update promo date', $data['data']->id)}}" method="post">
                    @csrf
                    
                        <div class="mb-3">
                          <label for="startdate" class="form-label">Start Date</label>
                          <input type="date" class="form-control" id="startdate" name="startdate" value="{{ $data['data']->start_date }}">
                         
                        </div>
                        <br>
                        <div class="mb-3">
                          <label for="enddate" class="form-label">End date</label>
                          <input type="date" class="form-control" id="enddate" name="enddate" value="{{ $data['data']->end_date }}">
                        </div>
                        <br>
                          <div class="mb-3">
                          <label for="enddate" class="form-label">Promo Amount</label>
                          <input type="text" class="form-control" id="enddate" name="amount" value="{{ $data['data']->amount}}">
                        </div>
                        <br>
                        <div class="mb-3">
                          <label for="enddate" class="form-label">Promo Details</label>
                          <input type="text" class="form-control" id="enddate" name="promo_details" value="{{ $data['data']->promo_details}}">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary form-control">Save Promo</button>
                 </form>
                </div>

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


