@extends('layouts.dashboard')

@section('dashContent')
<?php

use App\Http\Controllers\User; ?>
<?php

use App\Http\Controllers\Admin; ?>
<?php

use App\Http\Controllers\OrganizationPay; ?>
<?php

use App\Http\Controllers\ClientInfo; ?>
<?php

use App\Http\Controllers\AnonUsers; ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			E-store Products
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active"> E-store Products</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						{!! session('msg') !!}
						<h3 class="box-title"> E-Store Products</h3>

					</div>
					<!-- /.box-header -->
					<div class="box-body table table-responsive">
						<table class="table table-striped table-responsive">
							@php
							$counter = 1;
							@endphp
							<thead>
								<tr>
									<th>S/N</th>
									<th>Store Name</th>
									<th>Product Name</th>
									<th>Product Code</th>
									<th>Image</th>
									<th>Description</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@if (count($data['products']) > 0)
								@foreach ($data['products'] as $value)
								@if ($user = \App\User::where('id', $value->merchantId)->first())
								<tr>
									<td>{{ $counter++ }}</td>
									<td>{{ $user->businessname }}</td>
									<td>{{$value->productName}}</td>
									<td>{{$value->productCame}}</td>
									<td><img style="width: 45px; height:45px;" src="{{ asset($value->image) }}"></td>
									<td>{{ $value->description }}</td>
									<td><a href="{{route('edit estore product',$value->id)}}" class="btn btn-primary">Edit Product</a></td>
								</tr>
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