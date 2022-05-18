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

                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#instoreShipping">Add
                                    New +</button>
                                <hr>


                                <div class="modal fade" id="instoreShipping">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">
                                                    Shipping Regions & Rates (Delivery Service)</h5>
                                                <button class="btn-close" type="button" data-dismiss="modal"
                                                    aria-label="Close" onclick="$('.modal').modal('hide')"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('store shipping address') }}" method="post">

                                                    @csrf

                                                    <div class="form-group">
                                                        <label for="instore_address">Country</label>
                                                        <select name="country" id="delivery_country"
                                                            class="form-control form-select" required>

                                                        </select>
                                                        <small id="delivery_countryHelp" class="form-text text-muted">Please
                                                            select
                                                            country you deliver to.</small>
                                                    </div>



                                                    <div class="form-group">
                                                        <label for="instore_state">Currency Code</label>
                                                        <select name="currencyCode" id="category"
                                                            class="form-control form-select" required>
                                                            @if (count($data['activeCountry']) > 0)
                                                                <option value="">Select currency code
                                                                </option>

                                                                @foreach ($data['activeCountry'] as $item)
                                                                    <option value="{{ $item->currencyCode }}">
                                                                        {{ $item->name . ' (' . $item->currencyCode . ')' }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <small id="instore_addressHelp" class="form-text text-muted">Pick a
                                                            correct
                                                            currency code for the above country</small>

                                                    </div>


                                                    <div class="form-group">
                                                        <label for="instore_state">State</label>
                                                        <select name="state" id="delivery_state"
                                                            class="form-control form-select" required>

                                                        </select>
                                                        <small id="instore_addressHelp" class="form-text text-muted">Select
                                                            the states
                                                            you deliver to</small>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="instore_city">City</label>
                                                        <input type="text" class="form-control" name="city"
                                                            id="delivery_city" aria-describedby="instore_cityHelp"
                                                            placeholder="Enter delivery city" required>
                                                        <small id="instore_cityHelp" class="form-text text-muted">Please
                                                            specify the
                                                            city</small>

                                                    </div>



                                                    <div class="form-group">
                                                        <label for="instore_state">Delivery Rate</label>
                                                        <input type="number" class="form-control" name="deliveryRate"
                                                            id="delivery_deliveryRate"
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
                                                <th>Country</th>
                                                <th>State</th>
                                                <th>Delivery rate</th>
                                                <th>Date created</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($data['deliverypickup']) > 0)
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @foreach ($data['deliverypickup'] as $item)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $item->country }}</td>
                                                        <td>{{ $item->state }}</td>
                                                        <td>{{ $item->currencyCode . ' ' . number_format($item->deliveryRate, 2) }}
                                                        </td>
                                                        <td>{{ date('d-M-Y', strtotime($item->created_at)) }}</td>
                                                        <td>
                                                            <a href="#" type="button" class="btn btn-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#instoreShipping{{ $item->id }}">Edit</a>
                                                            <a href="#" type="button" class="btn btn-danger">Delete</a>
                                                        </td>

                                                    </tr>


                                                    <div class="modal fade" id="instoreShipping{{ $item->id }}">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">
                                                                        Shipping Regions & Rates (Delivery Service)</h5>
                                                                    <button class="btn-close" type="button"
                                                                        data-dismiss="modal" aria-label="Close"
                                                                        onclick="$('.modal').modal('hide')"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form
                                                                        action="{{ route('edit shipping address', $item->id) }}"
                                                                        method="post">

                                                                        @csrf

                                                                        <div class="form-group">
                                                                            <label for="instore_address">Country</label>
                                                                            <select name="country" id="delivery_country"
                                                                                class="form-control form-select" required>

                                                                            </select>
                                                                            <small id="delivery_countryHelp"
                                                                                class="form-text text-muted">Please select
                                                                                country you deliver to.</small>
                                                                        </div>



                                                                        <div class="form-group">
                                                                            <label for="instore_state">Currency Code</label>
                                                                            <select name="currencyCode" id="category"
                                                                                class="form-control form-select" required>
                                                                                @if (count($data['activeCountry']) > 0)
                                                                                    <option value="">Select currency code
                                                                                    </option>

                                                                                    @foreach ($data['activeCountry'] as $currency)
                                                                                        <option
                                                                                            value="{{ $currency->currencyCode }}"
                                                                                            {{ $currency->currencyCode == $item->currencyCode ? ' selected' : '' }}>
                                                                                            {{ $currency->name . ' (' . $currency->currencyCode . ')' }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                            <small id="instore_addressHelp"
                                                                                class="form-text text-muted">Pick a correct
                                                                                currency code for the above country</small>

                                                                        </div>


                                                                        <div class="form-group">
                                                                            <label for="instore_state">State</label>
                                                                            <select name="state" id="delivery_state"
                                                                                class="form-control form-select" required>

                                                                            </select>
                                                                            <small id="instore_addressHelp"
                                                                                class="form-text text-muted">Select the
                                                                                states
                                                                                you deliver to</small>

                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="instore_city">City</label>
                                                                            <input type="text" class="form-control"
                                                                                name="city" id="delivery_city"
                                                                                aria-describedby="instore_cityHelp"
                                                                                placeholder="Enter delivery city" required
                                                                                value="{{ $item->city }}">
                                                                            <small id="instore_cityHelp"
                                                                                class="form-text text-muted">Please specify
                                                                                the
                                                                                city</small>

                                                                        </div>



                                                                        <div class="form-group">
                                                                            <label for="instore_state">Delivery Rate</label>
                                                                            <input type="number" class="form-control"
                                                                                name="deliveryRate"
                                                                                id="delivery_deliveryRate"
                                                                                aria-describedby="instore_deliveryRateHelp"
                                                                                placeholder="Enter delivery rate"
                                                                                value="{{ $item->deliveryRate }}"
                                                                                min="0.00" step="0.00" required>
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
                                                    <td colspan="6" align="center">No record</td>
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
