@extends('layouts.dashboard')

@section('dashContent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Get Fx Rate
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Get Fx Rate</li>
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
							<label class="control-label" for="inputSuccess">Select Currency From</label>
							<select name="currency_from" class="form-control">
								@foreach ( $data['country'] as $allcountry)
								<option value="{{$allcountry->currencyCode}}">{{$allcountry->name}}</option>
								@endforeach
							</select>
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
					<!-- /.box-body -->

					<div class="box-footer">
						<button type="submit" class="btn btn-primary btn-block">GET FX RATE</button>
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