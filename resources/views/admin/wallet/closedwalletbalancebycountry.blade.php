@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\OrganizationPay; ?>
<?php use \App\Http\Controllers\ClientInfo; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Closed User Wallet Balance In {{ Request::get('country') }}
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="active">Closed User Wallet Balance In {{ Request::get('country') }}</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Closed User Wallet Balance In {{ Request::get('country') }}</h3>

					</div>
					<!-- /.box-header -->
					<div class="box-body table table-responsive">

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
								<tr>
									<th>S/N</th>
									<th>Name</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Account Type</th>
									<th>Wallet Balance</th>
								</tr>
							</thead>
							<tbody>
								@if (count($data['walletByCountry']) > 0)
								<?php $i = 1; $totalPaid = 0; $remtoPay = 0; $totalinv = 0;?>
								@foreach ($data['walletByCountry'] as $data)
								<tr>
									<td>{{ $i++ }}</td>
									<td>{{ $data->name }}</td>
									<td>{{ $data->email }}</td>
									<td>{{ $data->telephone }}</td>
									<td>{{ $data->accountType }}</td>
									<td style="font-weight: 700;">{{ $data->currencyCode.'
										'.number_format($data->wallet_balance, 2) }}</td>
								</tr>

								@php
								$totalPaid += $data->wallet_balance;
								@endphp

								@endforeach



								@else
								<tr>
									<td colspan="6" align="center">No record available</td>
								</tr>
								@endif
							</tbody>

							@isset($totalPaid)
							<tfoot>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td style="font-weight: bold; color: black;">Total: </td>
									<td style="font-weight: bold; color: green;">{{ '+'.$data->currencyCode.'
										'.number_format($totalPaid, 2) }}</td>

								</tr>
							</tfoot>
							@endisset

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