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
			Edit E-store Products
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Edit E-store Products</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						{!! session('msg') !!}
						<h3 class="box-title">Edit E-Store Products</h3>

					</div>
					<!-- /.box-header -->
					<div class="container-fluid">
						<form action="{{ route('update estore product',$data['products']->id) }}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-md-12">
									<p class="form-group">
										<label>Business Name</label>
										@if ($user =\App\User::where('id',$data['products']->merchantId)->first())
										<input type="text" name="business_name" value=" {{$user->businessname}}" class="form-control" readonly>
										@endif
									</p>
								</div>
								<div class="col-md-12">
									<p class="form-group">
										<label>Product Name</label>
										<input type="text" name="product_name" value="{{$data['products']->productName}}" class="form-control" readonly>
									</p>
								</div>
								<div class="col-md-12">
									<p class="form-group">
										<label>Product Code</label>
										<input type="text" name="product_code" value="{{$data['products']->productCode}}" class="form-control" readonly>
									</p>
								</div>
								<div class="col-md-12">
									<p class="form-group">
										<label>Product Image</label>
										<img style="width: 45px; height:45px;" src="{{ asset($data['products']->image) }}">
										<input type="file" name="product_image" class="form-control mt-2">
									</p>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Product Description</label>
										<textarea name="product_description"> value="{!! $data['products']->description !!}" </textarea>
									</div>
								</div>
								<p>
									<button class="btn btn-success form-control" type="submit">Update Product</button>
								</p>
							</div>
						</form>
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