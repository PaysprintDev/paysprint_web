@extends('layouts.dashboard')

@section('dashContent')
    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\AddCard; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                View Document
            </h1>
            <ol class="breadcrumb">
                <li><a href={{ " route('Admin') " }}><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"> View Document</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <br>
            <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go
                back</button>
            <br>

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">

                        <div class="box-body">
                            <div class="box-body">
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

                                    </thead>
                                    <tbody>
                                        {{-- {{ dd($data) }} --}}

                                        {{-- @if ($data['users'] !== null) --}}
                                        <tr>
                                            <th>Date</th>
                                            <th>Description</th>
                                        </tr>

                                        <tr>
                                            <td><strong> NIN Front</strong></td>
                                            <td align="center"> <a @if (isset($data['users']->nin_front)) type="button" @endif
                                                    href="{{ isset($data['users']->nin_front) ? $data['users']->nin_front : route('send message', 'id=' . $data['users']->id . '&route=') }}"
                                                    @if (isset($data['users']->nin_front)) class="btn btn-primary btn-block" @endif>{{ isset($data['users']->nin_front) ? 'View File' : 'Message to complete' }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Drivers License Front</strong></td>
                                            <td align="center"> <a @if (isset($data['users']->drivers_license_front)) type="button" @endif
                                                    href="{{ isset($data['users']->drivers_license_front) ? $data['users']->drivers_license_front : route('send message', 'id=' . $data['users']->id . '&route=') }}"
                                                    @if (isset($data['users']->drivers_license_front)) class="btn btn-primary btn-block" @endif>{{ isset($data['users']->drivers_license_front) ? 'View File' : 'Message to complete' }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>International Passport Front</strong></td>

                                            <td align="center"> <a @if (isset($data['users']->international_passport_front)) type="button" @endif
                                                    href="{{ isset($data['users']->international_passport_front) ? $data['users']->international_passport_front : route('send message', 'id=' . $data['users']->id . '&route=') }}"
                                                    @if (isset($data['users']->international_passport_front)) class="btn btn-primary btn-block" @endif>{{ isset($data['users']->international_passport_front) ? 'View File' : 'Message to complete' }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>NIN Back</strong></td>
                                            <td align="center"> <a @if (isset($data['users']->nin_back)) type="button" @endif
                                                    href="{{ isset($data['users']->nin_back) ? $data['users']->nin_back : route('send message', 'id=' . $data['users']->id . '&route=') }}"
                                                    @if (isset($data['users']->nin_back)) class="btn btn-primary btn-block" @endif>{{ isset($data['users']->nin_back) ? 'View File' : 'Message to complete' }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Drivers License Back</strong></td>

                                            <td align="center"> <a @if (isset($data['users']->drivers_license_back)) type="button" @endif
                                                    href="{{ isset($data['users']->drivers_license_back) ? $data['users']->drivers_license_back : route('send message', 'id=' . $data['users']->id . '&route=') }}"
                                                    @if (isset($data['users']->drivers_license_back)) class="btn btn-primary btn-block" @endif>{{ isset($data['users']->drivers_license_back) ? 'View File' : 'Message to complete' }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>International Passport Back</strong></td>

                                            <td align="center"> <a @if (isset($data['users']->international_passport_back)) type="button" @endif
                                                    href="{{ isset($data['users']->international_passport_back) ? $data['users']->international_passport_back : route('send message', 'id=' . $data['users']->id . '&route=') }}"
                                                    @if (isset($data['users']->international_passport_back)) class="btn btn-primary btn-block" @endif>{{ isset($data['users']->international_passport_back) ? 'View File' : 'Message to complete' }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Incorporation Document Front</strong></td>

                                            <td align="center"> <a @if (isset($data['users']->incorporation_doc_front)) type="button" @endif
                                                    href="{{ isset($data['users']->incorporation_doc_front) ? $data['users']->incorporation_doc_front : route('send message', 'id=' . $data['users']->id . '&route=') }}"
                                                    @if (isset($data['users']->incorporation_doc_front)) class="btn btn-primary btn-block" @endif>{{ isset($data['users']->incorporation_doc_front) ? 'View File' : 'Message to complete' }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Incorporation Document Back</strong></td>

                                            <td align="center"> <a @if (isset($data['users']->incorporation_doc_back)) type="button" @endif
                                                    href="{{ isset($data['users']->incorporation_doc_back) ? $data['users']->incorporation_doc_back : route('send message', 'id=' . $data['users']->id . '&route=') }}"
                                                    @if (isset($data['users']->incorporation_doc_back)) class="btn btn-primary btn-block" @endif>{{ isset($data['users']->incorporation_doc_back) ? 'View File' : 'Message to complete' }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Directors Document</strong></td>
                                            <td align="center"> <a @if (isset($data['users']->directors_document)) type="button" @endif
                                                    href="{{ isset($data['users']->directors_document) ? $data['users']->directors_document : route('send message', 'id=' . $data['users']->id . '&route=') }}"
                                                    @if (isset($data['users']->directors_document)) class="btn btn-primary btn-block" @endif>{{ isset($data['users']->directors_document) ? 'View File' : 'Message to complete' }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Shareholders Document</strong></td>

                                            <td align="center"> <a @if (isset($data['users']->shareholders_document)) type="button" @endif
                                                    href="{{ isset($data['users']->shareholders_document) ? $data['users']->shareholders_document : route('send message', 'id=' . $data['users']->id . '&route=') }}"
                                                    @if (isset($data['users']->shareholders_document)) class="btn btn-primary btn-block" @endif>{{ isset($data['users']->shareholders_document) ? 'View File' : 'Message to complete' }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Proof Of Identity 1</strong></td>

                                            <td align="center"> <a @if (isset($data['users']->proof_of_identity_1)) type="button" @endif
                                                    href="{{ isset($data['users']->proof_of_identity_1) ? $data['users']->proof_of_identity_1 : route('send message', 'id=' . $data['users']->id . '&route=') }}"
                                                    @if (isset($data['users']->proof_of_identity_1)) class="btn btn-primary btn-block" @endif>{{ isset($data['users']->proof_of_identity_1) ? 'View File' : 'Message to complete' }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Proof Of Identity 2</strong></td>

                                            <td align="center"> <a @if (isset($data['users']->proof_of_identity_2)) type="button" @endif
                                                    href="{{ isset($data['users']->proof_of_identity_2) ? $data['users']->proof_of_identity_2 : route('send message', 'id=' . $data['users']->id . '&route=') }}"
                                                    @if (isset($data['users']->proof_of_identity_2)) class="btn btn-primary btn-block" @endif>{{ isset($data['users']->proof_of_identity_2) ? 'View File' : 'Message to complete' }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Aml Policy</strong></td>

                                            <td align="center"> <a @if (isset($data['users']->aml_policy)) type="button" @endif
                                                    href="{{ isset($data['users']->aml_policy) ? $data['users']->aml_policy : route('send message', 'id=' . $data['users']->id . '&route=') }}"
                                                    @if (isset($data['users']->aml_policy)) class="btn btn-primary btn-block" @endif>{{ isset($data['users']->aml_policy) ? 'View File' : 'Message to complete' }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Compliance Audit Report</strong></td>

                                            <td align="center"> <a @if (isset($data['users']->compliance_audit_report)) type="button" @endif
                                                    href="{{ isset($data['users']->compliance_audit_report) ? $data['users']->compliance_audit_report : route('send message', 'id=' . $data['users']->id . '&route=') }}"
                                                    @if (isset($data['users']->compliance_audit_report)) class="btn btn-primary btn-block" @endif>{{ isset($data['users']->compliance_audit_report) ? 'View File' : 'Message to complete' }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Organizational Chart</strong></td>

                                            <td align="center"> <a @if (isset($data['users']->organizational_chart)) type="button" @endif
                                                    href="{{ isset($data['users']->organizational_chart) ? $data['users']->organizational_chart : route('send message', 'id=' . $data['users']->id . '&route=') }}"
                                                    @if (isset($data['users']->organizational_chart)) class="btn btn-primary btn-block" @endif>{{ isset($data['users']->organizational_chart) ? 'View File' : 'Message to complete' }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Financial License</strong></td>

                                            <td align="center"> <a @if (isset($data['users']->financial_license)) type="button" @endif
                                                    href="{{ isset($data['users']->financial_license) ? $data['users']->financial_license : route('send message', 'id=' . $data['users']->id . '&route=') }}"
                                                    @if (isset($data['users']->financial_license)) class="btn btn-primary btn-block" @endif>{{ isset($data['users']->financial_license) ? 'View File' : 'Message to complete' }}</a>
                                            </td>
                                        </tr>

                                        {{-- @else

                  <tr>
                    <td colspan="3" align="center">No linked account</td>
                  </tr>

                  @endif --}}


                                    </tbody>
                                </table>

                            </div>

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
