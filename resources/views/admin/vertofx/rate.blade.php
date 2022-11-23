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
				{{-- {{dd($data)}} --}}
				@if(isset($data))
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
							<td>{{$data['currency_from']}}</td>
							<td>{{$data['currency_to']}}</td>
							<td>{{$data['rate']}}</td>
						</tr>
					</tbody>

				</table>

				@endif
				<a href="{{route('get fx rate')}}" class="btn btn-success form-control mt-3">Return Back</a>

			</div>
		</div>
		{{-- {!! session('response') !!} --}}


		<!-- /.box -->

	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection