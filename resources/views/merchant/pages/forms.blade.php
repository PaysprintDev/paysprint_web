@extends('layouts.merch.merchant-dashboard')


@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <h3>Form Wizard With Icon</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../dashboard.html">Home</a></li>
                            <li class="breadcrumb-item">Forms</li>
                            <li class="breadcrumb-item">Form Layout</li>
                            <li class="breadcrumb-item active">Form Wizard 3</li>
                        </ol>
                    </div>
                    <div class="col-lg-6">
                        <!-- Bookmark Start-->
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
                        <!-- Bookmark Ends-->
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h5>Form Wizard with icon</h5>
                        </div>
                        <div class="card-body">
                            <form class="f1" method="post">
                                <div class="f1-steps">
                                    <div class="f1-progress">
                                        <div class="f1-progress-line" data-now-value="16.66" data-number-of-steps="3"></div>
                                    </div>
                                    <div class="f1-step active">
                                        <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                                        <p>Step 1</p>
                                    </div>
                                    <div class="f1-step">
                                        <div class="f1-step-icon"><i class="fa fa-key"></i></div>
                                        <p>Step 2</p>
                                    </div>
                                    <div class="f1-step">
                                        <div class="f1-step-icon"><i class="fa fa-twitter"></i></div>
                                        <p>Step 3</p>
                                    </div>
                                </div>
                                <fieldset>
                                    <div class='row'>
                                        <div class="col-md-6 form-group">
                                            <label for="f1-first-name">First Name</label>
                                            <input class="form-control" id="f1-first-name" type="text"
                                                name="f1-first-name" placeholder="name@example.com" required="">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="f1-last-name">Last name</label>
                                            <input class="f1-last-name form-control" id="f1-last-name" type="text"
                                                name="f1-last-name" placeholder="Last name..." required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="f1-last-name">Business Name</label>
                                            <input class="f1-last-name form-control" id="f1-last-name" type="text"
                                                name="f1-last-name" placeholder="Business Name ..." required="">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="f1-last-name">Customer Email</label>
                                            <input class="f1-last-name form-control" id="f1-last-name" type="text"
                                                name="f1-last-name" placeholder="dmj@example.com" required="">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="f1-last-name">Customer Telephpne</label>
                                            <input class="f1-last-name form-control" id="f1-last-name" type="text"
                                                name="f1-last-name" placeholder="01348894" required="">
                                        </div>
                                        {{-- <div class="form-group">
					  <label for="f1-last-name">Type of service</label>
					  <div class="form-control" required="">
					  <select>
					  <option>Medias</option>
					  <option>Consulting</option>
					  <option>Utility Bills</option>
					  </select>
					  </div>
					  <input class="f1-last-name form-control" id="f1-last-name" type="text" name="f1-last-name" placeholder="" required="">
					</div> --}}

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group has-success">
                                                    <label for="service">Type of service</label>
                                                    <select name="single_recurring_service" class="form-control"
                                                        id="single_recurring_service">
                                                        <option value="medias">Medias</option>
                                                        <option value="consulting">Consulting</option>
                                                        <option value="utility bills">Utility Bills</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group has-success">
                                                    <label for="service">Accept Installmental Payment</label>
                                                    <select name="single_recurring_service" class="form-control"
                                                        id="single_recurring_service">
                                                        <option value=""></option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="form-group">
					  <label for="f1-last-name">Accept Installmental Payment</label>
					  <div class="form-control" required="">
					  <select>
					  <option></option>
					  <option>Yes</option>
					  <option>NO</option>
					  </select>
					  </div>
					  <input class="f1-last-name form-control" id="f1-last-name" type="text" name="f1-last-name" placeholder="Last name..." required="">
					</div> --}}
                                        {{-- <div class="form-group">
					  <label for="f1-last-name">Generate Invoice Number</label>
					  <div class="form-control" required="">
					  <select>
					  <option>Select Option</option>
					  <option>Manual</option>
					  <option>Autogenerate</option>
					  </select>
					  </div>
					  <input class="f1-last-name form-control" id="f1-last-name" type="text" name="f1-last-name" placeholder="Last name..." required="">
					</div> --}}

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group has-success">
                                                    <label for="service">Generate Invoice Number</label>
                                                    <select name="single_recurring_service" class="form-control"
                                                        id="single_recurring_service">
                                                        <option value="">Select Option</option>
                                                        <option value="manual">Manual</option>
                                                        <option value="autogenerate">Autogenerate</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="f1-last-name">Invoice Number</label>
                                            <input class="f1-last-name form-control" id="f1-last-name" type="text"
                                                name="f1-last-name" placeholder="" required="">
                                        </div>
                                    </div>
                                    <div class="f1-buttons">
                                        <button class="btn btn-primary btn-next" type="button">Next</button>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="form-group">
                                        <label for="f1-email">Transaction Reference Number</label>
                                        <input class="f1-email form-control" id="f1-email" type="text"
                                            value="{{ 'PS_' . date('dmY') . time() }}" readonly>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group has-success">
                                                <label for="single_payment_due_date">Transaction Date</label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="date" name="single_payment_due_date"
                                                            id="single_payment_due_date" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class="form-group">
                                            <label for="f1-repeat-password">Description</label>
                                            <input class="f1-repeat-password form-control" id="f1-last-name" type="text"
                                                name="f1-last-name" placeholder="" required="">
                                        </div>
                                    </div>
                                    <div class="f1-buttons">
                                        <button class="btn btn-primary btn-previous" type="button">Previous</button>
                                        <button class="btn btn-primary btn-next" type="button">Next</button>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="single_currency">Currency </label>
                                            <select name="single_currency" id="single_currency" class="form-control">

                                            </select>
                                        </div>
                                        <div class="col-md-10">
                                            <label for="single_amount">Amount </label>
                                            <input type="number" min="0.00" step="0.01" name="single_amount"
                                                id="single_amount" class="form-control">
                                        </div>
                                    </div>

                                    {{-- <div class="form-group">
					  <label for="f1-last-name">Tax</label>
					  <div class="form-control" required="">
					  <select>
					  <option>Select Tax</option>
					  <option>5%</option>
					  <option>No TAX</option>
					  </select>
					  </div>
					  <input class="f1-last-name form-control" id="f1-last-name" type="text" name="f1-last-name" placeholder="Last name..." required="">
					</div> --}}

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group has-success">
                                                <label for="service">Tax</label>
                                                <select name="single_recurring_service" class="form-control"
                                                    id="single_recurring_service">
                                                    <option value="">Select Tax</option>
                                                    <option value="5%">5%</option>
                                                    <option value="no tax">No TAX</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group has-success">
                                                <label for="single_tax_amount">Tax Amount </label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text" min="0.00" step="0.01" name="single_tax_amount"
                                                            id="single_tax_amount" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group has-success">
                                                <label for="single_total_amount">Total Amount </label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text" min="0.00" step="0.01" name="single_total_amount"
                                                            id="single_total_amount" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group has-success">
                                                <label for="single_payment_due_date">Payment Due Date</label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="date" name="single_payment_due_date"
                                                            id="single_payment_due_date" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group has-success">
                                                <label for="service">Recurring</label>
                                                <select name="single_recurring_service" class="form-control"
                                                    id="single_recurring_service">
                                                    <option value="">Select Option</option>
                                                    <option value="One Time">One Time</option>
                                                    <option value="Weekly">Weekly</option>
                                                    <option value="Bi-Monthly">Bi-Monthly</option>
                                                    <option value="Monthly">Monthly</option>
                                                    <option value="Quaterly">Quaterly</option>
                                                    <option value="Half Yearly"> Half Yearly</option>
                                                    <option value="Yearly"> Yearly</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- <div class="form-group">
					  <label class="sr-only">DD</label>
					  <input class="form-control" id="dd" type="number" placeholder="dd" required="">
					</div>
					<div class="form-group">
					  <label class="sr-only">MM</label>
					  <input class="form-control" id="mm" type="number" placeholder="mm" required="">
					</div>
					<div class="form-group">
					  <label class="sr-only">YYYY</label>
					  <input class="form-control" id="yyyy" type="number" placeholder="yyyy" required="">
					</div> --}}
                                    <div class="f1-buttons">
                                        <button class="btn btn-primary btn-previous" type="button">Previous</button>
                                        <a class="btn btn-primary " type="button" href="{{ route('invoice page') }}">Preview</a>
                                        <button class="btn btn-primary btn-submit" type="submit">Submit</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Container-fluid Ends-->
    </div>
@endsection
