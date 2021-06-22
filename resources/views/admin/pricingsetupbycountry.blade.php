@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pricing Set Up
        <small>Cost of Pulling and Pushing</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pricing Set Up</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        
        <div class="box-body">
          
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Country</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($data['pricingByCountry']) > 0)
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($data['pricingByCountry'] as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->country }}</td>
                                <td>
                                    <a href="{{ route('country pricing', 'country='.$item->country) }}" type="button" class="btn btn-primary">View details</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="3" align="center">No record</td></tr>
                    @endif
                </tbody>
            </table>

        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection