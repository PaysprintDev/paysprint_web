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
					<div class="row">
						<form action="{{route('update estore product',$data['products']->id)}}" method="post"
							enctype="multipart/form-data">
							@csrf
							<div class="col-md-12">
								<p class="form-group">
									<label>Business Name</label>
									@if($user =\App\User::where('id', $data['products']->merchantId)->first())
									<input type="text" name="business_name" class="form-control"
										value="{{ $user->businessname }}" readonly>
									@endif
								</p>
							</div>
							<div class="col-md-12">
								<p class="form-group">
									<label>Product Name</label>
									<input type="text" name="product_name" class="form-control"
										value="{{ $data['products']->productName }}" readonly>
								</p>
							</div>
							<div class="col-md-12">
								<p class="form-group">
									<label>Product Code</label>
									<input type="text" name="product_code" class="form-control"
										value="{{ $data['products']->productCode }}" readonly>
								</p>
							</div>
							<div class="col-md-12">
								<p class="form-group">
									<label>Product Image</label>
									<img src="{{asset($data['products']->image)}}" style="width: 40px; height:40px">
									<input type="file" name="product_image" class="form-control"
										value="{{$data['products']->image}}">
								</p>
							</div>
							<div class="col-md-12">
								<p class="form-group">
									<label>Product Description</label>
									<textarea name="product_description" style="height: 100px; width:100%"
										class="form-control">{!! $data['products']->description !!}</textarea>
								</p>
							</div>
							<button class="btn btn-success form-control mt-2" type="submit">Update</button>
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