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
        Promo Users
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
                <table class="table table-striped table-responsiveness" id="promousers">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Date</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $counter=1;
                    @endphp
                    @if (isset($data['promo']))
                    @foreach ( $data['promo'] as $promousers )
                        <tr>
                            <td>{{ $counter++}}</td>
                            <td>{{ $promousers->date}}</td>
                            <td>{{ $promousers->email}}</td>
                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">Top-up</button></td>
                        </tr>
                    @endforeach
                    @endif
                    <!-- modal -->
                    <!-- Button trigger modal -->

                  <!-- Modal -->
                  <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          ...
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Understood</button>
                        </div>
                      </div>
                    </div>
                  </div>
  
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


