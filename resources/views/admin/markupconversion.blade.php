@extends('layouts.dashboard')

@section('dashContent')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Default Mark Up Conversion
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Default Mark Up Conversion</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">

                <form action="{{ route('save markup') }}" method="post">
                    @csrf
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group has-success">
                                    <label class="control-label" for="inputSuccess"> Select Rate Option</label>
                                        <select class="form-control form-select" name="rateOption" id="rateOption" required>
                                            <option value="">Select rate option</option>
                                            <option value="sell">Sell Rate</option>
                                            <option value="buy">Buy Rate</option>
                                        </select>
                                </div>
                                <div class="form-group has-success">
                                    <label class="control-label" for="inputSuccess"> Conversion Mark Up (%)</label>
                                    <input type="number" min="0.00" step="0.01" class="form-control" name="percentage"
                                        id="percentage" placeholder="42" required>
                                </div>
                                    @if (count($data['percentage']) > 0)
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($data['percentage'] as $item)
                                    <p style="font-weight: bold; color: navy">{{ $i++.').' }} Current {{ strtoupper($item->rateOption) }} Mark Up Value: {{ $item->percentage }}%</p>
                                    @endforeach

                                    @endif

                            </div>


                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>

            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
