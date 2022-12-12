@extends('layouts.dashboard')


@section('dashContent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Moex - PS Transaction

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $data['paid'] }}</h3>
                        <p>All Paid Transaction</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('get moex paid transaction') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>


            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $data['payed'] }}</h3>
                        <p>All Payed Transaction</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('get moex payed transaction') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>


            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ $data['pending'] }}</h3>
                        <p>All Pending Transaction</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('get moex pending transaction') }}" class="small-box-footer">View details <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>

        <div class="row">
                <div class="col-xs-12">
                        <h3>Verify a Transaction Here...</h3>
                    <div class="box container">
                        <div class="mx-auto">
                            <div class="col-md-6">
                                <br>
                                <br>
                                <form>
                                    <h2 class="text-center">Get Record</h2>
                                    <hr>
                                    <div class="form-group">
                                        <label for="transactionId">Transaction Id</label>
                                        <input type="text" class="form-control" id="transactionId" aria-describedby="transactionIdHelp" placeholder="Enter transaction id">
                                        <small id="transactionIdHelp" class="form-text text-muted">Please provide the transaction id to verify transaction.</small>
                                    </div>

                                    <button type="button" class="btn btn-primary btn-block" onclick="getTransactionReference()" id="btn">Fetch Record</button>
                                </form>
                                <br>
                                <br>
                            </div>

                            <div class="col-md-6">
                                <br>
                                <br>
                                <form>
                                    <h2 class="text-center">Confirm Payment</h2>
                                    <hr>
                                    <div class="form-group">
                                        <label for="IdTransaction">Transaction Id</label>
                                        <input type="text" class="form-control" id="IdTransaction" aria-describedby="IdTransactionHelp" placeholder="Enter Transaction Id">
                                        <small id="IdTransactionHelp" class="form-text text-muted">Please provide the transaction id to verify transaction.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="PaymentDate">Payment Date</label>
                                        <input type="text" class="form-control" id="PaymentDate" aria-describedby="PaymentDateHelp" placeholder="Enter Payment Date">
                                        <small id="PaymentDateHelp" class="form-text text-muted">Please provide the payment date from transaction.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="ReceiverName">Receiver Name</label>
                                        <input type="text" class="form-control" id="ReceiverName" aria-describedby="ReceiverNameHelp" placeholder="Enter Receiver Name">
                                        <small id="ReceiverNameHelp" class="form-text text-muted">Please provide the receiver name from transaction.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="ReceiverDocument">Receiver Document</label>
                                        <input type="text" class="form-control" id="ReceiverDocument" aria-describedby="ReceiverDocumentHelp" placeholder="Enter Receiver Document">
                                        <small id="ReceiverDocumentHelp" class="form-text text-muted">Please provide the receiver document from transaction.</small>
                                    </div>

                                    <button type="button" class="btn btn-primary btn-block" onclick="confirmPaymentMoex()" id="btnconfirm">Confirm Payment</button>
                                </form>
                                <br>
                                <br>
                            </div>
                        </div>

                        <br>
                        <br>

                        <div class="displayResponse"></div>

                        <br>
                        <br>

                    </div>
                </div>
            </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection
