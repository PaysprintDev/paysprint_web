@extends('layouts.dashboard')

@section('dashContent')
<?php

use App\Http\Controllers\User; ?>
<?php

use App\Http\Controllers\AddCard; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Edit Marketplace News
		</h1>
		<ol class="breadcrumb">
			<li><a href={{ " route('Admin') " }}><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active"> Edit Marketplace News</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

		<br>
		<button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go
			back</button>
		<br>
		{!! session('msg') !!}
		<div class="row">
			<div class="col-xs-12">
				<div class="box">

					<div class="box-body">
						<div class="box-body">
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

								</thead>
								<form action="{{ route('update marketplace news', $data['post']->id) }}" method="POST" enctype="multipart/form-data">

									@csrf
									<div class="row">
										<div class="col-12">
											<legend>Marketplace News</legend>
										</div>

										<br>
										<div class="col-12 mt-2 mb-2">
											<label for="post_title" class="form-label">News Title:</label>
											<input type="text" name="title" class="form-control" id="post_title" value="{{ $data['post']->title }}">
										</div>
										<div class="col-12 mt-2 mb-2">
											<label for="description" class="form-label">Description:</label>
											<textarea name="description" class="form-control summernote" id="description">{!! $data['post']->description !!}</textarea>
										</div>
										<div class="col-12">
											<label for="investment_document" class="form-label">
												File
											</label>
											<input type="file" class="form-control" name="file" id="file" value="{{ $data['post']->file }}">
										</div><br>
										<div class="">
											<button type="submit" class="col-md-8 btn btn-primary form-control">Update</button>
										</div>
								</form>

							</table>

						</div>

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