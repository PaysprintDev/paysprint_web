@extends('layouts.dashboard')

@section('dashContent')


<?php

use \App\Http\Controllers\User; ?>
<?php

use \App\Http\Controllers\OrganizationPay; ?>
<?php

use \App\Http\Controllers\ClientInfo; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			All Countries Bank Information
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">All Countries Bank Information</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">All Countries Bank Information</h3>

					</div>
					<!-- /.box-header -->
					<div class="box-body">




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