@extends('layouts.merch.merchant-dashboard')


@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">

        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-xl-12">
                    <div class="row">


                    </div>
                </div>
                <div class="col-sm-12 col-xl-12">
                    <div class="row">
                        <div class="card">

                            <div class="card-body">



                                <form action="#" method="POST" id="formElem" class="theme-form mega-form">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label" for="inputSuccess"> Name Of Tax</label>
                                                <input type="text" class="form-control" name="name" id="name"
                                                    placeholder="Name Of Tax">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="inputSuccess"> Tax Rate (%)</label>
                                                <input type="number" min="0.00" step="0.01" class="form-control"
                                                    name="rate" id="rate" placeholder="Tax Rate (%)">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="inputSuccess"> Name of Agency</label>
                                                <input type="text" class="form-control" name="agency" id="agency"
                                                    placeholder="Name of Agency">
                                            </div>
                                        </div>
                                    </div>



                                    <div class="box-footer">
                                        <button type="button" class="btn btn-primary btn-block"
                                            onclick="handShake('setuptax')" id="cardSubmit">Submit</button>
                                    </div>
                                </form>

                            </div>


                            <div class="table-responsive">
                                <table class="table table-striped table-bordered nowrap" id="datatable-ordering">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name of Tax</th>
                                            <th>Rate</th>
                                            <th>Agency</th>
                                            <th class="text-center">Action</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($data['getTax']) > 0)
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($data['getTax'] as $item)

                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ number_format($item->rate, 2) . '%' }}</td>
                                                    <td>{{ $item->agency }}</td>
                                                    <td>
                                                        <a href="{{ route('edit tax', $item->id) }}"
                                                            style="color: navy; font-weight: bold;">Edit</a> | <form
                                                            action="#" method="POST" class="disp-0">@csrf <input
                                                                type="hidden" name="id" id="id{{ $item->id }}"
                                                                value="{{ $item->id }}"></form> <a href="#"
                                                            style="color: red; font-weight: bold;"
                                                            onclick="delhandShake('deletetax', '{{ $item->id }}')">Delete</a>

                                                    </td>

                                                </tr>

                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" align="center">No record</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>

                            </div>


                        </div>

                    </div>
                </div>
            </div>


            <!-- Container-fluid Ends-->
        </div>
    @endsection
