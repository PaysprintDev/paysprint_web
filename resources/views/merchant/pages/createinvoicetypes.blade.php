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
                                                    <label class="control-label" for="inputSuccess"> Invoice Type</label>
                                                    <input type="text" class="form-control" name="name" id="name"
                                                        placeholder="e.g Accomodation">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.box-body -->

                                    <div class="box-footer">
                                        <button type="button" class="btn btn-primary btn-block"
                                            onclick="handShake('createservicetype')" id="cardSubmit">Submit</button>
                                    </div>

                                </form>

                                <hr>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered nowrap" id="datatable-ordering">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Invoice Types</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>System Architect</td>

                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Accountant</td>

                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Junior Technical Author</td>

                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Senior Javascript Developer</td>

                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Accountant</td>

                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>Integration Specialist</td>

                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td>Sales Assistant</td>

                                            </tr>
                                            <tr>
                                                <td>8</td>
                                                <td>Integration Specialist</td>

                                            </tr>
                                            <tr>
                                                <td>9</td>
                                                <td>Javascript Developer</td>

                                            </tr>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Invoice Types</th>

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
