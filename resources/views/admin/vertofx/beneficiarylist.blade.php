@extends('layouts.dashboard')

@section('dashContent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			VertoFx Beneficiary List
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">VertoFx Beneficiary List</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="box">
			{!! session('msg') !!}
			<div class="box-body table table-responsive">
				<table class="table table-striped table-responsive" id="example1">
					<thead>
						<tr>
							<th>S/N</th>
							<th>Account Number</th>
							<th>Bank Name</th>
							<th>Beneficiary Address</th>
							<th>Beneficiary City</th>
							<th>Beneficiary Company Name</th>
							<th>Beneficiary Country Code</th>
							<th>Beneficiary Entity Type</th>
							<th>Beneficiary Postcode</th>
							<th>Country</th>
							<th>Reference</th>
							<th>Beneficiary Firstname</th>
							<th>Beneficiary Lastname</th>
							<th>National Id</th>
							<th>Currency</th>
							<th>Client Reference</th>
							<th>Status</th>
							<th colspan="3">Action</th>
						</tr>
					</thead>
					<tbody>
						@php
						$no=1;
						@endphp
						@if(count($list) > 0)
						@foreach ( $list as $beneficiary)
						<tr>
							<td>{{$no++}}</td>
							<td>{{$beneficiary->accountNumber}}</td>
							<td>{{$beneficiary->bankName}}</td>
							<td>{{$beneficiary->beneficiaryAddress}}</td>
							<td>{{$beneficiary->beneficiaryCity}}</td>
							<td>{{$beneficiary->beneficiaryCompanyName}}</td>
							<td>{{$beneficiary->beneficiaryCountryCode}}</td>
							<td>{{$beneficiary->beneficiaryEntityType}}</td>
							<td>{{$beneficiary->beneficiaryPostcode}}</td>
							<td>{{$beneficiary->country}}</td>
							<td>{{$beneficiary->reference}}</td>
							<td>{{$beneficiary->beneficiaryFirstName}}</td>
							<td>{{$beneficiary->beneficiaryLastName}}</td>
							<td>{{$beneficiary->nationalId}}</td>
							<td>{{$beneficiary->currency}}</td>
							<td>{{$beneficiary->clientReference}}</td>
							<td>{{$beneficiary->status}}</td>
							<td>
								<!-- Button trigger modal -->
								<button type="button" class="btn btn-primary" data-toggle="modal"
									data-target="#exampleModal{{$beneficiary->id}}">
									Update Beneficiary Details
								</button>

								<!-- Modal -->
								<div class="modal fade" id="exampleModal{{$beneficiary->id}}" tabindex="-1"
									aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
												<button type="button" class="btn-close" data-dismiss="modal"
													aria-label="Close"></button>
											</div>
											<div class="modal-body">
												...
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary"
													data-bs-dismiss="modal">Close</button>
												<button type="button" class="btn btn-primary">Save changes</button>
											</div>
										</div>
									</div>
								</div>
							</td>
							<td>
								<a href="#" class="btn btn-success">Get Beneficiary Details</a>

							</td>
							<td>
								<a href="#" class="btn btn-danger">Delete Beneficiary</a>
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>

				<hr>

			</div>
		</div>
		{{-- {!! session('response') !!} --}}

		<!-- /.box -->

	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection