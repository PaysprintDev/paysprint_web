@extends('layouts.dashboard')

@section('dashContent')


    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\OrganizationPay; ?>
    <?php use App\Http\Controllers\ClientInfo; ?>
    <?php use App\Http\Controllers\AnonUsers; ?>
    <?php use App\Http\Controllers\Statement; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ strtoupper(Request::get('gateway')) }} Activity Log
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">{{ strtoupper(Request::get('gateway')) }} Activity Log</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">{{ strtoupper(Request::get('gateway')) }} Activity Log</h3>

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
                                        <th>Transaction ID</th>
                                        <th>Name</th>
                                        <th>Message</th>
                                        <th>Gateway</th>
                                        <th>Country</th>
                                        <th>Activity</th>
                                        <th>Details</th>
                                        <th>Date</th>
                                        @if (Request::get('gateway') == 'paystack')
                                            <th>Action</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                        @elseif(Request::get('gateway') == 'Partner')
                                        <th>Partner</th>
                                        <th>Action</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        @else
                                            <th>Action</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data['activity']) > 0)
                                        <?php $i = 1; ?>
                                        @foreach ($data['activity'] as $data)
                                            <tr>
                                                <td>{{ $i++ }}</td>

                                                <td>{{ $data->transaction_id }}</td>

                                                @if ($userStatement = \App\Statement::where('reference_code', $data->transaction_id)->first())
                                                    @if (isset($userStatement))
                                                        @if ($userStatement = \App\User::where('email', $userStatement->user_id)->first())
                                                            <td>
                                                                {{ $userStatement->name }} {!! $data->flag_state == 1 ? '<img src="https://img.icons8.com/emoji/20/000000/triangular-flag.png"/>' : '' !!}
                                                            </td>
                                                        @else
                                                            <td>- {!! $data->flag_state == 1 ? '<img src="https://img.icons8.com/emoji/20/000000/triangular-flag.png"/>' : '' !!}</td>
                                                        @endif
                                                    @else
                                                        <td>- {!! $data->flag_state == 1 ? '<img src="https://img.icons8.com/emoji/20/000000/triangular-flag.png"/>' : '' !!}</td>
                                                    @endif
                                                @else
                                                    <td>- {!! $data->flag_state == 1 ? '<img src="https://img.icons8.com/emoji/20/000000/triangular-flag.png"/>' : '' !!}</td>
                                                @endif

                                                <td>{{ $data->message }}</td>
                                                <td>{{ strtoupper($data->gateway) }}</td>
                                                <td>{{ strtoupper($data->country) }}</td>
                                                <td>{{ $data->activity }}</td>
                                                <td><a href="{{ route('check transaction', $data->transaction_id) }}">View details</a></td>
                                                <td>{{ date('d/M/Y', strtotime($data->created_at)) }}</td>
                                                @if (Request::get('gateway') == 'paystack')
                                                    <td>
                                                        <a type="button" class="btn btn-primary"
                                                            href="{{ route('check transaction', $data->transaction_id) }}">Details</a>
                                                    </td>
                                                @endif
                                                @if (Request::get('gateway') == 'Partner')
                                                    <td>
                                                        {{ $data->partner }}
                                                    </td>
                                                @endif
                                                @if ($data->flag_state == 0)
                                                    <td>

                                                        <form action="{{ route('flag this money') }}" method="post"
                                                            id="flag{{ $data->transaction_id }}">@csrf <input
                                                                type="hidden" name="transaction_id"
                                                                value="{{ $data->transaction_id }}"></form>

                                                        <a type="button" class="btn btn-warning" href="javascript:void(0)"
                                                            onclick="flagMoney('flag', '{{ $data->transaction_id }}')">Flag</a>

                                                    </td>
                                                @else
                                                    <td>
                                                        <a type="button" class="btn btn-default"
                                                            style="background: black; color: white; cursor: not-allowed;"
                                                            href="javascript:void(0)"
                                                            style="cursor: not-allowed">Flagged</a>
                                                    </td>
                                                @endif
                                                <td>
                                                    @if ($data->reversal_state == 0)

                                                        @if ($data->hold_fee == 0)

                                                        <a type="button" class="btn btn-danger" href="javascript:void(0)"
                                                            onclick="reverseFee('{{ $data->transaction_id }}')">Reverse
                                                            <img src="https://img.icons8.com/office/20/000000/spinner-frame-4.png"
                                                                class="fa fa-spin spin{{ $data->transaction_id }} disp-0"></a>


                                                                @else

                                                                <a type="button" class="btn btn-danger" href="javascript:void(0)" style="cursor: not-allowed" disabled>Reverse
                                                            <img src="https://img.icons8.com/office/20/000000/spinner-frame-4.png"
                                                                class="fa fa-spin spin{{ $data->transaction_id }} disp-0"></a>

                                                        @endif

                                                    @else
                                                        <a type="button" class="btn btn-info" href="javascript:void(0)"
                                                            style="cursor: not-allowed">Reversed</a>
                                                    @endif

                                                </td>
                                                <td>
                                                    @if ($data->hold_fee == 1)
                                                        @if ($userStatement = \App\Statement::where('reference_code', $data->transaction_id)->first())
                                                            @if ($userStatement = \App\User::where('email', $userStatement->user_id)->first())
                                                                @if ($userStatement->account_check == 2)
                                                                    <a type="button" class="btn btn-primary"
                                                                        href="javascript:void(0)"
                                                                        onclick="releaseFee('{{ $data->transaction_id }}')">Release
                                                                        <img src="https://img.icons8.com/office/20/000000/spinner-frame-4.png"
                                                                            class="fa fa-spin spinFee{{ $data->transaction_id }} disp-0"></a>
                                                                @else
                                                                    <a type="button" class="btn btn-primary"
                                                                        href="javascript:void(0)" onclick="releaseFee('{{ $data->transaction_id }}')">Release
                                                                        <img src="https://img.icons8.com/office/20/000000/spinner-frame-4.png"
                                                                            class="fa fa-spin spinFee{{ $data->transaction_id }} disp-0"></a>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @else
                                                        <a type="button" class="btn btn-success" href="javascript:void(0)"
                                                            style="cursor: not-allowed">Released</a>
                                                    @endif

                                                </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            @if (Request::get('gateway') == 'paystack' || Request::get('gateway') == 'Partner')
                                                <td colspan="11" align="center">No record available</td>
                                            @else
                                                <td colspan="9" align="center">No record available</td>
                                            @endif
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
