@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\AddCard; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View Document
      </h1>
      <ol class="breadcrumb">
      <li><a href={{" route('Admin') "}}><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> View Document</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <br>
          <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
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

                      {{-- @if($data['users'] !== NULL) --}}
                      <tr>
                        <th>Date</th>
                        <th>Description</th>
                      </tr>

                      <tr>
                        <td><strong> NIN Front</strong></td>
                        <td> <a type="button" href="{{ $data['users']->nin_front }}" class="btn btn-primary btn-block">View File</a></td>
                      </tr>
                      <tr>
                        <td><strong>Drivers License Front</strong></td>
                        <td> <a type="button" href="{{ $data['users']->drivers_license_front }}" class="btn btn-primary btn-block">View File</a></td>
                      </tr>
                      <tr>
                        <td><strong>International Passport Front</strong></td>
    
                        <td> <a type="button" href="{{ $data['users']->international_passport_front }}" class="btn btn-primary btn-block">View File</a></td>
                      </tr>
                      <tr>
                        <td><strong>NIN Back</strong></td>
                        <td> <a type="button" href="{{ $data['users']->nin_back }}" class="btn btn-primary btn-block">View File</a></td>
                      </tr>
                      <tr>
                        <td><strong>Drivers License Back</strong></td>
    
                        <td> <a type="button" href="{{ $data['users']->drivers_license_back }}" class="btn btn-primary btn-block">View File</a></td>
                      </tr>
                      <tr>
                        <td><strong>International Passport Back</strong></td>
    
                        <td> <a type="button" href="{{ $data['users']->international_passport_back }}" class="btn btn-primary btn-block">View File</a></td>
                      </tr>
                      <tr>
                        <td><strong>Incorporation Document Front</strong></td>
    
                        <td> <a type="button" href="{{ $data['users']->incorporation_doc_front }}" class="btn btn-primary btn-block">View File</a></td>
                      </tr> 
                       <tr>
                        <td><strong>Incorporation Document Back</strong></td>
    
                        <td> <a type="button" href="{{ $data['users']->incorporation_doc_back }}" class="btn btn-primary btn-block">View File</a></td>
                      </tr>
                      <tr>
                        <td><strong>Directors Document</strong></td>
    
                        <td> <a type="button" href="{{ $data['users']->directors_document }}" class="btn btn-primary btn-block">View File</a></td>
                      </tr>
                      <tr>
                        <td><strong>Shareholders Document</strong></td>
    
                        <td> <a type="button" href="{{ $data['users']->shareholders_document }}" class="btn btn-primary btn-block">View File</a></td>
                      </tr>
                      <tr>
                        <td><strong>Proof Of Identity 1</strong></td>
    
                        <td> <a type="button" href="{{ $data['users']->proof_of_identity_1 }}" class="btn btn-primary btn-block">View File</a></td>
                      </tr>
                      <tr>
                        <td><strong>Proof Of Identity 2</strong></td>
    
                        <td> <a type="button" href="{{ $data['users']->proof_of_identity_2 }}" class="btn btn-primary btn-block">View File</a></td>
                      </tr>
                      <tr>
                        <td><strong>Aml Policy</strong></td>
    
                        <td> <a type="button" href="{{ $data['users']->aml_policy }}" class="btn btn-primary btn-block">View File</a></td>
                      </tr>
                      <tr>
                        <td><strong>Compliance Audit Report</strong></td>
    
                        <td> <a type="button" href="{{ $data['users']->compliance_audit_report }}" class="btn btn-primary btn-block">View File</a></td>
                      </tr>
                      <tr>
                        <td><strong>Organizational Chart</strong></td>
    
                        <td> <a type="button" href="{{ $data['users']->organizational_chart }}" class="btn btn-primary btn-block">View File</a></td>
                      </tr>
                      <tr>
                        <td><strong>Financial License</strong></td>
    
                        <td> <a type="button" href="{{ $data['users']->financial_license }}" class="btn btn-primary btn-block">View File</a></td>
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


