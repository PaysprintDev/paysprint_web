@extends('layouts.merch.merchant-dashboard')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        {{--  <section class="content-header">
            <h1>
                Create and Send Invoice
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Create and Send Invoice</li>
            </ol>
        </section>  --}}

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">



                <div class="box-body">

                    <div class="row">
                        <div class="col-md-2 col-md-offset-0">
                            <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i
                                    class="fas fa-chevron-left"></i> Go back</button>
                        </div>
                    </div>

                    {{-- Provide Form --}}
                    <form action="#" method="POST" id="formElem">
                        @csrf
                        <h1>STEP 1:</h1>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-success">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="single_firstname">Customer First Name</label>
                                                <input type="text" name="single_firstname" id="single_firstname"
                                                    class="form-control" placeholder="Firstname">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="single_firstname">Customer Last Name</label>
                                                <input type="text" name="single_lastname" id="single_lastname"
                                                    class="form-control" placeholder="Lastname">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-success">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="single_businessname">Business Name</label>
                                                <input type="text" name="single_businessname" id="single_businessname"
                                                    class="form-control" placeholder="Business Name">
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-success">
                                        <label for="single_email">Customer Email</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="text" name="single_email" id="single_email"
                                                    class="form-control" placeholder="Email Address">

                                                <strong><small class="text-info emailcheck disp-0"></small></strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-success">
                                        <label for="single_telephone">Customer Telephone</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                {{--  <input type="tel" name="single_telephone" id="single_telephone"
                                                    class="form-control"
                                                    placeholder="Telephone e.g +{{ $data['getpersonalData']->code }}-123456789">
                                                <strong><small class="text-info phonecheck disp-0"></small></strong>  --}}

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-success">
                                        <label for="single_service">Type of Service</label>
                                        <select name="single_service" class="form-control" id="single_service">
                                            {{--  @if (count($data['getServiceType']) > 0)
                                                @foreach ($data['getServiceType'] as $item)
                                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="">Create Service Type</option>

                                            @endif  --}}


                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row disp-0 specific">
                                <div class="col-md-12">
                                    <div class="form-group has-success">
                                        <label for="single_service_specify">Specify Service Type</label>
                                        <input type="text" name="single_service_specify" id="single_service_specify"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-success">
                                        <label for="single_service">Accept Installmental Payment</label>
                                        <select name="single_installpay" class="form-control" id="single_installpay">
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row instlim disp-0">
                                <div class="col-md-12">
                                    <div class="form-group has-success">
                                        <label for="single_service">Kindly Set Installmental Limt</label>
                                        <select name="single_installlimit" class="form-control" id="single_installlimit">
                                            <option value="0">Select limit</option>
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-success">
                                        <label for="single_service">Generate Invoice Number</label>
                                        <select name="single_invoice_generate" class="form-control"
                                            id="single_invoice_generate">
                                            <option value="">Select Option</option>
                                            <option value="Manual">Manual</option>
                                            <option value="Auto Generate">Auto Generate</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-success">
                                        <label for="single_invoiceno">Invoice Number</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="text" name="single_invoiceno" id="single_invoiceno"
                                                    class="form-control" readonly="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->

                        </div>
                        <!-- /.box-body -->

                        <h1>STEP 2:</h1>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-success">
                                        <label for="single_transaction_ref">Transaction Reference Number </label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="text" name="single_transaction_ref" id="single_transaction_ref"
                                                    class="form-control" value="{{ 'PS_' . date('dmY') . time() }}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row disp-0">
                                <div class="col-md-12">
                                    <div class="form-group has-success">
                                        <label for="single_payee_ref_no">Transaction Ref.</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="text" name="single_payee_ref_no" id="single_payee_ref_no"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-success">
                                        <label for="single_transaction_date">Transaction Date</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="date" name="single_transaction_date"
                                                    id="single_transaction_date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-success">
                                        <label for="single_description">Description</label>
                                        <textarea id="single_description" name="single_description"
                                            class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>

                        <h1>STEP 3:</h1>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-success">

                                        <div class="row">
                                            <div class="col-md-2">
                                                <label for="single_currency">Currency </label>
                                                <select name="single_currency" id="single_currency" class="form-control">
                                                    {{--  @if (count($data['getimt']) > 0)

                                                        <option selected
                                                            value="{{ $data['getpersonalData']->currencyCode }}">
                                                            {{ $data['getpersonalData']->country . ' ' . $data['getpersonalData']->currencyCode }}
                                                        </option>
                                                        @foreach ($data['getimt'] as $currencyItem)

                                                            @if ($currencyItem->currencyCode != $data['getpersonalData']->currencyCode)
                                                                <option value="{{ $currencyItem->currencyCode }}">
                                                                    {{ $currencyItem->name . ' ' . $currencyItem->currencyCode }}
                                                                </option>
                                                            @endif

                                                        @endforeach
                                                    @else
                                                        <option value="{{ $data['getpersonalData']->currencyCode }}">
                                                            {{ $data['getpersonalData']->country . ' ' . $data['getpersonalData']->currencyCode }}
                                                        </option>
                                                    @endif  --}}

                                                </select>
                                            </div>
                                            <div class="col-md-10">
                                                <label for="single_amount">Amount </label>
                                                <input type="number" min="0.00" step="0.01" name="single_amount"
                                                    id="single_amount" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-success">
                                        <label for="single_tax">Tax </label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <select name="single_tax" id="single_tax" class="form-control">
                                                    <option value="">Select Tax</option>
                                                    {{--  @if (count($data['getTax']) > 0)
                                                        @foreach ($data['getTax'] as $tax)
                                                            <option value="{{ $tax->id }}">
                                                                {{ number_format($tax->rate, 2) . '% ' . $tax->name . ' -  (' . $tax->agency . ')' }}
                                                            </option>
                                                        @endforeach
                                                        <option value="No Tax">No Tax</option>
                                                    @else
                                                        <option value="Set Up Tax">Set Up Tax</option>
                                                    @endif  --}}
                                                </select>
                                            </div>
                                        </div>
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

                            <div class="row recuring_time disp-0">
                                <div class="col-md-12">
                                    <div class="form-group has-success">
                                        <label for="service">Reminder</label>
                                        <select name="single_reminder_service" class="form-control"
                                            id="single_reminder_service">
                                            @for ($i = 1; $i <= 31; $i++)
                                                <option value="{{ $i }}">{{ $i }} Day(s)</option>
                                            @endfor

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>


                        <div class="box-footer">
                            <button type="button" class="btn btn-primary btn-block" onclick="handShake('singleinvoice')"
                                id="cardSubmit">Submit</button>
                        </div>
                    </form>


                </div>
                <!-- /.box-body -->

            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
