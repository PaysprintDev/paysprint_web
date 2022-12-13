@extends('layouts.dashboard')

@section('dashContent')


<?php use App\Http\Controllers\User; ?>
<?php use App\Http\Controllers\Admin; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @if (Request::get('country') != null)
            Merchant's In {{ Request::get('country') }}

            @else
            Merchant's
            @endif
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">
                @if (Request::get('country') != null)
                Merchant's In {{ Request::get('country') }}

                @else
                Merchant's
                @endif
            </li>
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
                                    <th>Account No.</th>
                                    <th>Name</th>
                                    <th>Business</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Telephone</th>
                                    <th>Address</th>
                                    <th>Business Doc.</th>
                                    <th>Payout Agent</th>
                                    <th>Activate Payment Link</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>



                                @if (count($allusers) > 0)
                                <?php $i = 1; ?>
                                @foreach ($allusers as $datainfo)
                                @if (isset($datainfo['users']))
                                <tr>
                                    <td>{{ $i++ }}</td>

                                    <td style="color: green; font-weight: bold;">
                                        {{ $datainfo['users']->ref_code }}
                                    </td>
                                    <td>{{ $datainfo['users']->name }}</td>
                                    <td>{{ $datainfo['users']->businessname }}</td>
                                    @if ($user = \App\Admin::where('email', $datainfo['users']->email)->first())
                                    <td style="color: navy; font-weight: bold;">{{ $user->username }}
                                    </td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    <td>{{ $datainfo['users']->email }}</td>
                                    <td>{{ $datainfo['users']->telephone }}</td>
                                    <td>{{ $datainfo['users']->address }}</td>

                                    <td>



                                        @if ($datainfo['users']->incorporation_doc_front != null ||
                                        $datainfo['users']->incorporation_doc_back != null)
                                        <small style="font-weight: bold;">
                                            Incorporation Document: @if ($datainfo['users']->incorporation_doc_front !=
                                            null)
                                            <a href="{{ $datainfo['users']->incorporation_doc_front }}"
                                                target="_blank">Front view</a>
                                            @endif | @if ($datainfo['users']->incorporation_doc_back != null)
                                            <a href="{{ $datainfo['users']->incorporation_doc_back }}"
                                                target="_blank">Back view</a>
                                            @endif
                                        </small>
                                        <input type="checkbox" name="incorporationcheck"
                                            id="incorporationcheck{{ $datainfo['users']->id }}"
                                            onchange="checkMyBox('incorporationcheck', '{{ $datainfo['users']->id }}')"
                                            {{-- @if ($datainfo['users']->business_doc_check == 'incorporationcheck')
                                        checked
                                        @endif --}}
                                        {{ $datainfo['users']->business_doc_check == 'incorporationcheck' ? 'checked' :
                                        '' }}>

                                        {{-- <input type="checkbox" name="nincheck" id="nincheck{{ $datainfo->id }}"
                                            onchange="checkMyBox('nincheck', '{{ $datainfo->id }}')" {{
                                            $datainfo->gov_check == 1 ? 'checked' : '' }}> --}}
                                        <hr>
                                        @endif

                                        @if ($datainfo['users']->directors_document != null)
                                        <small style="font-weight: bold;">
                                            Director's Document: @if ($datainfo['users']->directors_document != null)
                                            <a href="{{ $datainfo['users']->directors_document }}"
                                                target="_blank">View</a>
                                            @endif
                                        </small>

                                        <input type="checkbox" name="directorcheck"
                                            id="directorcheck{{ $datainfo['users']->id }}"
                                            onchange="checkMyBox('directorcheck', '{{ $datainfo['users']->id }}')" {{--
                                            @if ($datainfo['users']->business_doc_check == 'directorcheck') checked
                                        @endif --}}
                                        {{ $datainfo['users']->business_doc_check == 'directorcheck' ? 'checked' :
                                        '' }}>
                                        >

                                        <hr>
                                        @endif


                                        @if ($datainfo['users']->shareholders_document != null)
                                        <small style="font-weight: bold;">
                                            Shareholder's Document: @if ($datainfo['users']->shareholders_document !=
                                            null)
                                            <a href="{{ $datainfo['users']->shareholders_document }}"
                                                target="_blank">View</a>
                                            @endif
                                        </small>

                                        <input type="checkbox" name="shareholdercheck"
                                            id="shareholdercheck{{ $datainfo['users']->id }}"
                                            onchange="checkMyBox('shareholdercheck', '{{ $datainfo['users']->id }}')"
                                            @if ($datainfo['users']->business_doc_check == 'shareholdercheck') checked
                                        @endif>

                                        <hr>
                                        @endif
                                        @if ($datainfo['users']->proof_of_identity_1 != null)
                                        <small style="font-weight: bold;">
                                            Proof of identity 1: @if ($datainfo['users']->proof_of_identity_1 != null)
                                            <a href="{{ $datainfo['users']->proof_of_identity_1 }}"
                                                target="_blank">View</a>
                                            @endif
                                        </small>

                                        <input type="checkbox" name="proofcheck"
                                            id="proofcheck{{ $datainfo['users']->id }}"
                                            onchange="checkMyBox('proofcheck', '{{ $datainfo['users']->id }}')" {{-- @if
                                            ($datainfo['users']->business_doc_check == 'proofcheck') checked @endif --}}

                                        {{ $datainfo['users']->business_doc_check == 'proofcheck' ? 'checked' :
                                        '' }}>



                                        <hr>
                                        @endif
                                        @if ($datainfo['users']->proof_of_identity_2 != null)
                                        <small style="font-weight: bold;">
                                            Proof of identity 2: @if ($datainfo['users']->proof_of_identity_2 != null)
                                            <a href="{{ $datainfo['users']->proof_of_identity_2 }}"
                                                target="_blank">View</a>
                                            @endif
                                        </small>

                                        <input type="checkbox" name="proof2check"
                                            id="proof2check{{ $datainfo['users']->id }}"
                                            onchange="checkMyBox('proof2check', '{{ $datainfo['users']->id }}')" {{--
                                            @if ($datainfo['users']->business_doc_check == 'proof2check') checked @endif
                                        --}}

                                        {{ $datainfo['users']->business_doc_check == 'proof2check' ? 'checked' :
                                        '' }}>



                                        <hr>
                                        @endif
                                        @if ($datainfo['users']->aml_policy != null)
                                        <small style="font-weight: bold;">
                                            AML policy: @if ($datainfo['users']->aml_policy != null)
                                            <a href="{{ $datainfo['users']->aml_policy }}" target="_blank">View</a>
                                            @endif
                                        </small>

                                        <input type="checkbox" name="amlcheck" id="amlcheck{{ $datainfo['users']->id }}"
                                            onchange="checkMyBox('amlcheck', '{{ $datainfo['users']->id }}')" {{-- @if
                                            ($datainfo['users']->business_doc_check == 'amlcheck') checked @endif --}}
                                        {{ $datainfo['users']->business_doc_check == 'amlcheck' ? 'checked' :
                                        '' }}
                                        >

                                        <hr>
                                        @endif
                                        @if ($datainfo['users']->compliance_audit_report != null)
                                        <small style="font-weight: bold;">
                                            Audit Report: @if ($datainfo['users']->compliance_audit_report != null)
                                            <a href="{{ $datainfo['users']->compliance_audit_report }}"
                                                target="_blank">View</a>
                                            @endif
                                        </small>

                                        <input type="checkbox" name="auditcheck"
                                            id="auditcheck{{ $datainfo['users']->id }}"
                                            onchange="checkMyBox('auditcheck', '{{ $datainfo['users']->id }}')" {{-- @if
                                            ($datainfo['users']->business_doc_check == 'auditcheck') checked @endif --}}

                                        {{ $datainfo['users']->business_doc_check == 'auditcheck' ? 'checked' :
                                        '' }}
                                        >

                                        <hr>
                                        @endif
                                        @if ($datainfo['users']->organizational_chart != null)
                                        <small style="font-weight: bold;">
                                            Organization Chart: @if ($datainfo['users']->organizational_chart != null)
                                            <a href="{{ $datainfo['users']->organizational_chart }}"
                                                target="_blank">View</a>
                                            @endif
                                        </small>

                                        <input type="checkbox" name="orgchartcheck"
                                            id="orgchartcheck{{ $datainfo['users']->id }}"
                                            onchange="checkMyBox('orgchartcheck', '{{ $datainfo['users']->id }}')" {{--
                                            @if ($datainfo['users']->business_doc_check == 'orgchartcheck') checked
                                        @endif --}}
                                        {{ $datainfo['users']->business_doc_check == 'orgchartcheck' ? 'checked' :
                                        '' }}
                                        >

                                        <hr>
                                        @endif
                                        @if ($datainfo['users']->financial_license != null)
                                        <small style="font-weight: bold;">
                                            Finance Licence: @if ($datainfo['users']->financial_license != null)
                                            <a href="{{ $datainfo['users']->financial_license }}"
                                                target="_blank">View</a>
                                            @endif
                                        </small>

                                        <input type="checkbox" name="financecheck"
                                            id="financecheck{{ $datainfo['users']->id }}"
                                            onchange="checkMyBox('financecheck', '{{ $datainfo['users']->id }}')" {{--
                                            @if ($datainfo['users']->business_doc_check == 'financecheck') checked
                                        @endif --}}

                                        {{ $datainfo['users']->business_doc_check == 'financecheck' ? 'checked' :
                                        '' }}
                                        >

                                        <hr>
                                        @endif


                                        @if ($datainfo['users']->incorporation_doc_front == null &&
                                        $datainfo['users']->directors_document == null &&
                                        $datainfo['users']->shareholders_document == null &&
                                        $datainfo['users']->proof_of_identity_1 == null &&
                                        $datainfo['users']->proof_of_identity_2 == null &&
                                        $datainfo['users']->aml_policy == null &&
                                        $datainfo['users']->compliance_audit_report == null &&
                                        $datainfo['users']->organizational_chart == null &&
                                        $datainfo['users']->financial_license == null)
                                        <small style="font-weight: bold;">
                                            No business document
                                        </small>

                                        <input type="checkbox" name="nobusinessdocument"
                                            id="nobusinessdocument{{ $datainfo['users']->id }}"
                                            onchange="checkMyBox('nobusinessdocument', '{{ $datainfo['users']->id }}')">

                                        <hr>
                                        @endif



                                    </td>

                                    <td>

                                        @if ($datainfo['users']->payout_agent == 0)
                                        <button class="btn btn-success" id="btn{{ $datainfo['users']->ref_code }}"
                                            onclick="becomeAnAgent('{{ $datainfo['users']->ref_code }}')">Activate
                                            as Payout Agent</button>

                                        @else

                                        <button class="btn btn-danger" id="btn{{ $datainfo['users']->ref_code }}"
                                            onclick="becomeAnAgent('{{ $datainfo['users']->ref_code }}')">Deactivate
                                            as Payout Agent</button>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($datainfo['users']->payment_link_approval == 0)
                                        <button class="btn btn-success" id="btns{{ $datainfo['users']->ref_code }}"
                                            onclick="activatePaymentLink('{{ $datainfo['users']->ref_code }}')">Activate
                                            Merchant Payment Link</button>

                                        @else

                                        <button class="btn btn-danger" id="btns{{ $datainfo['users']->ref_code }}"
                                            onclick="activatePaymentLink('{{ $datainfo['users']->ref_code }}')">Deactivate
                                            Merchant Payment Link</button>
                                        @endif
                                    </td>


                                    @if ($datainfo['users']->approval == 2 && $datainfo['users']->accountLevel > 0 &&
                                    $datainfo['users']->account_check == 2)
                                    <td style="color: green; font-weight: bold;" align="center">Approved
                                    </td>

                                    @elseif ($datainfo['users']->approval == 2 && $datainfo['users']->accountLevel > 0
                                    && $datainfo['users']->account_check == 1)

                                    <td style="color: darkorange; font-weight: bold;" align="center">
                                        Awaiting Approval</td>

                                    @elseif ($datainfo['users']->approval == 1 && $datainfo['users']->accountLevel > 0)

                                    <td style="color: darkorange; font-weight: bold;" align="center">
                                        Awaiting Approval</td>

                                    @elseif ($datainfo['users']->approval == 0 && $datainfo['users']->accountLevel > 0
                                    && $datainfo['users']->account_check < 2) <td
                                        style="color: navy; font-weight: bold;" align="center">Override
                                        Level 1</td>

                                        @else
                                        <td style="color: red; font-weight: bold;" align="center">
                                            Not Approved</td>
                                        @endif

                                        <td align="center">

                                            @if ($datainfo['users']->approval == 2 && $datainfo['users']->accountLevel >
                                            0 && $datainfo['users']->account_check == 2)
                                            @if (Request::get('mode') == 'test')
                                            <button class="btn btn-success" id="btn{{ $datainfo['users']->ref_code }}"
                                                onclick="activateLive('live', '{{ $datainfo['users']->ref_code }}')">Activate
                                                Live</button>

                                            @else

                                            <button class="btn btn-danger" id="btn{{ $datainfo['users']->ref_code }}"
                                                onclick="activateLive('test', '{{ $datainfo['users']->ref_code }}')">Move
                                                to
                                                Test</button>
                                            @endif


                                            @elseif ($datainfo['users']->approval == 2 &&
                                            $datainfo['users']->accountLevel > 0 && $datainfo['users']->account_check ==
                                            1)
                                            @if (Request::get('mode') == 'test')
                                            <button class="btn btn-success" id="btn{{ $datainfo['users']->ref_code }}"
                                                onclick="activateLive('live', '{{ $datainfo['users']->ref_code }}')">Activate
                                                Live</button>

                                            @else

                                            <button class="btn btn-danger" id="btn{{ $datainfo['users']->ref_code }}"
                                                onclick="activateLive('test', '{{ $datainfo['users']->ref_code }}')">Move
                                                to
                                                Test</button>
                                            @endif



                                            @else

                                            <button class="btn btn-danger" disabled>
                                                @if (Request::get('mode') == 'test')
                                                Activate Live
                                                @else
                                                Activate Test
                                                @endif
                                            </button>
                                            @endif

                                        </td>


                                </tr>
                                @endif
                                @endforeach



                                @else
                                <tr>
                                    <td colspan="11" align="center">No record available</td>
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