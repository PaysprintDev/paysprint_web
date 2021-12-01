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
                        <div class="col-sm-12">
                            <div class="card">

                                <div class="card-body">
                                    <form class="theme-form mega-form">
                                        <div class="mb-3">
                                            <label class="col-form-label">Name of Tax</label>
                                            <input class="form-control" type="Number"
                                                placeholder="Enter contact number" />
                                        </div>

                                        <div class='row'>

                                            <div class='col-md-6 mb-3'>
                                                <label class="col-form-label">Tax Rate%</label>
                                                <input class="form-control" type="text" placeholder="Tax Rate%" />
                                            </div>
                                            <div class='col-md-6 mb-3'>
                                                <label class="col-form-label">Name Of Agency</label>
                                                <input class="form-control" type="email" placeholder="Name Of Agency" />
                                            </div>

                                        </div>



                                    </form>

                                </div>

                                <hr>

                                <div class="table-responsive">
                                    <div class="container">
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
                                                <tr>
                                                    <td>1</td>
                                                    <td>VAT</td>
                                                    <td>7.50%</td>
                                                    <td>FIRS</td>

                                                    <td align="center">

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <a href="#" style="color: navy; font-weight: bold;">Edit</a>
                                                                <form action="#" method="POST" class="disp-0">@csrf
                                                                    <input type="hidden" name="id" id="id" value="">
                                                                </form>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <a href="#" style="color: red; font-weight: bold;"
                                                                    onclick="delhandShake('deletetax', )">Delete</a>
                                                            </div>
                                                        </div>


                                                    </td>
                                                </tr>













                                            </tbody>
                                    </div>
                                    </table>

                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <!-- Container-fluid Ends-->
        </div>
    @endsection
