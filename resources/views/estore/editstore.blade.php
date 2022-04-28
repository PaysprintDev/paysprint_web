@extends('layouts.dashboard')

@section('dashContent')
    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\Admin; ?>
    <?php use App\Http\Controllers\OrganizationPay; ?>
    <?php use App\Http\Controllers\ClientInfo; ?>
    <?php use App\Http\Controllers\AnonUsers; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Edit E-Store
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"> Edit E-Store</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            {!! session('msg') !!}
                            <h3 class="box-title"> Edit E-Store</h3>
                            <form action="{{ route('update store', $data['store']->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Business Logo</label>
                                        <img src='{{ asset($data['store']->businessLogo) }}' />
                                        <input type="file" name="businessLogo" value="<img src='{{ asset($data['store']->businessLogo) }}' />" class="form-control">
                                        <p>Upload the business logo of the store.</p>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label>Header Content Image</label>
                                        <img src='{{ asset($data['store']->headerContent) }}' />
                                        <input type="file" name="headerContent[]" value="<img src='{{ asset($data['store']->headerContent) }}' />"  class="form-control" multiple>
                                        <p>Upload the header content of the shop. MAX 3 pictures will be uploaded</p>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label>Header Title Text</label>
                                        <input type="text" name="headerTitle" value="{{ $data['store']->headerTitle}}" class="form-control" placeholder="Enter header title">
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label>Header Sub-Title Text</label>
                                        <input type="text" name="headerSubtitle" value="{{ $data['store']->headerSubtitle}}" class="form-control" placeholder="Enter header sub-title">
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label>Advert Section Image</label>
                                        <input type="file" name="advertimage[]" value="{{ $data['store']->advertSectionImage}}" class="form-control" placeholder="Enter header title" multiple>
                                        <p>Upload the advert section image for the shop. MAX 3 pictures will be uploaded</p>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label>Advert Title Text</label>
                                        <input type="text" name="advertTitle" value="{{ $data['store']->advertTitle}}" class="form-control" placeholder="Enter advert title">
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label>Advert Sub-title Text</label>
                                        <input type="text" name="advertSubtitle" value="{{ $data['store']->advertSubtitle}}" class="form-control" placeholder="Enter advert sub_title">
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label>Return and Refund Policy</label>
                                       <textarea class="form-control" name="refundpolicy">{{ $data['store']->refundPolicy}}</textarea>
                                       <p>Here is to assertain your customers of your return and refund policy</p>
                                    </div>
                                    <button class="btn btn-success mt-4 form-control" type="submit">Update Store</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table table-responsive">
                           
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
