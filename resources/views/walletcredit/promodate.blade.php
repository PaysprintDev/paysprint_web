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
                <form action="{{route('insert promo date')}}" method="post">
                    @csrf
                    
                        <div class="mb-3">
                          <label for="startdate" class="form-label">Start Date</label>
                          <input type="date" class="form-control" id="startdate" name="startdate">
                         
                        </div>
                        <br>
                        <div class="mb-3">
                          <label for="enddate" class="form-label">End date</label>
                          <input type="date" class="form-control" id="enddate" name="enddate">
                        </div>
                        <br>
                        <div class="mb-3">
                          <label for="enddate" class="form-label">Promo Amount</label>
                          <input type="text" class="form-control" id="enddate" name="amount" placeholder="kindly input promo amount">
                        </div>
                        <br>
                        <div class="mb-3">
                          <label for="enddate" class="form-label">Promo Details</label>
                          <input type="text" class="form-control" id="enddate" name="promo_details" placeholder="kindly write some details about the promo">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary form-control">Create Promo</button>
                 </form>
                </div>

                <!-- The tables -->
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <h3 class="text-center" style="font-weight: bold">SPECIAL PROMO DATES</h3>
                        <hr>
                        <table class="table table-striped table-responsive" id="promousers">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Promo Start Date</th>
                                    <th>Promo End Date</th>
                                    <th>Promo Amount</th>
                                    <th>Promo Details</th>
                                    <th>Action</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter=1;
                                @endphp
                                @if (count($data['promo']) > 0)
                                    @foreach ( $data['promo'] as $promo )
                                        <tr>
                                            <td>{{ $counter++}}</td>
                                            <td>{{ $promo->start_date}}</td>
                                            <td>{{ $promo->end_date}} </td>
                                            <td>{{ $promo->amount }}</td>
                                            <td>{{ $promo->promo_details }}</td>
                                            <td><a href="{{route('edit promo',$promo->id)}}" class="btn btn-primary">Edit</a></td>
                                            <td><a href="{{route('delete promo',$promo->id)}}" class="btn btn-danger">Delete</a></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
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


