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
                <!-- The tables -->
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <h3 class="text-center" style="font-weight: bold">SPECIAL PROMO REPORT</h3>
                        <hr>
                        <table class="table table-striped table-responsive" id="promousers">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Promo Start Date</th>
                                    <th>Promo End Date</th>
                                    <th>Promo Amount</th>
                                    <th>Promo Details</th>
                                    <th>View Participants</th>
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
                                            <td><a href="{{route('promo participant',$promo->id.'?start='.$promo->start_date.'&end='.$promo->end_date)}}" class="btn btn-primary">View Participants</a></td>
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


