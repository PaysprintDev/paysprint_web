@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Tables
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Other Payments</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Payment Detail</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Payer Name</th>
                  <th>Phone number</th>
                  <th>Purpose</th>
                  <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($otherPays) > 0)
                    <?php $i = 1; ?>
                        @foreach ($otherPays as $items)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $items->name }}</td>
                            <td>{{ $items->email }}</td>
                            <td>{{ $items->purpose }}</td>
                            <td>{{ $items->amount }}</td>
                        </tr>
                        @endforeach

                    @else
                    <tr>
                        <td colspan="5" align="5">No data available</td>
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
