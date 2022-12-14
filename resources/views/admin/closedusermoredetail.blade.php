@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\ClientInfo; ?>
<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\Admin; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

      <h1>
         Closed User details
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Closed User details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Closed User details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-2 col-md-offset-10">
                <button class="btn btn-secondary btn-block bg-blue" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
            </div>

              <table class="table table-bordered table-striped">
                
                <tbody>
                  @if(isset($getthisuser))

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

                      @if ($getthisuser->country == "Nigeria")
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
                            <td style="font-weight: bold;" class="mainText {{ ($getthisuser->bvn_verification == 1) ? 'text-success' : 'text-danger' }}">{{ ($getthisuser->bvn_verification == 1) ? "Verified" : "Not verified" }}</td>
                          </tr>
                      @endif

                      <tr>
                        <td>Date Of Birth</td>
                        <td class="mainText">{{ $getthisuser->dayOfBirth.'/'.$getthisuser->monthOfBirth.'/'.$getthisuser->yearOfBirth }}</td>
                      </tr>
                      <tr>
                        <td>Type of Account</td>
                        <td class="mainText">{{ $getthisuser->accountType }}</td>
                      </tr>

                      @if ($getthisuser->accountType == "Merchant")

                      @if($merchantDetail = \App\Admin::where('email', $getthisuser->email)->first())
                        <tr>
                            <td>Username</td>
                            <td class="mainText" style="font-weight: 900; color: navy;">{{ strtoupper($merchantDetail->username) }}</td>
                        </tr>

                      @endif
                        <tr>
                            <td>Business Name</td>
                            <td class="mainText">{{ $getthisuser->businessname }}</td>
                        </tr>
                        <tr>
                            <td>Corporation Type</td>
                            <td class="mainText">{{ $getthisuser->corporationType }}</td>
                        </tr>
                        <tr>
                            <td>Incorporation Doc.</td>
                            <td class="mainText">

                                <small style="font-weight: bold;">
                                    @if($getthisuser->incorporation_doc_front != null) <a href="{{ $getthisuser->incorporation_doc_front }}" target="_blank">Front view</a> @endif - @if($getthisuser->incorporation_doc_back != null) <a href="{{ $getthisuser->incorporation_doc_back }}" target="_blank">Back view</a> @endif
                                </small>

                            </td>
                        </tr>
                      @endif

                      <tr>
                            <td>Govt. Photo ID</td>
                            <td class="mainText">

                                <small style="font-weight: bold;">
                                    @if($getthisuser->nin_front != null) <a href="{{ $getthisuser->nin_front }}" target="_blank">Front view</a> @endif - @if($getthisuser->nin_back != null) <a href="{{ $getthisuser->nin_back }}" target="_blank">Back view</a> @endif
                                </small>

                            </td>
                        </tr>
                      <tr>
                            <td>Driver Licence</td>
                            <td class="mainText">

                                <small style="font-weight: bold;">
                                    @if($getthisuser->drivers_license_front != null) <a href="{{ $getthisuser->drivers_license_front }}" target="_blank">Front view</a> @endif - @if($getthisuser->drivers_license_back != null) <a href="{{ $getthisuser->drivers_license_back }}" target="_blank">Back view</a> @endif
                                </small>

                            </td>
                        </tr>
                      <tr>
                            <td>International Passport</td>
                            <td class="mainText">

                                <small style="font-weight: bold;">
                                    @if($getthisuser->international_passport_front != null) <a href="{{ $getthisuser->international_passport_front }}" target="_blank">Front view</a> @endif - @if($getthisuser->international_passport_back != null) <a href="{{ $getthisuser->international_passport_back }}" target="_blank">Back view</a> @endif
                                </small>

                            </td>
                        </tr>
                      <tr>
                            <td>Wallet Balance</td>
                            <td class="mainText" style="font-weight: 900; color: green;">

                                {{ $getthisuser->currencyCode.' '.number_format($getthisuser->wallet_balance, 2) }}

                            </td>
                        </tr>
                      

                      <tr class="disp-0">
                        <td colspan="2">

                            @if($getthisuser->accountLevel >= 2) 
                            
                                <a type="button" class="btn btn-danger" onclick="checkverification('{{ $getthisuser->id }}')"><i class="fas fa-power-off text-danger" style="font-size: 20px;" title="Level 1 Disapproval"></i> Level 1 Disapproval <img class="spinvery{{ $getthisuser->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></a> 
                              
                            @else
                              
                                <a type="button" class="btn btn-primary" onclick="checkverification('{{ $getthisuser->id }}')"><i class="far fa-lightbulb" style="font-size: 20px;" title="Level 1 Override"></i>  Level 1 Override <img class="spinvery{{ $getthisuser->id }} disp-0" src="https://i.ya-webdesign.com/images/loading-gif-png-5.gif" style="width: 20px; height: 20px;"></a>  
                            
                            
                            @endif

                        </td>
                      </tr>
                      <br><br>

                                

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


