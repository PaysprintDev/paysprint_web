@extends('layouts.dashboard')

@section('dashContent')

    <?php use App\Http\Controllers\ConversionCountry; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Currency Conversion Rate
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Currency Conversion Rate</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">

                <div class="box-body">

                    <div class="table-responsive">

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Currency</th>
                                    <th>Official Rate/USD</th>
                                    <th>Mark Up Rate/USD</th>
                                    <th>Date</th>
                                    <th>Time</th>

                                </tr>
                            </thead>
                            <tbody>

                                @if (isset($data['currencyrate']))
                                    @php
                                        $i = 1;
                                    @endphp

                                    @foreach ($data['currencyrate']['quotes'] as $result)


                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $result->country }}</td>
                                            <td>{{ $result->official }}</td>
                                            <td>{{ $result->rate }}</td>
                                            <td>{{ date('d/m/Y', strtotime($result->updated_at)) }}</td>
                                            <td>{{ date('h:i a', strtotime($result->updated_at)) }}</td>
                                        </tr>

                                    @endforeach

                                @else
                                    <tr>
                                        <td colspan="6" align="center">No record</td>
                                    </tr>
                                @endif




                            </tbody>
                        </table>

                    </div>

                </div>
                <!-- /.box-body -->

            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
