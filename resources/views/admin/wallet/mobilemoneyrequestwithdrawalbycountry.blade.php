@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\AddBank; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Mobile Money Withdrawal Request
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Mobile Money Withdrawal Request</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-0">
                                <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i
                                        class="fas fa-chevron-left"></i> Go back</button>
                            </div>
                        </div>
                        {!! session('msg') !!}
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body table table-responsive">

                        <table class="table table-bordered table-striped" id="example3">

                            <thead>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3 id="period_start"></h3>
                                    </div>
                                    <div class="col-md-6">
                                        <h3 id="period_stop"></h3>
                                    </div>
                                </div>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Mobile Money Provider</th>
                                    <th>Account Number</th>
                                    <th>Transaction Reference</th>
                                    <th>Amount To Send</th>
                                    <th>Status</th>
                                    <th>Request Date</th>
                                    <th>Action</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($data['bankRequestWithdrawal']) > 0)
                                <?php $i = 1;?>
                                @foreach ($data['bankRequestWithdrawal'] as $data)
                                <tr>
                                    <td>{{ $i++ }}</td>

                                    @if($user = \App\User::where('ref_code', $data->ref_code)->first())

                                    @php
                                    $currencyCode = $user->currencyCode;
                                    @endphp

                                    @if ($user->accountType == "Merchant")
                                    <td>{{ $user->businessname }}</td>
                                    @else
                                    <td>{{ $user->name }}</td>
                                    @endif

                                    @else

                                    @php
                                    $currencyCode = "-";
                                    @endphp

                                    @endif

                                    @if($bank = \App\AddBank::where('user_id', $user->id)->where('country',
                                    $user->country)->first())

                                    <td>{{ $bank->bankName }}</td>
                                    <td>{{ $bank->accountNumber }}</td>
                                    <td>{{ $data->transaction_id }}</td>
                                    <td style="font-weight: 700;">{{ $currencyCode.'
                                        '.number_format($data->amountToSend, 2) }}</td>
                                    <td style="font-weight: bold; color: {{ $data->status == " PENDING" ? "red"
                                        : "green" }}">{{ $data->status }}</td>

                                    @endif


                                    <td>
                                        {{ date('d/M/Y h:i:a', strtotime($data->created_at)) }}
                                    </td>
                                    <td>
                                        @php
                                        if($data->status == "PENDING"){
                                        $btnClass = "btn btn-primary btn-block";
                                        $btnVal = "Process Payment";
                                        $disabled = "";
                                        }
                                        else{
                                        $btnClass = "btn btn-success btn-block";
                                        $btnVal = "Account Paid";
                                        $disabled = "disabled";
                                        }
                                        @endphp
                                        <button class="btn btn-primary" id="btns{{ $data->id }}"
                                            onclick="processMobileMoney('{{ $data->id }}');">Process Payment</button>
                                        <form action="{{ route('Ajaxpaymobilemoneywithdrawal', $data->id) }}"
                                            method="post" style="visibility: hidden"
                                            id="processmobilemoney{{ $data->id }}">
                                            @csrf
                                            <input type="hidden" name="withdrawid" value="{{ $data->id }}">
                                        </form>
                                    </td>

                                    <td>
                                        <a class="btn btn-warning"
                                            href="{{ route('return bank withdrawal request', $data->transaction_id) }}">Return
                                            Withd. Request</a>
                                    </td>

                                </tr>
                                @endforeach

                                @else
                                <tr>
                                    <td colspan="12" align="center">No record available</td>
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