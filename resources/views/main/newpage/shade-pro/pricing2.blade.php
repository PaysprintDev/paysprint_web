@extends('layouts.newpage.app')

@section('content')
    <!-- navbar- -->
    <div class="inner-banner pt-29 pt-lg-30 pb-9 pb-lg-12 bg-default-6">
        <div class="container">
            <div class="row  justify-content-center pt-5">
                <div class="col-xl-8 col-lg-9">
                    <div class="px-md-15 text-center">
                        <h2 class="title gr-text-2 mb-8 mb-lg-10">{{ $pages }}</h2>
                        {{-- <p class="gr-text-7 mb-0 mb-lg-13">Full Time, Remote</p> --}}
                    </div>
                </div>

                <div class="col-12">
                    <table class="table table-striped table-bordered">

                        <tbody>
                            <tr>
                                <td>
                                    <p class="gr-text-7 font-weight-bold mb-9">Select Country</p>

                                    <select name="country" id="pricing_country" class="form-control"
                                        style="overflow-y: auto">
                                        <option value="">Select Country</option>
                                        @foreach ($data['activecountries'] as $country)
                                            <option value="{{ $country->name }}"
                                                {{ $country->name == Request::get('country') ? 'selected' : '' }}>
                                                {{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="main-block pb-6 pb-lg-17 bg-default-6">
        <div class="container">
            <div class="row justify-content-center">

                <div class="table table-responsive">


                </div>
                <div class="table table-responsive">
                    <table class="table table-striped table-bordered">
                        <tbody>

                            <tr>
                                <td>
                                    <p class="gr-text-6 font-weight-bold mb-9"></p>
                                </td>
                                <td align="center">
                                    <p class="gr-text-6 font-weight-bold mb-9">Basic</p>
                                    <p class="text-danger">{{ $data['currency'] . $data['maintenance'] }}
                                        Monthly/{{ $data['currency'] . $data['maintenance'] * 12 }} Annually</p>
                                </td>
                                <td align="center">
                                    <p class="gr-text-6 font-weight-bold mb-9">Classic</p>
                                    <p class="text-danger">{{ $data['currency'] . $data['maintenance'] * 1.42 }}
                                        Monthly/{{ $data['currency'] . $data['maintenance'] * 1.42 * 12 }} Annually</p>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">No Fee Money Transfer (Local/Intl)</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">Accept Online Payments</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">Create and Send Invoice</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>

                            @if (Request::get('country') != 'Nigeria')

                                <tr>
                                    <td>
                                        <p class="gr-text-9 mb-0">Currency Exchange</p>
                                    </td>
                                    <td align="center">
                                        <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                    </td>
                                    <td align="center">
                                        <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                    </td>
                                </tr>

                            @endif



                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">Cross Border Bill Payments</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                            </tr>


                            @if (Request::get('country') != 'Nigeria')

                                <tr>
                                    <td>
                                        <p class="gr-text-9 mb-0">Merchants Cash Advance</p>
                                    </td>
                                    <td align="center">
                                        <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                    </td>
                                    <td align="center">
                                        <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                    </td>
                                </tr>

                            @endif

                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">Manage Rental Property</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">Manage Orders</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />

                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <p class="gr-text-9 mb-0">Promote your Business</p>
                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/cancel.png" />

                                </td>
                                <td align="center">
                                    <img src="https://img.icons8.com/fluency/48/000000/checked.png" />
                                </td>
                            </tr>


                        </tbody>


                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
