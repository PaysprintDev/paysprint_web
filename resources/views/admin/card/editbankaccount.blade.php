@extends('layouts.dashboard')


@section('dashContent')

<?php use \App\Http\Controllers\ClientInfo; ?>
<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\InvoicePayment; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bank Account
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Bank Account</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="col-md-2 col-md-offset-10">
                <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
            </div>

      <div class="row">
                      <div class="box-body">

                          @if (isset($data['getthisBank']))

                    <div class="form-group cardform"> 
                            <form action="#" method="POST" id="formElem">
                                @csrf


                                <div class="form-group">
                                    <label for="bankName">Bank Name</label>

                                    <input type="hidden" name="id" value="{{ $data['getthisBank']->id }}">

                                    @if($userInfo = \App\User::where('ref_code', session('user_id'))->first())

                                        @if($userInfo->country == "Canada")

                                            <select name="bankName" id="bankName" class="form-control" required>
                                                    <option data-tokens="{{ $data['getthisBank']->bankName }}" value="{{ $data['getthisBank']->bankName }}"> {{ $data['getthisBank']->bankName }}</option>
                                                    <option data-tokens="RBC ROYAL BANK" value="RBC ROYAL BANK"> RBC ROYAL BANK</option>
                                                    <option data-tokens="TD CANADA TRUST" value="TD CANADA TRUST">TD CANADA TRUST</option>
                                                    <option data-tokens="SCOTIABANK" value="SCOTIABANK">SCOTIABANK</option>
                                                    <option data-tokens="DESJARDINS" value="DESJARDINS">DESJARDINS</option>
                                                    <option data-tokens="NATIONAL BANK OF CANADA" value="NATIONAL BANK OF CANADA">NATIONAL BANK OF CANADA</option>
                                                    <option data-tokens="TANGERINE" value="TANGERINE">TANGERINE</option>
                                                    <option data-tokens="SIMPLII FINANCIAL" value="SIMPLII FINANCIAL">SIMPLII FINANCIAL</option>
                                                    <option data-tokens="ENVISION FINANCIAL, A DIVISION OF FIRST WEST CU" value="ENVISION FINANCIAL, A DIVISION OF FIRST WEST CU">ENVISION FINANCIAL, A DIVISION OF FIRST WEST CU</option>
                                                    <option data-tokens="VANCITY" value="VANCITY">VANCITY</option>
                                                    <option data-tokens="PROSPERA CREDIT UNION" value="PROSPERA CREDIT UNION">PROSPERA CREDIT UNION</option>
                                                    <option data-tokens="DUCA" value="DUCA">DUCA</option>
                                                    <option data-tokens="TD CANADA TRUST" value="TD CANADA TRUST">TD CANADA TRUST</option>
                                                </select>
                                        @else

                                        <input type="text" name="bankName" id="bankName" class="form-control" value="{{ $data['getthisBank']->bankName }}" required>
                                        @endif


                                    @endif

                                </div>






                                <div class="form-group">
                                    <label for="transitNumber">Transit Number</label>

                                    <input type="text" name="transitNumber" id="transitNumber" value="{{ $data['getthisBank']->transitNumber }}" class="form-control" required>
                                    

                                </div>



                                <div class="form-group">
                                    <label for="branchCode">Branch Code</label>

                                <input type="text" name="branchCode" id="branchCode" value="{{ $data['getthisBank']->branchCode }}" class="form-control" required>
                                    

                                </div>
                                <div class="form-group">
                                    <label for="accountName">Account Name</label>

                                <input type="text" name="accountName" id="accountName" value="{{ $data['getthisBank']->accountName }}" class="form-control" required>
                                    

                                </div>
                                <div class="form-group">
                                    <label for="accountNumber">Account Number</label>

                                <input type="text" name="accountNumber" id="accountNumber" value="{{ $data['getthisBank']->accountNumber }}" class="form-control" required>
                                    

                                </div>



                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-block" onclick="handShake('editbank')" id="cardSubmit">Submit</button>
                                </div>

                            </form>
                        </div>

                        @endif
                </div>
    </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @endsection