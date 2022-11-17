@extends('layouts.dashboard')

@section('dashContent')


<?php use App\Http\Controllers\User; ?>
<?php use App\Http\Controllers\BankWithdrawal; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Claim Reward
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Claim Points Reward</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					{!! session('msg') !!}
					<div class="box-header">
						<div class="row">
							<div class="col-md-2 col-md-offset-0">
								<button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i
										class="fas fa-chevron-left"></i> Go back</button>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 mt-3">
								<form action="{{route('wallet debit')}}" method="get">
									@csrf
									<p class="form-group mt-3 mb-3">
										<label>Search Customer</label>
										<input type="text" name="customer_details" class="form-control"
											placeholder="Enter Name or Account Number">
									</p>
									<button type="submit" class="btn btn-success form-control">Submit</button>
								</form>
							</div>
						</div>
					</div>
					<!-- /.box-header -->

					<div class="box-body">
						<div class="row">
							@if(isset($data['details']) && $data['details'] != null)

							<table class="table table-striped table-responsiveness">
								@php
								$count=1;
								@endphp
								<thead>
									<tr>
										<th>S/N</th>
										<th>Account Number</th>
										<th>Name</th>
										<th>Email</th>
										<th colspan="2">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>{{$count}}</td>
										<td>{{$data['details']->ref_code}}</td>
										<td>{{$data['details']->name}}</td>
										<td>{{$data['details']->email}}</td>
										<td>
											<!-- Button trigger modal -->
											<button type="button" class="btn btn-primary" data-toggle="modal"
												data-target="#exampleModal{{$data['details']->id}}">
												Debit Wallet
											</button>
										</td>
										<td>
											<button type="button" class="btn btn-success" data-toggle="modal"
												data-target="#exampleModal2{{$data['details']->id}}">
												Security Wallet Debit
											</button>
										</td>
										<!-- Wallet Debit Modal -->
										<div class="modal fade" id="exampleModal{{$data['details']->id}}" tabindex="-1"
											role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Wallet Debit</h5>
														<button type="button" class="close" data-dismiss="modal"
															aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>

													<div class="modal-body">
														<form action="{{route('submit wallet debit')}}" method="post">
															@csrf
															<div class="col-md-12">
																<div class="form-group">
																	<label>Customer Name</label>
																	<input type="text" name="customer_name"
																		class="form-control"
																		value="{{$data['details']->name}}">
																</div>
															</div>

															<div class="col-md-12">
																<div class="form-group">
																	<label>Account Number</label>
																	<input type="text" name="account_number"
																		class="form-control"
																		value="{{$data['details']->ref_code}}">
																</div>
															</div>

															<div class="col-md-12">
																<div class="form-group">
																	<label>Email</label>
																	<input type="text" name="email" class="form-control"
																		value="{{$data['details']->email}}">
																</div>
															</div>
															<div class="col-md-6">
																<p style="font-weight:bold"><u>Country:</u></p>
																<p style="color:red">{{$data['details']->country}}</p>
															</div>
															<div class="col-md-6">
																<p style="font-weight:bold"><u>Wallet Balance:</u></p>
																<p style="color:red">
																	{{$data['details']->wallet_balance}}</p>
															</div>

															<div class="col-md-12 mt-4 mb-3">
																<div class="form-group">
																	<label>Amount to Debit</label>
																	<input type="text" name="debit_amount"
																		class="form-control"
																		placeholder="Enter amount to Debit Customer">
																</div>
															</div>
															<div class="col-md-12 mt-4 mb-3">
																<div class="form-group">
																	<label>Reasons for Wallet Debit</label>
																	<input type="text" name="debit_reason"
																		class="form-control"
																		placeholder="Please enter reason for wallet debit">
																</div>
															</div>
															<input type="hidden" name="user_id"
																value="{{$data['details']->id}}">


													</div>
													<div class="modal-footer mt-4">
														<button type="reset" class="btn btn-danger"
															data-dismiss="modal">Close</button>
														<button type="submit" class="btn btn-primary">Submit</button>
													</div>
													</form>
												</div>
											</div>
										</div>
										<!-- Securoty Wallet Debit Modal -->
										<div class="modal fade" id="exampleModal2{{$data['details']->id}}" tabindex="-1"
											role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Security Wallet
															Debit</h5>
														<button type="button" class="close" data-dismiss="modal"
															aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>

													<div class="modal-body">
														<form action="{{route('submit wallet debit')}}" method="post">
															@csrf
															<div class="col-md-12">
																<div class="form-group">
																	<label>Customer Name</label>
																	<input type="text" name="customer_name"
																		class="form-control"
																		value="{{$data['details']->name}}">
																</div>
															</div>

															<div class="col-md-12">
																<div class="form-group">
																	<label>Account Number</label>
																	<input type="text" name="account_number"
																		class="form-control"
																		value="{{$data['details']->ref_code}}">
																</div>
															</div>

															<div class="col-md-12">
																<div class="form-group">
																	<label>Email</label>
																	<input type="text" name="email" class="form-control"
																		value="{{$data['details']->email}}">
																</div>
															</div>
															<div class="col-md-6">
																<p style="font-weight:bold"><u>Country:</u></p>
																<p style="color:red">{{$data['details']->country}}</p>
															</div>
															<div class="col-md-6">
																<p style="font-weight:bold"><u>Wallet Balance:</u></p>
																<p style="color:red">
																	{{$data['details']->security_deposit_balance}}</p>
															</div>

															<div class="col-md-12 mt-4 mb-3">
																<div class="form-group">
																	<label>Amount to Debit</label>
																	<input type="text" name="debit_amount"
																		class="form-control"
																		placeholder="Enter amount to Debit Merchant">
																</div>
															</div>
															<div class="col-md-12 mt-4 mb-3">
																<div class="form-group">
																	<label>Reasons for Wallet Debit</label>
																	<input type="text" name="debit_reason"
																		class="form-control"
																		placeholder="Please enter reason for security wallet debit">
																</div>
															</div>
															<input type="hidden" name="user_id"
																value="{{$data['details']->id}}">


													</div>
													<div class="modal-footer mt-4">
														<button type="reset" class="btn btn-danger"
															data-dismiss="modal">Close</button>
														<button type="submit" class="btn btn-primary">Submit</button>
													</div>
													</form>
												</div>
											</div>
										</div>

									</tr>
								</tbody>
							</table>

							@endif
						</div>
					</div>
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