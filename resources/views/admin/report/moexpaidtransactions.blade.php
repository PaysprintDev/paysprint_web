@extends('layouts.dashboard')

@section('dashContent')
    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\OrganizationPay; ?>
    <?php use App\Http\Controllers\ClientInfo; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                MOEX - PS PAID TRANSACTIONS
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">MOEX - PS PAID TRANSACTIONS</li>
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
                            <h3 class="box-title">&nbsp;</h3> <br>
                        </div>
                        <!-- /.box-header -->

                        <table class="table table-striped table-hover table-responsive" id="example1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Transaction ID</th>
                                    <th>Details</th>
                                    <th>Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>

                                @if (count($data['paid']) > 0)

                                @php
                                    $i = 1;
                                @endphp

                                @foreach ($data['paid'] as $item)

                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item->transactionId }}</td>
                                    <td>
                                        @php
                                            $body = json_decode($item->body);
                                            $bodyKey = get_object_vars($body);
                                        @endphp


                                        <p>
                                        <p>Sender: {{$body->Sender}}</p>
                                        <p>SenderAddress: {{$body->SenderAddress}}</p>
                                        <p>SenderCity: {{$body->SenderCity}}</p>
                                        <p>SenderCountry: {{$body->SenderCountry}}</p>
                                        <p>Receiver: {{$body->Receiver}}</p>
                                        <p>ReceiverAddress: {{$body->ReceiverAddress}}</p>
                                        <p>ReceiverCity: {{$body->ReceiverCity}}</p>
                                        <p>ReceiverCountry: {{$body->ReceiverCountry}}</p>
                                        <p>AmountToPay: {{$body->AmountToPay}}</p>
                                        <p>CurrencyToPay: {{$body->CurrencyToPay}}</p>
                                        <p>AmountSent: {{$body->AmountSent}}</p>
                                        <p>CurrencySent: {{$body->CurrencySent}}</p>
                                        <p>PaymentBranchAuxId: {{$body->PaymentBranchAuxId}}</p>
                                        <p>TransactionStatus: {{$body->TransactionStatus}}</p>
                                        </p>

                                    </td>
                                    <td>{{ date('d/m/Y H:i a', strtotime($item->created_at)) }}</td>

                                @endforeach

                                @else
                                    <td colspan="3" align="center">No new record</td>
                                @endif
                                </tr>



                            </tbody>
                        </table>

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
