@extends('layouts.dashboard')

@section('dashContent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Get Beneficiary Page
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Get Beneficiary Page</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="box">
			{!! session('msg') !!}
			<div class="box-body">

				{{-- Provide Form --}}
				<form role="form" action="{{route('submit fx rate')}}" method="POST">
					@csrf
					<div class="box-body">
						<div class="form-group has-success">
							<label class="control-label" for="inputSuccess">Beneficiary First Name</label>
							<input type="text" name="beneficiaryFirstName" class="form-control">
						</div>

						<div class="form-group has-success">
							<label class="control-label" for="inputSuccess">Beneficiary Last Name</label>
							<input type="text" name="beneficiaryLastName" class="form-control">
						</div>

						<div class="form-group has-success">
							<label class="control-label" for="inputSuccess">Beneficiary Company Name</label>
							<input type="text" name="beneficiaryCompanyName" class="form-control">
						</div>

						<div class="form-group has-success">
							<label class="control-label" for="inputSuccess">National ID</label>
							<input type="text" name="nationalId" class="form-control">
						</div>

						<div class="form-group has-success">
							<label class="control-label" for="inputSuccess">Account Number</label>
							<input type="text" name="accountNumber" class="form-control">
						</div>

						<div class="form-group has-success">
							<label class="control-label" for="inputSuccess">Select Currency To</label>
							<select name="currency_to" class="form-control">
								@foreach ( $data['country'] as $allcountry)
								<option value="{{$allcountry->currencyCode}}">{{$allcountry->name}}</option>
								@endforeach
							</select>
						</div>

					</div>

					<div class="box-footer">
						<button type="submit" class="btn btn-primary btn-block">CREATE BENEFICIARY</button>

				</form>
				{{-- List Categories --}}
				<hr>

			</div>
		</div>
		{{-- {!! session('response') !!} --}}

		@if(isset($data['dataRate']))
		<table class="table table-striped">
			<thead>
				<tr>
					<td>Currency From</td>
					<td>Currency To</td>
					<td>Fx Rate</td>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td>{{$data['dataRate'][0]->currency_from}}</td>
					<td>{{$data['dataRate'][0]->currency_to}}</td>
					<td>{{$data['dataRate'][0]->rate}}</td>
				</tr>
			</tbody>

		</table>

		@endif
		<!-- /.box -->

	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection