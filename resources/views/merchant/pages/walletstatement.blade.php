@extends('layouts.merch.merchant-dashboard')


@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    {{-- <div class="col-lg-6">
                        <h3>Plugin DataTable</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../dashboard.html">Home</a></li>
                            <li class="breadcrumb-item">Tables</li>
                            <li class="breadcrumb-item">Data Tables</li>
                            <li class="breadcrumb-item active">Plug in</li>
                        </ol>
                    </div> --}}
                    <div class="col-lg-6">
                        {{-- <!-- Bookmark Start-->
                        <div class="bookmark">
                            <ul>
                                <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover"
                                        data-placement="top" title="" data-original-title="Tables"><i
                                            data-feather="inbox"></i></a></li>
                                <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover"
                                        data-placement="top" title="" data-original-title="Chat"><i
                                            data-feather="message-square"></i></a></li>
                                <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover"
                                        data-placement="top" title="" data-original-title="Icons"><i
                                            data-feather="command"></i></a></li>
                                <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover"
                                        data-placement="top" title="" data-original-title="Learning"><i
                                            data-feather="layers"></i></a></li>
                                <li>
                                    <a href="javascript:void(0)"><i class="bookmark-search" data-feather="star"></i></a>
                                    <form class="form-inline search-form">
                                        <div class="form-group form-control-search">
                                            <input type="text" placeholder="Search..">
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <!-- Bookmark Ends--> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <!-- DOM / jQuery  Starts-->

                <div class="card-body">

                    <div class="col-sm-12">
                        <div class="card">
                            {{-- <div class="card-header">
                                <h5>Ordering plug-ins (with type detection)</h5>
                                <span>This example shows ordering with using an enumerated type.</span>
                            </div> --}}
                            <div class="card-body">
                                <form action="#" method="POST" id="formElem">
                                    @csrf
                                    <div class="box-body">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group has-success">
                                                    {{-- <label for="service">Recurring</label> --}}
                                                    <select name="single_recurring_service" class="form-control"
                                                        id="single_recurring_service">
                                                        <option value="wallet">Wallet</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class=" col-md-6 ">
                                                <div class="form-group has-success">
                                                    {{-- <label for="single_payment_due_date">Transaction Date</label> --}}
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <input type="date" name="single_payment_due_date"
                                                                id="single_payment_due_date" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class=" col-md-6 ">
                                                <div class="form-group has-success">
                                                    {{-- <label for="single_payment_due_date">Transaction Date</label> --}}
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <input type="date" name="single_payment_due_date"
                                                                id="single_payment_due_date" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <!-- /.box-body -->

                                    <div class="box-footer">
                                        <button type="button" class="btn btn-primary btn-block"
                                            onclick="handShake('createservicetype')" id="cardSubmit">Check
                                            Transactions</button>
                                    </div>

                                </form>

                                <hr>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered nowrap" id="datatable-ordering">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Transx.ID</th>
                                                <th>Description</th>
                                                <th>Amount Paid</th>




                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>21/10/2021</td>
                                                <td>PS_2021102147</td>
                                                <td>Invoice on Consulting
                                                    FeePS_2021102147
                                                    21/10/2021 04:09 pm</td>
                                                <td>+₦5.00</td>



                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>22/10/2021</td>
                                                <td>invoice-221020211634897636</td>
                                                <td>Payment for Consulting
                                                    Fee from Walletinvoice-221020211634897636
                                                    22/10/2021 06:13 am</td>
                                                <td>-₦2,921.72</td>

                                            </tr>


                                            </tr>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Transx.ID</th>
                                                <th>Description</th>
                                                <th>Amount Paid</th>

                                            </tr>
                                        </tfoot>
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
