<!doctype html>
<html lang="en">
<?php

use App\Http\Controllers\User; ?>

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
		integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

	<!-- Favicon -->
	<link rel="icon"
		href="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg"
		type="image/x-icon" />

	<link rel="stylesheet" type="text/css" href="{{ asset('pace/themes/orange/pace-theme-flash.css') }}" />

	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

	<script src="https://kit.fontawesome.com/384ade21a6.js"></script>

	<title>PaySprint | {{ Request::get('service') . ' Verification Page' }}</title>

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
				{{-- @php
				$name= \App\User::where('id', Request::get('id'))->first();

				@endphp
				<h1 class="display-4">Marketplace Reviews for {{$name->businessname}}</h1> --}}
			</div>
		</div> <!-- End -->
		<div class="row">
			<div class="col-lg-12 mx-auto">




				<div class="card ">
					<div class="card-header">
						{{-- {!! session('msg') !!} --}}
						<div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">

							{!! session('msg') !!}
							<!-- Credit card form tabs -->
							<ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
								@if (Auth::user()->accountType == 'Merchant')
								<li class="nav-item"> <a data-toggle="pill" href="{{ route('logout') }}"
										class="nav-link active "> <i class="fas fa-home"></i> Go Back </a>
								</li>
								@else
								<li class="nav-item"> <a data-toggle="pill" href="{{ route('logout') }}"
										class="nav-link active "> <i class="fas fa-home"></i> Go Back </a>
								</li>
								@endif

							</ul>

						</div>

						<!-- the verification checkers-->
						<div class="row">
							<div class="col-md-12">
								<table class="table table-striped table-responsiveness">
									<thead>
										<tr>
											<th>Verification Documents</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Profile Avatar</td>
											@if(isset($data['avatar']))
											<td>
												<img src="https://img.icons8.com/fluency/48/000000/checked.png" />
											</td>
											@else
											<td>
												<img src="https://img.icons8.com/fluency/48/000000/cancel.png" />
											</td>
											@endif

											<td>
												@if(isset($data['avatar']))

												@else
												<!-- Button trigger modal -->
												<button type="button" class="btn btn-primary" data-bs-toggle="modal"
													data-bs-target="#exampleModal">
													Update
												</button>

												<!-- Modal -->
												<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
													aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">Profile
																	Photo Upload</h5>
																<button type="button" class="close"
																	data-bs-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<form action="{{route('verify photo')}}" method="post"
																	enctype="multipart/form-data">
																	@csrf
																	<div class="col-md-12">
																		<label>Kindly Upload Profile Photo</label>
																		<input type="file" name="avatar"
																			class="form-control">
																	</div>


															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-danger"
																	data-bs-dismiss="modal">Close</button>
																<button type="submit" class="btn btn-success">Save
																</button>
															</div>
															</form>
														</div>
													</div>
												</div>
												@endif

											</td>
										</tr>
										<tr>
											<td>National Identity Card</td>
											@if(isset($data['identitycard']))
											<td>
												<img src="https://img.icons8.com/fluency/48/000000/checked.png" />
											</td>
											@else
											<td>
												<img src="https://img.icons8.com/fluency/48/000000/cancel.png" />
											</td>
											@endif
											<td>
												@if(isset($data['identitycard']))

												@else
												<!-- Button trigger modal -->
												<button type="button" class="btn btn-primary" data-bs-toggle="modal"
													data-bs-target="#exampleModal2">
													Update
												</button>

												<!-- Modal -->
												<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"
													aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">Identity
																	Card Upload</h5>
																<button type="button" class="close"
																	data-bs-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<form action="{{route('verify identity card')}}"
																	method="post" enctype="multipart/form-data">
																	@csrf
																	<div class="col-md-12">
																		<label>Kindly Upload Identity Card</label>
																		<input type="file" name="nin_front"
																			class="form-control">
																	</div>


															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-danger"
																	data-bs-dismiss="modal">Close</button>
																<button type="submit" class="btn btn-success">Save
																</button>
															</div>
															</form>
														</div>
													</div>
												</div>
												@endif

											</td>
										</tr>
										<tr>
											<td>International Passport</td>
											@if(isset($data['passport']))
											<td>
												<img src="https://img.icons8.com/fluency/48/000000/checked.png" />
											</td>
											@else
											<td>
												<img src="https://img.icons8.com/fluency/48/000000/cancel.png" />
											</td>
											@endif
											<td>
												@if(isset($data['passport']))

												@else
												<!-- Button trigger modal -->
												<button type="button" class="btn btn-primary" data-bs-toggle="modal"
													data-bs-target="#exampleModal3">
													Update
												</button>

												<!-- Modal -->
												<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog"
													aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">
																	International Passport Upload</h5>
																<button type="button" class="close"
																	data-bs-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<form action="{{route('verify passport')}}"
																	method="post" enctype="multipart/form-data">
																	@csrf
																	<div class="col-md-12">
																		<label>Kindly Upload Your International
																			Passport</label>
																		<input type="file"
																			name="international_passport_front"
																			class="form-control">
																	</div>


															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-danger"
																	data-bs-dismiss="modal">Close</button>
																<button type="submit" class="btn btn-success">Save
																</button>
															</div>
															</form>
														</div>
													</div>
												</div>
												@endif

											</td>
										</tr>
										<tr>
											<td>Driving License</td>
											@if(isset($data['license']))
											<td>
												<img src="https://img.icons8.com/fluency/48/000000/checked.png" />
											</td>
											@else
											<td>
												<img src="https://img.icons8.com/fluency/48/000000/cancel.png" />
											</td>
											@endif
											<td>
												@if(isset($data['license']))

												@else
												<!-- Button trigger modal -->
												<button type="button" class="btn btn-primary" data-bs-toggle="modal"
													data-bs-target="#exampleModal4">
													Update
												</button>

												<!-- Modal -->
												<div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog"
													aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">Driving
																	License Upload</h5>
																<button type="button" class="close"
																	data-bs-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<form action="{{route('verify license')}}" method="post"
																	enctype="multipart/form-data">
																	@csrf
																	<div class="col-md-12">
																		<label>Kindly Upload Driving License</label>
																		<input type="file" name="drivers_license_front"
																			class="form-control">
																	</div>


															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-danger"
																	data-bs-dismiss="modal">Close</button>
																<button type="submit" class="btn btn-success">Save
																</button>
															</div>
															</form>
														</div>
													</div>
												</div>
												@endif

											</td>
										</tr>
										<tr>
											<td>Utility Bill</td>
											@if(isset($data['bill']))
											<td>
												<img src="https://img.icons8.com/fluency/48/000000/checked.png" />
											</td>
											@else
											<td>
												<img src="https://img.icons8.com/fluency/48/000000/cancel.png" />
											</td>
											@endif
											<td>
												@if(isset($data['bill']))

												@else
												<!-- Button trigger modal -->
												<button type="button" class="btn btn-primary" data-bs-toggle="modal"
													data-bs-target="#exampleModal5">
													Update
												</button>

												<!-- Modal -->
												<div class="modal fade" id="exampleModal5" tabindex="-1" role="dialog"
													aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">Utility
																	Bill Upload</h5>
																<button type="button" class="close"
																	data-bs-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<form action="{{route('verify bill')}}" method="post"
																	enctype="multipart/form-data">
																	@csrf
																	<div class="col-md-12">
																		<label>Kindly Upload Utlity Bill</label>
																		<input type="file" name="idvdoc"
																			class="form-control">
																	</div>


															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-danger"
																	data-bs-dismiss="modal">Close</button>
																<button type="submit" class="btn btn-success">Save
																</button>
															</div>
															</form>
														</div>
													</div>
												</div>
												@endif

											</td>
										</tr>
										@if(Auth::user()->country == 'Nigeria')
										<tr>
											<td>BVN</td>
											@if(isset($data['bvn']))
											<td>
												<img src="https://img.icons8.com/fluency/48/000000/checked.png" />
												@else
											<td>
												<img src="https://img.icons8.com/fluency/48/000000/cancel.png" />
											</td>
											@endif
											<td>
												@if(isset($data['bvn']))

												@else
												<!-- Button trigger modal -->
												<button type="button" class="btn btn-primary" data-bs-toggle="modal"
													data-bs-target="#exampleModal6">
													Update
												</button>

												<!-- Modal -->
												<div class="modal fade" id="exampleModal6" tabindex="-1" role="dialog"
													aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">BVN
																	Verification</h5>
																<button type="button" class="close"
																	data-bs-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<form action="{{route('verify bvn')}}" method="post">
																	@csrf
																	<div class="col-md-12">
																		<label>Kindly Provide Your Bvn Number</label>
																		<input type="text" name="bvn_number"
																			class="form-control"
																			placeholder="kindly enter your bvn digits">
																	</div>


															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-danger"
																	data-bs-dismiss="modal">Close</button>
																<button type="submit" class="btn btn-success">Save
																</button>
															</div>
															</form>
														</div>
													</div>
												</div>
												@endif

											</td>
										</tr>
										@endif

										@if(Auth::user()->accountType == 'Merchant')
										<tr>
											<td>Certificate of Incorporation</td>
											@if(isset($data['cacdocument']))
											<td>
												<img src="https://img.icons8.com/fluency/48/000000/checked.png" />
												@else
											<td>
												<img src="https://img.icons8.com/fluency/48/000000/cancel.png" />
											</td>
											@endif
											<td>
												@if(isset($data['cacdocument']))

												@else
												<!-- Button trigger modal -->
												<button type="button" class="btn btn-primary" data-bs-toggle="modal"
													data-bs-target="#exampleModal6">
													Update
												</button>

												<!-- Modal -->
												<div class="modal fade" id="exampleModal6" tabindex="-1" role="dialog"
													aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">CAC
																	Document</h5>
																<button type="button" class="close"
																	data-bs-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<form action="{{route('verify cac document')}}"
																	method="post" enctype="multipart/form-data">
																	@csrf
																	<div class="col-md-12">
																		<label>Kindly Upload your CAC Document</label>
																		<input type="file"
																			name="incorporation_doc_front"
																			class="form-control"
																			placeholder="kindly enter your bvn digits">
																	</div>


															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-danger"
																	data-bs-dismiss="modal">Close</button>
																<button type="submit" class="btn btn-success">Save
																</button>
															</div>
															</form>
														</div>
													</div>
												</div>
												@endif
											</td>
										</tr>

										<!--Directors Document -->
										<tr>
											<td>Directors Document</td>
											@if(isset($data['directorsdoc']))
											<td>
												<img src="https://img.icons8.com/fluency/48/000000/checked.png" />
												@else
											<td>
												<img src="https://img.icons8.com/fluency/48/000000/cancel.png" />
											</td>
											@endif
											<td>
												@if(isset($data['directorsdoc']))

												@else
												<!-- Button trigger modal -->
												<button type="button" class="btn btn-primary" data-bs-toggle="modal"
													data-bs-target="#exampleModal6">
													Update
												</button>

												<!-- Modal -->
												<div class="modal fade" id="exampleModal6" tabindex="-1" role="dialog"
													aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">Directors
																	Document</h5>
																<button type="button" class="close"
																	data-bs-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<form action="{{route('verify director document')}}"
																	method="post" enctype="multipart/form-data">
																	@csrf
																	<div class="col-md-12">
																		<label>Kindly Upload Directors
																			Document</label>
																		<input type="file" name="directors_document"
																			class="form-control"
																			placeholder="kindly enter your bvn digits">
																	</div>


															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-danger"
																	data-bs-dismiss="modal">Close</button>
																<button type="submit" class="btn btn-success">Save
																</button>
															</div>
															</form>
														</div>
													</div>
												</div>
												@endif
											</td>
										</tr>

										<!-- shareholders Document -->
										<tr>
											<td>Shareholders Document</td>
											@if(isset($data['shareholdersdoc']))
											<td>
												<img src="https://img.icons8.com/fluency/48/000000/checked.png" />
												@else
											<td>
												<img src="https://img.icons8.com/fluency/48/000000/cancel.png" />
											</td>
											@endif
											<td>
												@if(isset($data['shareholdersdoc']))

												@else
												<!-- Button trigger modal -->
												<button type="button" class="btn btn-primary" data-bs-toggle="modal"
													data-bs-target="#exampleModal6">
													Update
												</button>

												<!-- Modal -->
												<div class="modal fade" id="exampleModal6" tabindex="-1" role="dialog"
													aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">
																	Shareholders
																	Document</h5>
																<button type="button" class="close"
																	data-bs-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<form action="{{route('verify shareholder document')}}"
																	method="post" enctype="multipart/form-data">
																	@csrf
																	<div class="col-md-12">
																		<label>Kindly Upload Shareholders
																			Document</label>
																		<input type="file" name="shareholders_document"
																			class="form-control"
																			placeholder="kindly enter your bvn digits">
																	</div>


															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-danger"
																	data-bs-dismiss="modal">Close</button>
																<button type="submit" class="btn btn-success">Save
																</button>
															</div>
															</form>
														</div>
													</div>
												</div>
												@endif
											</td>
										</tr>
										@endif
									</tbody>
								</table>
							</div>
							<div class="col-md-12">
								@if(Auth::user()->country == 'Nigeria')
								@if($data['avatar'] != NULL && ($data['identitycard'] != NULL || $data['passport'] !=
								NULL ||
								$data['license'] != NULL) && $data['bill'] != NULL && $data['bvn'] != NULL &&
								($data['cacdocument'] != NULL || $data['directorsdoc'] != NULL ||
								$data['shareholdersdoc']
								!=
								NULL))
								<a href="{{route('home')}}" class="btn btn-primary form-control mt-2 mb-3">Continue</a>
								@endif
								@else
								@if($data['avatar'] != NULL && ($data['identitycard'] != NULL || $data['passport'] !=
								NULL ||
								$data['license'] != NULL) && $data['bill'] != NULL &&
								($data['cacdocument'] != NULL || $data['directorsdoc'] != NULL ||
								$data['shareholdersdoc']
								!=
								NULL))
								<a href="{{route('home')}}" class="btn btn-primary form-control mt-2 mb-3">Continue</a>
								@endif
								@endif
							</div>
						</div>


					</div> <!-- End -->

					<!-- review form -->

					<!-- ebd of reviews -->
				</div>
			</div>
		</div>

	</div>


	<script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>

	@include('include.message')


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"
		integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous">
	</script>
	<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

	<script src="{{ asset('pace/pace.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>



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