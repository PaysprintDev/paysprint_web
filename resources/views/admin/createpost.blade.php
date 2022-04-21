@extends('layouts.dashboard')

@section('dashContent')
    <?php use App\Http\Controllers\User; ?>
    <?php use App\Http\Controllers\AddCard; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                View Document
            </h1>
            <ol class="breadcrumb">
                <li><a href={{ " route('Admin') " }}><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"> View Document</li>
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
                                    <form action="{{ route('create investor posts') }}" method="POST"
                                        enctype="multipart/form-data">

                                        @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <legend>Investors Opportunity</legend>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <label for="reference_code" class="form-label">Reference Code:</label>
                                                <input type="number" name="reference_code" class="form-control"
                                                    id="reference_code">
                                            </div>
                                            <br>
                                            <div class="col-12 mt-2 mb-2">
                                                <label for="post_title" class="form-label">Post Title:</label>
                                                <input type="text" name="post_title" class="form-control" id="post_title">
                                            </div>
                                            <div class="col-12 mt-2 mb-2">
                                                <label for="description" class="form-label">Description:</label>
                                                <textarea name="description" class="form-control summernote" id="description"></textarea>
                                            </div>
                                            <div class="col-6 mt-3">
                                                <label for="amount" class="form-label">Minimum Amount</label>
                                                <br>
                                                <input type="number" name="minimum_amount" class="form_control"
                                                    id="amount">
                                            </div>
                                            <div class="col-6 mt-3">
                                                <label for="locked_return" class="form-label">Locked in Return
                                                    (%)</label><br>
                                                <input type="text" name="locked_return" class="form_control"
                                                    id="locked_return">
                                            </div>
                                            <div class="col-6 ">
                                                <label for="term" class="form-label">Term</label>
                                                <input type="text" class="form-control" name="term" id="term">
                                            </div><br>
                                            <div class="col-6">
                                                <label for="liquidation_amount" class="form-label">Liquidation
                                                    amount
                                                </label>
                                                <input type="number" class="form-control" name="liquidation_amouunt"
                                                    id="liquidation_amount">
                                            </div><br>
                                            <div class="col-md-6">
                                                <label for="offer_open_date" class="form-label">Offer Open Date
                                                </label>
                                                <input type="date" class="form-control" name="offer_open_date"
                                                    id="offer_open_date">
                                            </div><br>
                                            <div class="col-md-6">
                                                <label for="offer_end_date" class="form-label">Offer End Date
                                                </label>
                                                <input type="date" class="form-control" name="offer_end_date"
                                                    id="offer_end_date">
                                            </div><br><br>

                                            <div class="col-12">
                                                <label for="investment_ctivation_date" class="form-label">Investment
                                                    Activation Date</label>
                                                <input type="date" class="form-control" name="investment_activation_date"
                                                    id="investment_ctivation_date">
                                            </div><br>
                                            <div class="col-12">
                                                <label for="investment_document" class="form-label">Investment
                                                    Document
                                                </label>
                                                <input type="file" class="form-control" name="investment_document"
                                                    id="investment_document">
                                            </div><br>

                                            <div class="col-md-4 ">
                                                <input type="checkbox" class="form-check-input" id="activate_this_post"
                                                    name="activate_post">
                                                <label class="form-check-label" for="activate_this_post">Activate This
                                                    Post</label>
                                            </div>
                                            <div class="">
                                                <button type="submit"
                                                    class="col-md-8 btn btn-primary form-control">Submit</button>
                                                <div>
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
