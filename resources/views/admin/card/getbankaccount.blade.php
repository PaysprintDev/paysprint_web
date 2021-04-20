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

      <div class="row">

        @if (count($data['getBankDetail']) > 0)

        <div class="row" style="margin-top: 5px; margin-bottom:20px;">
            <div class="col-md-3 col-md-offset-9">
                <button class="btn btn-secondary btn-block bg-black" onclick="showForm('card')">Add Bank Account <i class="fa fa-credit-card"></i></button>
            </div>
        </div>

        @foreach ($data['getBankDetail'] as $myBank)


        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
            <h4><strong>{{ $myBank->accountNumber }}</strong></h4>

            <div class="row">
                <div class="col-md-12">
                    <strong>{{ $myBank->bankName }}</strong>
                </div>
                <div class="col-md-6">
                    <strong>Transit No: {{ $myBank->transitNumber }}</strong>
                </div>
                <div class="col-md-6">
                    <strong>Branch Code: {{ $myBank->branchCode }}</strong>
                </div>
                <div class="col-md-12">
                    <h4><strong>{{ (strlen($myBank->accountName) < 18) ? strtoupper($myBank->accountName) : substr(strtoupper($myBank->accountName), 0, 18)."..." }}</strong></h4>
                </div>
                <div class="col-md-6">
                    <input type="hidden" name="card_id" value="{{ $myBank->id }}" id="card_id">
                    <a href="{{ route('Edit merchant bank account', $myBank->id) }}" title="Edit Card"><i class="far fa-edit text-secondary"></i></a>
                    <a href="javascript:void(0)" title="Delete Card" onclick="handShake('deletebank')"><i class="far fa-trash-alt text-danger"></i></a>
                </div>
                
            </div>

              {{-- <p>Total Withdrawal</p> --}}
            </div>
            <div class="icon">
              <i class="fas fa-university"></i>
            </div>
        {{--  <a href="{{ route('Otherpay') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>  --}}
          </div>
        </div>
        <!-- /.col -->

        @endforeach
            
        @else
        <div class="col-md-12">
            <div class="alert bg-info">
                        <center>
                            <div class="row">
                            <div class="col-md-12">
                                <h4>
                                    No Bank Account!!
                                </h4>
                                <p>
                                    You are yet to add any bank account, start adding your bank account by clicking the add bank account below.
                                </p>
                                <div class="col-md-6 col-md-offset-3">
                                    <button class="btn btn-secondary btn-block bg-black" onclick="showForm('card')">Add Bank Account <i class="fa fa-credit-card"></i></button>
                                </div>
                            </div>
                        </div>
                        </center>
            </div>
        </div>

        @endif

        

      </div>
      <!-- /.row -->
      <div class="row">
                      <div class="box-body">

                    <div class="form-group cardform disp-0"> 
                            <form action="#" method="POST" id="formElem">
                                @csrf


                                <div class="form-group">
                                    <label for="bankName">Bank Name</label>

                                    @if($userInfo = \App\User::where('ref_code', session('user_id'))->first())

                                        @if($userInfo->country == "Canada")

                                            <select name="bankName" id="bankName" class="form-control" required>
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

                                        <input type="text" name="bankName" id="bankName" class="form-control" required>
                                        @endif


                                    @endif

                                </div>






                                <div class="form-group">
                                    <label for="transitNumber">Transit Number</label>

                                    <input type="text" name="transitNumber" id="transitNumber" class="form-control" required>
                                    

                                </div>



                                <div class="form-group">
                                    <label for="branchCode">Branch Code</label>

                                <input type="text" name="branchCode" id="branchCode" class="form-control" required>
                                    

                                </div>
                                <div class="form-group">
                                    <label for="accountName">Account Name</label>

                                <input type="text" name="accountName" id="accountName" class="form-control" required>
                                    

                                </div>
                                <div class="form-group">
                                    <label for="accountNumber">Account Number</label>

                                <input type="text" name="accountNumber" id="accountNumber" class="form-control" required>
                                    

                                </div>



                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-block" onclick="handShake('addbank')" id="cardSubmit">Submit</button>
                                </div>

                            </form>
                        </div>
                </div>
    </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @endsection