@extends('layouts.merch.merchant-dashboard')


@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <!-- DOM / jQuery  Starts-->

                <div class="card-body">

                    <div class="col-sm-12">
                        <div class="card">

                            <div class="card-body">

                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#instorePickup">Add
                                    New +</button>
                                <hr>


                                <div class="modal fade" id="instorePickup">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">
                                                    Setup Store Address</h5>
                                                <button class="btn-close" type="button" data-dismiss="modal"
                                                    aria-label="Close" onclick="$('.modal').modal('hide')"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('store pickup address') }}" method="post">

                                                    @csrf

                                                    <div class="form-group">
                                                        <label for="instore_address">Address</label>
                                                        <input type="text" class="form-control" name="address"
                                                            id="instore_address" aria-describedby="instore_addressHelp"
                                                            placeholder="Enter your address">
                                                        <small id="instore_addressHelp" class="form-text text-muted">Please
                                                            type
                                                            the correct address to your store</small>
                                                    </div>


                                                    <div class="form-group">
                                                        <label for="instore_city">City</label>
                                                        <input type="text" class="form-control" name="city"
                                                            id="instore_city" aria-describedby="instore_cityHelp"
                                                            placeholder="E.g {{ Auth::user()->city }}" required>
                                                        <small id="instore_addressHelp" class="form-text text-muted">Note
                                                            that this
                                                            city should match with the address above</small>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="instore_state">State</label>
                                                        <input type="text" class="form-control" name="state"
                                                            id="instore_state" aria-describedby="instore_stateHelp"
                                                            placeholder="E.g {{ Auth::user()->state }}" required>
                                                        <small id="instore_addressHelp" class="form-text text-muted">Note
                                                            that this
                                                            state should match with the address above</small>

                                                    </div>


                                                    <div class="form-group">
                                                        <label for="instore_state">Delivery Rate</label>
                                                        <input type="number" class="form-control" name="deliveryRate"
                                                            id="instore_deliveryRate"
                                                            aria-describedby="instore_deliveryRateHelp"
                                                            placeholder="Enter delivery rate" value="0.00" min="0.00"
                                                            step="0.00" required>
                                                        <small id="instore_addressHelp" class="form-text text-muted">Please
                                                            set
                                                            your store delivery rate</small>

                                                    </div>



                                                    <button type="submit" class="btn btn-primary">Submit</button>

                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered nowrap" id="datatable-ordering">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Address</th>
                                                <th>City</th>
                                                <th>State</th>
                                                <th>Delivery rate</th>
                                                <th>Date created</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($data['storepickup']) > 0)
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @foreach ($data['storepickup'] as $item)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $item->address }}</td>
                                                        <td>{{ $item->city }}</td>
                                                        <td>{{ $item->state }}</td>
                                                        <td>{{ Auth::user()->currencyCode . ' ' . number_format($item->deliveryRate, 2) }}
                                                        </td>
                                                        <td>{{ date('d-M-Y', strtotime($item->created_at)) }}</td>
                                                        <td>
                                                            <a href="#" type="button" class="btn btn-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#instorePickup{{ $item->id }}">Edit</a>




                                                            <a href="#" type="button" class="btn btn-danger">Delete</a>
                                                        </td>

                                                    </tr>


                                                    <div class="modal fade" id="instorePickup{{ $item->id }}">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">
                                                                        Edit Store Pickup Address</h5>
                                                                    <button class="btn-close" type="button"
                                                                        data-dismiss="modal" aria-label="Close"
                                                                        onclick="$('.modal').modal('hide')"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form
                                                                        action="{{ route('edit pickup address', $item->id) }}"
                                                                        method="post">

                                                                        @csrf

                                                                        <div class="form-group">
                                                                            <label for="instore_address">Address</label>
                                                                            <input type="text" class="form-control"
                                                                                name="address" id="instore_address"
                                                                                aria-describedby="instore_addressHelp"
                                                                                placeholder="Enter your address"
                                                                                value="{{ $item->address }}">
                                                                            <small id="instore_addressHelp"
                                                                                class="form-text text-muted">Please type
                                                                                the correct address to your store</small>
                                                                        </div>


                                                                        <div class="form-group">
                                                                            <label for="instore_city">City</label>
                                                                            <input type="text" class="form-control"
                                                                                name="city" id="instore_city"
                                                                                aria-describedby="instore_cityHelp"
                                                                                placeholder="E.g {{ Auth::user()->city }}"
                                                                                required value="{{ $item->city }}">
                                                                            <small id="instore_addressHelp"
                                                                                class="form-text text-muted">Note that this
                                                                                city should match with the address
                                                                                above</small>

                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="instore_state">State</label>
                                                                            <input type="text" class="form-control"
                                                                                name="state" id="instore_state"
                                                                                aria-describedby="instore_stateHelp"
                                                                                placeholder="E.g {{ Auth::user()->state }}"
                                                                                required value="{{ $item->state }}">
                                                                            <small id="instore_addressHelp"
                                                                                class="form-text text-muted">Note that this
                                                                                state should match with the address
                                                                                above</small>

                                                                        </div>


                                                                        <div class="form-group">
                                                                            <label for="instore_state">Delivery Rate</label>
                                                                            <input type="number" class="form-control"
                                                                                name="deliveryRate"
                                                                                id="instore_deliveryRate"
                                                                                aria-describedby="instore_deliveryRateHelp"
                                                                                placeholder="Enter delivery rate" min="0.00"
                                                                                step="0.00" required
                                                                                value="{{ $item->deliveryRate }}">
                                                                            <small id="instore_addressHelp"
                                                                                class="form-text text-muted">Please set
                                                                                your store delivery rate</small>

                                                                        </div>



                                                                        <button type="submit"
                                                                            class="btn btn-primary">Submit</button>

                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" align="center">No record</td>
                                                </tr>
                                            @endif

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column rendering Ends-->
                    <!-- Multiple table control elements  Starts-->
                </div>
            </div>
        </div>


        <!-- Container-fluid Ends-->
    </div>
@endsection
