@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\BankWithdrawal; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Moex Transaction Details
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Moex Transaction Details</li>
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
                <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
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
                  <th>Name</th>
                  <th>Email</th>
                  <th>Country</th>
                  <th>Status</th>
                  <th>Message</th>
                  <th>Date created</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($data['moextranx']) > 0)
                    <?php $i = 1;?>
                        @foreach ($data['moextranx'] as $data)
                        <tr>
                            <td>{{ $i++ }}</td>

                            @if($user = \App\User::where('id', $data->user_id)->first())

                              @php
                                  $currencyCode = $user->currencyCode;
                                  $currencySymbol = $user->currencySymbol;
                                  $name = $user->name;
                                  $email = $user->email;
                                  $country = $user->country;
                              @endphp

                              @else

                                @php
                                  $currencyCode = "-";
                                  $currencySymbol = "-";
                                  $name = "-";
                                  $email = "-";
                                  $country = "-";
                              @endphp

                            @endif

                            <td>{{ $name }}</td>
                            <td>{{ $email }}</td>
                            <td>{{ $country }}</td>
                            <td>{{ $data->status }}</td>
                            <td>{{ $data->transactionMessage }}</td>
                            <td>{{ date('d/m/Y', strtotime($data->created_at)) }}</td>
                            <td>
                                <button type="button" data-toggle="modal" data-target="#exampleModal{{ $data->id }}" class="btn btn-primary btn-block">View details</button>
                            </td>

                        </tr>


                        {{-- Modal Open --}}

                        <!-- Button trigger modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{ $data->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel{{ $data->id }}">Transaction Details for {{ $name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @php
            $trnx = json_decode($data->transaction, true);
        @endphp

        <div class="row">
            <div class="mb-2">
                <div class="col-md-6">Transaction ID</div>
                <div class="col-md-6" style="font-weight: bold;">{{ $trnx['transactionId'] }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Transaction Date</div>
                <div class="col-md-6" style="font-weight: bold;">{{ $trnx['transactionDate'] }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Sender Id</div>
                <div class="col-md-6" style="font-weight: bold;">{{ $trnx['senderId'] }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Sender</div>
                <div class="col-md-6" style="font-weight: bold;">{{ $trnx['sender'] }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Sender Name</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['senderName']) ? $trnx['senderName'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Sender Last Name</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['senderLastName']) ? $trnx['senderLastName'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Sender Address</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['senderAddress']) ? $trnx['senderAddress'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Sender City</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['senderCity']) ? $trnx['senderCity'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Sender Country</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['senderCountry']) ? $trnx['senderCountry'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Sender Document Number</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['senderIdDocumentNumber']) ? $trnx['senderIdDocumentNumber'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Sender Document Type</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['senderIdDocumentType']) ? $trnx['senderIdDocumentType'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Receiver Id</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['receiverId']) ? $trnx['receiverId'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Receiver</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['receiver']) ? $trnx['receiver'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Receiver Address</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['receiverAddress']) ? $trnx['receiverAddress'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Receiver City</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['receiverCity']) ? $trnx['receiverCity'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Receiver Country</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['receiverCountry']) ? $trnx['receiverCountry'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Bank Deposit</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['bankDeposit']) ? $trnx['bankDeposit'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Bank Name</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['bankName']) ? $trnx['bankName'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Bank Address</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['bankAddress']) ? $trnx['bankAddress'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Bank Account</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['bankAccount']) ? $trnx['bankAccount'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Amount To Pay</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['amountToPay']) ? $trnx['amountToPay'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Currency To Pay</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['currencyToPay']) ? $trnx['currencyToPay'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Amount Sent</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['amountSent']) ? $trnx['amountSent'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Currency Sent</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['currencySent']) ? $trnx['currencySent'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Sender Message</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['senderMessage']) ? $trnx['senderMessage'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Payment Branch Id</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['paymentBranchId']) ? $trnx['paymentBranchId'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Payment Branch Name</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['paymentBranchName']) ? $trnx['paymentBranchName'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Payment Branch Address</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['paymentBranchAddress']) ? $trnx['paymentBranchAddress'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Payment Branch Phone</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['paymentBranchPhone']) ? $trnx['paymentBranchPhone'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Payment Branch Aux Id</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['paymentBranchAuxId']) ? $trnx['paymentBranchAuxId'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-6">Origin Country</div>
                <div class="col-md-6" style="font-weight: bold;">{{ isset($trnx['originCountry']) ? $trnx['originCountry'] : "NULL" }}</div>
            </div>
            <br>
            <br>
            <div class="mb-2">
                <div class="col-md-12">Auxiliary Info</div>
            <br>
            <br>
                <div class="col-md-12">
                    @if (isset($trnx['auxiliaryInfo']))
                        @php
                            $info = json_decode($trnx['auxiliaryInfo'], true);

                        @endphp

                        <p>Sender Birth Date: <span style="font-weight: bold;">{{ isset($info['SenderBirthDate']) ? $info['SenderBirthDate'] : "" }}</span></p>
                        <p>Sender Birth Place: <span style="font-weight: bold;">{{ isset($info['SenderBirthPlace']) ? $info['SenderBirthPlace'] : "" }}</span></p>
                        <p>Sender Birth Country: <span style="font-weight: bold;">{{ isset($info['SenderBirthCountry']) ? $info['SenderBirthCountry'] : "" }}</span></p>
                        <p>Sender Gender: <span style="font-weight: bold;">{{ isset($info['SenderGender']) ? $info['SenderGender'] : "" }}</span></p>

                    @else

                     {{ "NULL" }}
                    @endif
                </div>
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

                        @endforeach

                    @else
                    <tr>
                        <td colspan="5" align="center">No record available</td>
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


