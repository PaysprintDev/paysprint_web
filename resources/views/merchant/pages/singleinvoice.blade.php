@extends('layouts.merch.merchant-dashboard')


@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <h3>Create and Send Invoice</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Create and Send Invoice</li>
                            <li class="breadcrumb-item">Single Invoice</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h5>Step 1</h5>
                        </div>
                        <div class="card-body">
                            <form class="f1" method="post"  id="formElem">
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
                                            <label for="f1-first-name single_firstname">Customer First Name</label>
                                            <input type="text" name="single_firstname" id="single_firstname"
                                                class="f1-first-name form-control" placeholder="Firstname">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="f1-last-name single_lastname">Customer Last Name</label>
                                            <input type="text" name="single_lastname" id="single_lastname"
                                                class="f1-last-name form-control" placeholder="Lastname">
                                        </div>
                                        <div class="form-group">
                                            <label for="f1-business-name single_businessname">Business Name</label>
                                            <input type="text" name="single_businessname" id="single_businessname"
                                                class="f1-business-name form-control" placeholder="Business Name">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="single_email">Customer Email</label>
                                            <input type="text" name="single_email" id="single_email" class="form-control"
                                                placeholder="Email Address">

                                            <strong><small class="text-info emailcheck disp-0"></small></strong>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="f1-telephone single_telephone">Customer Telephpne</label>
                                            <input type="tel" name="single_telephone" id="single_telephone"
                                                class="f1-telephone form-control"
                                                placeholder="Telephone e.g +{{ $data['getpersonalData']->code }}-123456789">
                                            <strong><small class="text-info phonecheck disp-0"></small></strong>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="f1-service service">Type of service</label>
                                                <select name="single_service" class="f1-service form-control"
                                                    id="single_service">
                                                    @if (count($data['getServiceType']) > 0)
                                                        @foreach ($data['getServiceType'] as $item)
                                                            <option value="{{ $item->name }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        <option value="">Create Service Type</option>

                                                    @endif


                                                </select>
                                            </div>
                                        </div>


                                        <div class="row disp-0 specific">
                                            <div class="col-md-12 form-group">
                                                <label for="f1-service-specify single_service_specify">Specify Service
                                                    Type</label>
                                                <input type="text" name="single_service_specify" id="single_service_specify"
                                                    class="f1-service-specify form-control" value="NULL">
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12 form-group">

                                                <label for="f1-install-pay single_installpay">Accept Installmental
                                                    Payment</label>
                                                <select name="single_installpay" class="f1-install-pay form-control"
                                                    id="single_installpay">
                                                    <option value="No">No</option>
                                                    <option value="Yes">Yes</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="row instlim disp-0">
                                            <div class="col-md-12 form-group">

                                                <label for="f1-install-limit single_service">Kindly Set Installmental
                                                    Limt</label>
                                                <select name="single_installlimit" class="f1-install-limit form-control"
                                                    id="single_installlimit">
                                                    <option value="0">Select limit</option>
                                                    @for ($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>

                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-md-12 form-group">

                                                <label for="f1-invoice-generate service">Generate Invoice Number</label>
                                                <select name="single_invoice_generate"
                                                    class="f1-invoice-generate form-control" id="single_invoice_generate">
                                                    <option value="">Select Option</option>
                                                    <option value="Manual">Manual</option>
                                                    <option value="Auto Generate">Auto Generate</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="f1-invoice-number single_invoiceno">Invoice Number</label>
                                            <input type="text" name="single_invoiceno" id="single_invoiceno"
                                                class="f1-invoice-number form-control" readonly="">
                                        </div>
                                    </div>
                                    <div class="f1-buttons">
                                        <button class="btn btn-primary btn-next" type="button">Next</button>
                                    </div>
                                </fieldset>


                                <fieldset>
                                    <div class="form-group">
                                        <label for="single_transaction_ref">Transaction Reference Number</label>
                                        <input type="text" name="single_transaction_ref" id="single_transaction_ref"
                                            class="form-control" value="{{ 'PS_' . date('dmY') . time() }}" readonly>
                                    </div>

                                    <div class="row disp-0">
                                        <div class="col-md-12 form-group">

                                            <label for="single_payee_ref_no">Transaction Ref.</label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="text" name="single_payee_ref_no" id="single_payee_ref_no"
                                                        class="form-control" value="NULL">
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 form-group">

                                            <label for="single_payment_due_date">Transaction Date</label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="date" name="single_transaction_date"
                                                        id="single_transaction_date" class="form-control">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class="form-group">
                                            <label for="f1-repeat-password">Description</label>
                                            <textarea id="single_description" name="single_description"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="f1-buttons">
                                        <button class="btn btn-primary btn-previous" type="button">Previous</button>
                                        <button class="btn btn-primary btn-next" type="button">Next</button>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-2 form-group">
                                            <label for="single_currency">Currency </label>
                                            <select name="single_currency" id="single_currency" class="form-control">
                                                @if (count($data['getimt']) > 0)

                                                    <option selected value="{{ $data['getpersonalData']->currencyCode }}">
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
                                                @endif

                                            </select>
                                        </div>
                                        <div class="col-md-10 form-group">
                                            <label for="single_amount">Amount </label>
                                            <input type="number" min="0.00" step="0.01" name="single_amount"
                                                id="single_amount" class="form-control">
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="col-md-12 form-group">

                                            <label for="single_tax">Tax </label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <select name="single_tax" id="single_tax" class="form-control">
                                                        <option value="">Select Tax</option>
                                                        @if (count($data['getTax']) > 0)
                                                            @foreach ($data['getTax'] as $tax)
                                                                <option value="{{ $tax->id }}">
                                                                    {{ number_format($tax->rate, 2) . '% ' . $tax->name . ' -  (' . $tax->agency . ')' }}
                                                                </option>
                                                            @endforeach
                                                            <option value="No Tax">No Tax</option>
                                                        @else
                                                            <option value="Set Up Tax">Set Up Tax</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 form-group">

                                            <label for="single_tax_amount">Tax Amount </label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="text" min="0.00" step="0.01" name="single_tax_amount"
                                                        id="single_tax_amount" class="form-control" readonly>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 form-group">

                                            <label for="single_total_amount">Total Amount </label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="text" min="0.00" step="0.01" name="single_total_amount"
                                                        id="single_total_amount" class="form-control" readonly>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 form-group">

                                            <label for="single_payment_due_date">Payment Due Date</label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="date" name="single_payment_due_date"
                                                        id="single_payment_due_date" class="form-control">
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 form-group">

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

                                    <div class="row recuring_time disp-0">
                                        <div class="col-md-12 form-group">

                                            <label for="service">Reminder</label>
                                            <select name="single_reminder_service" class="form-control"
                                                id="single_reminder_service">
                                                @for ($i = 1; $i <= 31; $i++)
                                                    <option value="{{ $i }}">{{ $i }} Day(s)
                                                    </option>
                                                @endfor

                                            </select>

                                        </div>
                                    </div>


                                    <div class="f1-buttons">
                                        <button class="btn btn-primary btn-previous" type="button">Previous</button>
                                        <a class="btn btn-primary " type="button" href="#">Preview</a>
                                        {{-- <button class="btn btn-primary btn-submit" type="submit">Submit</button> --}}
                                        <button type="button" class="btn btn-primary btn-block btn-submit"
                                            onclick="handShake('singleinvoice')" id="cardSubmit">Submit</button>
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
