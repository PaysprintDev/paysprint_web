@extends('layouts.merch.merchant-dashboard')


@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <br>
        <br>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-xl-12">
                    <div class="row">


                    </div>
                </div>
                <div class="col-sm-12 col-xl-12">
                    <div class="row">
                        <div class="card">

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered nowrap" id="datatable-ordering">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Transaction ID</th>
                                            <th>Receiver</th>
                                            <th>Amount to Payout</th>
                                            <th>Commission Earned</th>
                                            <th>Identification</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th class="text-center">Action</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($data['record']) > 0)
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($data['record'] as $item)

                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $item->transaction_id }}</td>
                                                    @if ($user = \App\User::where('ref_code', $item->ref_code)->first())
                                                        <td>{{ $user->name }}</td>
                                                    @endif
                                                    <td style="color: green; font-size: 16px;"><strong>{{ Auth::user()->currencyCode.number_format($item->amounttosend, 2) }}</strong></td>
                                                    <td style="color: navy; font-size: 16px;"><strong>{{ Auth::user()->currencyCode.number_format($item->commissiondeduct, 2) }}</strong></td>

                                                    @if ($identity = \App\User::where('ref_code', $item->ref_code)->first())


                                                        @if ($identity->nin_front != NULL) <td >
                                                            <a style="color: blue; font-size: 16px; font-weight: bold; text-decoration: underline;" href="{{ $identity->nin_front }}" target="_blank">National Identity</a>
                                                        </td>

                                                        @elseif ($identity->drivers_license_front != NULL) <td>
                                                            <a style="color: blue; font-size: 16px; font-weight: bold; text-decoration: underline;" href="{{ $identity->drivers_license_front }}" target="_blank">Driver Licence</a>
                                                        </td>

                                                        @elseif ($identity->international_passport_front != NULL) <td>
                                                            <a style="color: blue; font-size: 16px; font-weight: bold; text-decoration: underline;" href="{{ $identity->international_passport_front }}" target="_blank">International Passport</a>
                                                        </td>

                                                        @elseif ($identity->incorporation_doc_front != NULL || $identity->idvdoc != NULL) <td>
                                                            <a style="color: blue; font-size: 16px; font-weight: bold; text-decoration: underline;" href="{{ $identity->incorporation_doc_front != NULL ? $identity->incorporation_doc_front : $identity->idvdoc }}" target="_blank">Utility Bill</a>
                                                        </td>

                                                        @endif

                                                    @endif


                                                     <td style="color: {{ $item->status === 'pending' ? 'orange' : 'green' }}; font-weight: bold; font-size: 15px;">{{ strtoupper($item->status) }}</td>
                                                    <td>{{ date('d/m/Y h:i:a', strtotime($item->created_at)) }}</td>

                                                    <td align="center">

                                                        @if ($item->status === 'pending')

                                                        {{-- Process funds and update status == processed --}}
                                                        <a type="button" href="javascript:void(0)" class="btn btn-danger" id="processbtn{{ $item->transaction_id }}" onclick="payoutProcessFund('{{ $item->transaction_id }}')"
                                                            >Process fund</a>

                                                        @else

                                                            <a type="button" href="javascript:void(0)" class="btn btn-success" style="cursor: not-allowed"
                                                            >Fund processed</a>
                                                        @endif



                                                    </td>


                                                </tr>

                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" align="center">No record</td>
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
