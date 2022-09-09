@extends('layouts.app')

@section('title', 'Profile')


@show
<?php

use App\Http\Controllers\LinkAccount; ?>
<?php

use App\Http\Controllers\FlutterwaveModel; ?>
@section('text/css')

<style>
	.billingIns {
		margin-bottom: 10px;
	}

	.billingIns>input {
		padding: 20px 15px;
	}

	.billingIns>select {
		padding: 5px 15px;
		line-height: 10;
	}

	.tab-menu {
		font-weight: bold;
		color: navy;
	}

	.invoice {
		position: relative !important;
		top: 0 !important;
	}

	.notificationImage {
		margin-top: 0px;
	}
</style>

@show


@section('content')

<!-- Banner area -->
<section class="banner_area" data-stellar-background-ratio="0.5">
	<h2>Vouched Family and Friends</h2>
	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}">Home</a></li>
		<li><a href="#" class="active">Vouched Family and Friends</a></li>
	</ol>
</section>
<!-- End Banner area -->
<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 ">
				<table class="table table-striped table-responsive">
					<thead>
						<tr>
							<th>S/N</th>
							<th>Name of Family and Friend</th>
							<th>Account Number</th>
						</tr>
					</thead>
					<tbody>
						@php
						$counter=1;
						@endphp
						@if ( isset($data['vouch']))
						@foreach ( $data['vouch'] as $vouchlist )
						@if ($user= \App\User::where('ref_code', $vouchlist->voucher_ref_code)->first())
						<tr>

							<td>{{ $counter++ }}</td>
							<td>{{ $user->name}}</td>
							<td>{{ $vouchlist->voucher_ref_code}}</td>

						</tr>
						@endif
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
<!-- Our Services Area -->

<!-- End Our Services Area -->


@endsection