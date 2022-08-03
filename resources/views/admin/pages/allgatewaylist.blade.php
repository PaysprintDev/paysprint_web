@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\OrganizationPay; ?>
<?php use \App\Http\Controllers\ClientInfo; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Payment Gateway
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Payment Gateway</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Payment Gateway</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body table table-responsive">


                <form action="{{ route('store payment gateway') }}" method="post" id="myForm">
                @csrf
                <input type="hidden" id="formId" name="id" value="">
                <div class="row">
                  <div class="col-md-12">
                    <label>Gateway name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter Gateway Name" required>
                  </div>


                </div>

                <br>
                <div class="row">
                  <div class="col-md-12">
                    <button class="btn btn-primary btn-block" id="submitBtn">Submit</button>
                  </div>


                </div>

                <br>
              </form>

              <table class="table table-bordered table-striped" id="example3">

                <thead>

                <tr>
                  <th>S/N</th>
                  <th>Name</th>
                  <th>Added date</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['allpaymentgateway']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['allpaymentgateway'] as $data)
                        <tr>
                            <td>{{ $i++ }}</td>

                            <td>{{ $data->name }}</td>
                            <td>{{ date('d/M/Y h:i a', strtotime($data->created_at)) }}</td>

                            <td>
                                <button type="button" class="btn btn-primary" onclick='handleClick("edit", "{{ $data->name }}", "{{ $data->id }}")'>Edit Gateway</button>
                                <button type="button" class="btn btn-danger" onclick='handleClick("delete", "{{ $data->name }}", "{{ $data->id }}")'>Delete Gateway</button>
                            </td>


                        </tr>
                        @endforeach



                    @else
                    <tr>
                        <td colspan="3" align="center">No record available</td>
                    </tr>
                    @endif
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


