@extends('layouts.dashboard')

@section('dashContent')


    <?php use App\Http\Controllers\ClientInfo; ?>
    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\Admin; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                User details
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">User details</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">User details</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-md-2 col-md-offset-10">
                                <button class="btn btn-secondary btn-block bg-blue" onclick="goBack()"><i
                                        class="fas fa-chevron-left"></i> Go back</button>
                            </div>

                            <table class="table table-bordered table-striped">

                                <tbody>
                                    @if (isset($getthisuser))

                                        <tr>
                                            <td class="mainText" colspan="2" align="left">
                                                @if ($getthisuser->avatar != null)
                                                    <a href="{{ $getthisuser->avatar }}">
                                                        <img src="{{ $getthisuser->avatar }}"
                                                            alt="{{ $getthisuser->avatar }}" srcset=""
                                                            style="width: 150px; height: 150px; border-radius: 100%; object-fit: contain;">
                                                    </a>
                                                @else
                                                    <a href="#">
                                                        <img src="https://res.cloudinary.com/pilstech/image/upload/v1617797524/paysprint_asset/paysprint_jpeg_black_bk_2_w4hzub.jpg"
                                                            alt="https://res.cloudinary.com/pilstech/image/upload/v1617797524/paysprint_asset/paysprint_jpeg_black_bk_2_w4hzub.jpg"
                                                            srcset=""
                                                            style="width: 150px; height: 150px; border-radius: 100%; object-fit: contain;">
                                                    </a>
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td class="mainText">{{ $getthisuser->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email Address</td>
                                            <td class="mainText">{{ $getthisuser->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Telephone</td>
                                            <td class="mainText">{{ $getthisuser->telephone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td class="mainText">{{ $getthisuser->address }}</td>
                                        </tr>
                                        <tr>
                                            <td>City</td>
                                            <td class="mainText">{{ $getthisuser->city }}</td>
                                        </tr>
                                        <tr>
                                            <td>Postal/Zip Code</td>
                                            <td class="mainText">{{ $getthisuser->zip }}</td>
                                        </tr>
                                        <tr>
                                            <td>Province/State</td>
                                            <td class="mainText">{{ $getthisuser->state }}</td>
                                        </tr>
                                        <tr>
                                            <td>Country</td>
                                            <td class="mainText">{{ $getthisuser->country }}</td>
                                        </tr>

                                        @if ($getthisuser->country == 'Nigeria')
                                            <tr>
                                                <td>Bank Verification Number</td>
                                                <td class="mainText">{{ $getthisuser->bvn_number }}</td>
                                            </tr>
                                            <tr>
                                                <td>Bank Name</td>
                                                <td class="mainText">{{ $getthisuser->bvn_bank }}</td>
                                            </tr>
                                            <tr>
                                                <td>Bank Account Number</td>
                                                <td class="mainText">{{ $getthisuser->bvn_account_number }}</td>
                                            </tr>
                                            <tr>
                                                <td>Account Name</td>
                                                <td class="mainText">{{ $getthisuser->bvn_account_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Verification Status</td>
                                                <td style="font-weight: bold;"
                                                    class="mainText {{ $getthisuser->bvn_verification >= 1 ? 'text-success' : 'text-danger' }}">
                                                    {{ $getthisuser->bvn_verification >= 1 ? 'Verified' : 'Not verified' }}
                                                </td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <td>Date Of Birth</td>
                                            <td class="mainText">
                                                {{ $getthisuser->dayOfBirth . '/' . $getthisuser->monthOfBirth . '/' . $getthisuser->yearOfBirth }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Type of Account</td>
                                            <td class="mainText">{{ $getthisuser->accountType }}</td>
                                        </tr>

                                        @if ($getthisuser->accountType == 'Merchant')
                                            <tr>
                                                <td colspan="2">
                                                    <h3 style="font-weight: bold;">BUSINESS INFORMATION</h3>
                                                </td>

                                            </tr>

                                            @if ($merchantDetail = \App\Admin::where('email', $getthisuser->email)->first())
                                                <tr>
                                                    <td>Username</td>
                                                    <td class="mainText" style="font-weight: 900; color: navy;">
                                                        {{ strtoupper($merchantDetail->username) }}</td>
                                                </tr>
                                            @endif



                                            <tr>
                                                <td>Legal Entity Name</td>
                                                <td class="mainText">{{ $getthisuser->businessname }}</td>
                                            </tr>
                                            <tr>
                                                <td>Corporation Type</td>
                                                <td class="mainText">{{ $getthisuser->corporationType }}</td>
                                            </tr>
                                            <tr>
                                                <td>Articles of Incorporation</td>
                                                <td class="mainText">

                                                    <small style="font-weight: bold;">
                                                        @if ($getthisuser->incorporation_doc_front != null)
                                                            <a href="{{ $getthisuser->incorporation_doc_front }}"
                                                                target="_blank">Front view</a>
                                                            @endif - @if ($getthisuser->incorporation_doc_back != null)
                                                                <a href="{{ $getthisuser->incorporation_doc_back }}"
                                                                    target="_blank">Back view</a>
                                                            @endif
                                                    </small>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Register of Directors</td>
                                                <td class="mainText">

                                                    <small style="font-weight: bold;">
                                                        @if ($getthisuser->directors_document != null)
                                                            <a href="{{ $getthisuser->directors_document }}"
                                                                target="_blank">View</a>
                                                        @endif
                                                    </small>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Register of Shareholders</td>
                                                <td class="mainText">

                                                    <small style="font-weight: bold;">
                                                        @if ($getthisuser->shareholders_document != null)
                                                            <a href="{{ $getthisuser->shareholders_document }}"
                                                                target="_blank">View</a>
                                                        @endif
                                                    </small>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Proof of Identity - 1 Director</td>
                                                <td class="mainText">

                                                    <small style="font-weight: bold;">
                                                        @if ($getthisuser->proof_of_identity_1 != null)
                                                            <a href="{{ $getthisuser->proof_of_identity_1 }}"
                                                                target="_blank">View</a>
                                                        @endif
                                                    </small>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Proof of Identity - 1 UBO</td>
                                                <td class="mainText">

                                                    <small style="font-weight: bold;">
                                                        @if ($getthisuser->proof_of_identity_2 != null)
                                                            <a href="{{ $getthisuser->proof_of_identity_2 }}"
                                                                target="_blank">View</a>
                                                        @endif
                                                    </small>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>AML Policy and Procedures</td>
                                                <td class="mainText">

                                                    <small style="font-weight: bold;">
                                                        @if ($getthisuser->aml_policy != null)
                                                            <a href="{{ $getthisuser->aml_policy }}"
                                                                target="_blank">View</a>
                                                        @endif
                                                    </small>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Latest Compliance External Audit Report</td>
                                                <td class="mainText">

                                                    <small style="font-weight: bold;">
                                                        @if ($getthisuser->compliance_audit_report != null)
                                                            <a href="{{ $getthisuser->compliance_audit_report }}"
                                                                target="_blank">View</a>
                                                        @endif
                                                    </small>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Organizational Chart (including details of Compliance roles and
                                                    functions)</td>
                                                <td class="mainText">

                                                    <small style="font-weight: bold;">
                                                        @if ($getthisuser->organizational_chart != null)
                                                            <a href="{{ $getthisuser->organizational_chart }}"
                                                                target="_blank">View</a>
                                                        @endif
                                                    </small>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Proof of Financial License</td>
                                                <td class="mainText">

                                                    <small style="font-weight: bold;">
                                                        @if ($getthisuser->financial_license != null)
                                                            <a href="{{ $getthisuser->financial_license }}"
                                                                target="_blank">View</a>
                                                        @endif
                                                    </small>

                                                </td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <td>Govt. Photo ID</td>
                                            <td class="mainText">

                                                <small style="font-weight: bold;">
                                                    @if ($getthisuser->nin_front != null)
                                                        <a href="{{ $getthisuser->nin_front }}" target="_blank">Front
                                                            view</a>
                                                        @endif - @if ($getthisuser->nin_back != null)
                                                            <a href="{{ $getthisuser->nin_back }}" target="_blank">Back
                                                                view</a>
                                                        @endif
                                                </small>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Driver Licence</td>
                                            <td class="mainText">

                                                <small style="font-weight: bold;">
                                                    @if ($getthisuser->drivers_license_front != null)
                                                        <a href="{{ $getthisuser->drivers_license_front }}"
                                                            target="_blank">Front view</a>
                                                        @endif - @if ($getthisuser->drivers_license_back != null)
                                                            <a href="{{ $getthisuser->drivers_license_back }}"
                                                                target="_blank">Back view</a>
                                                        @endif
                                                </small>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>International Passport</td>
                                            <td class="mainText">

                                                <small style="font-weight: bold;">
                                                    @if ($getthisuser->international_passport_front != null)
                                                        <a href="{{ $getthisuser->international_passport_front }}"
                                                            target="_blank">Front view</a>
                                                        @endif - @if ($getthisuser->international_passport_back != null)
                                                            <a href="{{ $getthisuser->international_passport_back }}"
                                                                target="_blank">Back view</a>
                                                        @endif
                                                </small>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Identity Verification Document</td>
                                            <td class="mainText">

                                                <small style="font-weight: bold;">
                                                    @if ($getthisuser->idvdoc != null)
                                                        <a href="{{ $getthisuser->idvdoc }}" target="_blank">View
                                                            Document</a>
                                                    @endif
                                                </small>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <h3 style="font-weight: bold;">COMPLIANCE INFORMATION</h3>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>How do you know about us?</td>
                                            <td class="mainText">

                                                <small style="font-weight: bold;">
                                                    @if ($getthisuser->knowAboutUs != null)
                                                        {{ $getthisuser->knowAboutUs }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </small>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Purpose of opening the Account</td>
                                            <td class="mainText">

                                                <small style="font-weight: bold;">
                                                    @if ($getthisuser->accountPurpose != null)
                                                        {{ $getthisuser->accountPurpose }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </small>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Size of Transaction to be expected</td>
                                            <td class="mainText">

                                                <small style="font-weight: bold;">
                                                    @if ($getthisuser->transactionSize != null)
                                                        {{ $getthisuser->transactionSize }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </small>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Source of Funds</td>
                                            <td class="mainText">

                                                <small style="font-weight: bold;">
                                                    @if ($getthisuser->transactionSize != null)
                                                        {{ $getthisuser->transactionSize }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </small>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Wallet Balance</td>
                                            <td class="mainText" style="font-weight: 900; color: green;">

                                                {{ $getthisuser->currencyCode . ' ' . number_format($getthisuser->wallet_balance, 2) }}

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Transaction Limit</td>
                                            <td class="mainText" style="font-weight: 900; color: navy;">

                                                {{ $getthisuser->currencyCode . ' ' . number_format($getthisuser->withdrawal_per_transaction, 2) }}

                                            </td>
                                        </tr>


                                        <tr>
                                            <td class="mainText" colspan="2">

                                                <button class="btn btn-primary"
                                                    onclick="increaseLimit({{ $getthisuser->id }}, {{ $getthisuser->withdrawal_per_transaction }})">Increase
                                                    Transaction Limit</button>

                                            </td>
                                        </tr>





                                        <tr class="disp-0">
                                            <td colspan="2">

                                                @if ($getthisuser->accountLevel >= 2)
                                                    <a type="button" class="btn btn-danger"
                                                        onclick="checkverification('{{ $getthisuser->id }}')"><i
                                                            class="fas fa-power-off text-danger" style="font-size: 20px;"
                                                            title="Level 1 Disapproval"></i> Level 1 Disapproval <img
                                                            class="spinvery{{ $getthisuser->id }} disp-0"
                                                            src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif"
                                                            style="width: 20px; height: 20px;"></a>
                                                @else
                                                    <a type="button" class="btn btn-primary"
                                                        onclick="checkverification('{{ $getthisuser->id }}')"><i
                                                            class="far fa-lightbulb" style="font-size: 20px;"
                                                            title="Level 1 Override"></i> Level 1 Override <img
                                                            class="spinvery{{ $getthisuser->id }} disp-0"
                                                            src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif"
                                                            style="width: 20px; height: 20px;"></a>
                                                @endif

                                            </td>
                                        </tr>
                                        <br><br>


                                        {{-- Put Modal --}}

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary disp-0" data-toggle="modal"
                                            data-target="#increaseLimitModal" id="limit{{ $getthisuser->id }}">
                                            Launch demo modal
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="increaseLimitModal" tabindex="-1" role="dialog"
                                            aria-labelledby="increaseLimitModalTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Increase
                                                            {{ $getthisuser->name }} transaction limit</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <form action="{{ route('increase trans limit') }}" method="post">
                                                        @csrf

                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="Set Transaction Limit">Set Transaction
                                                                    Limit</label><br>
                                                                <input type="number" class="form-control"
                                                                    name="withdrawal_per_transaction"
                                                                    id="withdrawal_per_transaction" placeholder="New Limit">
                                                                <input type="hidden" name="id"
                                                                    value="{{ $getthisuser->id }}">
                                                            </div>

                                                            <p id="currLimit"></p>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Submit and
                                                                Save</button>
                                                        </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>


                                        {{-- End Modal --}}
                                    @else
                                        <tr>
                                            <td>No record found</td>
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
