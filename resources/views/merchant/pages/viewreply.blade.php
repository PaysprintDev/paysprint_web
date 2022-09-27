<!doctype html>
<html lang="en">
<?php

use App\Http\Controllers\User; ?>

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

	<!-- Favicon -->
	<link rel="icon" href="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg" type="image/x-icon" />

	<link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />

	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

	<script src="https://kit.fontawesome.com/384ade21a6.js"></script>

	<title>PaySprint | {{ Request::get('service') . ' Marketplace Replies' }}</title>

	<style>
		body {
			background: #f5f5f5
		}

		.rounded {
			border-radius: 1rem
		}

		.nav-pills .nav-link {
			color: rgb(255, 255, 255)
		}

		.nav-pills .nav-link.active {
			color: white
		}

		input[type="radio"] {
			margin-right: 5px
		}

		.bold {
			font-weight: bold
		}

		.disp-0 {
			display: none !important;
		}

		.fas {
			font-size: 12px;
		}
	</style>

</head>

<body>
	<div class="container py-5">
		<!-- For demo purpose -->
		<div class="row mb-4">
			<div class="col-lg-10 mx-auto text-center">
				<h1 class="display-4">Marketplace Replies</h1>
			</div>
		</div> <!-- End -->
		<div class="row">
			<div class="col-lg-12 mx-auto">



				<div class="card ">
					<div class="card-header">
						<div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">


							<!-- Credit card form tabs -->
							<ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
								@if (Auth::user()->accountType == 'Merchant')
								<li class="nav-item"> <a data-toggle="pill" href="{{ route('Admin') }}" class="nav-link active "> <i class="fas fa-home"></i> Go Back </a>
								</li>
								@else
								<li class="nav-item"> <a data-toggle="pill" href="{{ route('home') }}" class="nav-link active "> <i class="fas fa-home"></i> Go Back </a>
								</li>
								@endif

							</ul>


						</div>

					</div> <!-- End -->
					{!! session('msg') !!}
					<!-- Reviews -->

				</div>


			</div>
		</div>
		<div class="row">
			@if (count($data['comments']) > 0)
			@foreach ($data['comments'] as $comments)
			@if ($reply= \App\MarketplaceReviews::where('id',$comments->id)->first())
			<div class="col-md-3">
				<h3>Date</h3>
				<p>{{$reply->created_at}}</p>
			</div>
			<div class="col-md-3">
				<h3>Name of Sender</h3>
				<p>{{$reply->name_of_sender}}</p>
			</div>
			<div class="col-md-3">
				<h3>Comment</h3>
				<p>{{$reply->comment}}</p>
			</div>
			<div class="col-md-3">
				<h3>Merchant Reply</h3>
				<p>{{$comments->merchant_reply}}</p>
			</div>
			@endif
			@endforeach
			@endif
		</div>

	</div>


	<script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>

	@include('include.message')


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous">
	</script>
	<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

	<script src="{{ asset('pace/pace.min.js') }}"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



	<script>
		$(document).ready(function() {
			$('#myTableAll').DataTable();
		});

		function handShake(val) {


			var route;

			if (val == 'requestforrefund') {

				var formData = new FormData(formElem);


				route = "{{ URL('/api/v1/requestforrefund') }}";

				Pace.restart();
				Pace.track(function() {
					setHeaders();
					jQuery.ajax({
						url: route,
						method: 'post',
						data: formData,
						cache: false,
						processData: false,
						contentType: false,
						dataType: 'JSON',
						beforeSend: function() {
							$('#cardSubmit').text('Please wait...');
						},
						success: function(result) {
							console.log(result);

							$('#cardSubmit').text('Submit');

							if (result.status == 200) {
								swal("Success", result.message, "success");
								setTimeout(function() {
									location.href = "{{ route('my account') }}";
								}, 5000);
							} else {
								swal("Oops", result.message, "error");
							}

						},
						error: function(err) {
							swal("Oops", err.responseJSON.message, "error");

						}

					});
				});

			} else if (val == "deletebank") {

				// Ask Are you sure

				swal({
						title: "Are you sure you want to delete bank account?",
						text: "This bank account will be deleted and can not be recovered!",
						icon: "warning",
						buttons: true,
						dangerMode: true,
					})
					.then((willDelete) => {
						if (willDelete) {

							// Run Ajax

							var thisdata = {
								id: $("#bank_id").val()
							};

							route = "{{ URL('/api/v1/deletebank') }}";

							Pace.restart();
							Pace.track(function() {
								setHeaders();
								jQuery.ajax({
									url: route,
									method: 'post',
									data: thisdata,
									dataType: 'JSON',

									success: function(result) {

										if (result.status == 200) {
											swal("Success", result.message, "success");
											setTimeout(function() {
												location.reload();
											}, 2000);
										} else {
											swal("Oops", result.message, "error");
										}

									},
									error: function(err) {
										swal("Oops", err.responseJSON.message, "error");

									}

								});
							});


						} else {

						}
					});

			}

		}


		function showForm(val) {
			$(".cardform").removeClass('disp-0');
			$(".pickCard").addClass('disp-0');
		}

		function setHeaders() {

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}",
					'Authorization': "Bearer " + "{{ Auth::user()->api_token }}"
				}
			});

		}
	</script>

</body>

</html>