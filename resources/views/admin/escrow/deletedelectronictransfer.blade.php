@extends('layouts.dashboard')

@section('dashContent')


<?php

use App\Http\Controllers\User; ?>
<?php

use App\Http\Controllers\UserClosed; ?>
<?php

use App\Http\Controllers\FxPayment; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Bank/Wire/Electronic Transfer
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Bank/Wire/Electronic Transfer</li>
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
						{!! session('msg') !!}
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
									<th>Paysprint Reference No</th>
									<th>Customer Reference No.</th>
									<th>Account Number</th>
									<th>Amount Funded</th>
									<th>Payment Method</th>
									<th>Account Name</th>
									<!-- <th>Bank Name</th>
									<th>Bank Account Number</th>
									<th>Bank Account Name</th> -->
									<th>Date</th>
									<!-- <th>Status</th> -->
									<th colspan="3">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1; ?>
								@if ( count($data['transfer']) > 0)
								@foreach ( $data['transfer'] as $transfers)
								@if ( $statement =
								\App\Statement::where('reference_code',$transfers->transaction_id)->first())
								@if ($user = \App\User::where('email', $statement->user_id)->first())
								<tr>

									<td>{{ $i++}}</td>
									<td>{{$statement->etransfer_reference}}</td>
									<td>{{$transfers->transaction_id}}</td>
									<td>{{$user->ref_code}}</td>
									<td>{{$user->currencyCode.$statement->credit}}</td>
									<td>Bank/Wire Transfer</td>
									<td>{{ $user->name}}</td>
									<td>{{ date('d/M/Y h:i a', strtotime($transfers->created_at)) }}</td>
									<!-- <td>Hi</td> -->
									{{-- @if ($transfers->flag_state == 0)

									<td>
										<form action="{{ route('flag this money') }}" method="post"
											id="flag{{ $transfers->transaction_id }}">@csrf <input type="hidden"
												name="transaction_id" value="{{ $transfers->transaction_id }}"></form>

										<a type="button" class="btn btn-warning" href="javascript:void(0)"
											onclick="flagMoney('flag', '{{ $transfers->transaction_id }}')">Flag</a>
									</td>

									@else
									<td>
										<a type="button" class="btn btn-default"
											style="background: black; color: white; cursor: not-allowed;"
											href="javascript:void(0)" style="cursor: not-allowed">Flagged</a>
									</td>
									@endif --}}

									<td>
										@if ($transfers->reversal_state == 0)
										<button class="btn btn-danger" id="btns{{ $transfers->transaction_id}}"
											onclick="restoreTransaction('{{ $transfers->transaction_id }}');">Restore</button>
										<form action="{{ route('restore transaction') }}" method="post"
											style="visibility: hidden"
											id="restoretransaction{{ $transfers->transaction_id }}">
											@csrf
											<input type="hidden" name="transactionid"
												value="{{ $transfers->transaction_id}}">
										</form>
										@endif

									</td>
									{{-- <td>
										@if ($transfers->hold_fee == 1)
										@if ($userStatement = \App\Statement::where('reference_code',
										$transfers->transaction_id)->first())
										@if ($userStatement = \App\User::where('email',
										$userStatement->user_id)->first())
										@if ($userStatement->account_check == 2)
										<a type="button" class="btn btn-primary" href="javascript:void(0)"
											onclick="releaseFee('{{ $transfers->transaction_id }}')">Release
											<img src="https://img.icons8.com/office/20/000000/spinner-frame-4.png"
												class="fa fa-spin spinFee{{ $transfers->transaction_id }} disp-0"></a>
										@else
										<a type="button" class="btn btn-primary" href="javascript:void(0)"
											onclick="releaseFee('{{ $transfers->transaction_id }}')">Release
											<img src="https://img.icons8.com/office/20/000000/spinner-frame-4.png"
												class="fa fa-spin spinFee{{ $transfers->transaction_id }} disp-0"></a>
										@endif
										@endif
										@endif
										@else
										<a type="button" class="btn btn-success" href="javascript:void(0)"
											style="cursor: not-allowed">Released</a>
										@endif

									</td> --}}

								</tr>
								@endif
								@endif
								@endforeach
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