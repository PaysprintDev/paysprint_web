@extends('layouts.dashboard')

@section('dashContent')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Login to VertoFx
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Login to VertoFx</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="box">
			{!! session('msg') !!}
			<div class="box-body">

				{{-- Provide Form --}}
				<form role="form" action="{{route('submit login verto fx')}}" method="POST">
					@csrf
					<div class="box-body">
						<div class="form-group has-success">
							<label class="control-label" for="inputSuccess"> ClientId</label>
							<input type="text" name="clientId" class="form-control" value="{{$data['clientid']}}"
								readonly>
						</div>


						<div class="form-group has-success">
							<label class="control-label" for="inputSuccess">Api Key</label>
							<input type="text" name="apiKey" class="form-control" value="{{$data['apiKey']}}" readonly>
						</div>


						<div class="form-group has-success">
							<label class="control-label" for="inputSuccess"> Mode:</label>
							<input type="text" name="mode" class="form-control" value="{{'apiKey'}}" readonly>
						</div>


					</div>
					<!-- /.box-body -->

					<div class="box-footer">
						<button type="submit" class="btn btn-primary btn-block">LOGIN TO VERTO FX</button>
				</form>



				{{-- List Categories --}}
				<hr>

			</div>
			<!-- /.box-body -->

		</div>
		<!-- /.box -->

	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection