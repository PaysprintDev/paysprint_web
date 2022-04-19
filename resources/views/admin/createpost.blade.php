@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\AddCard; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View Document
      </h1>
      <ol class="breadcrumb">
      <li><a href={{" route('Admin') "}}><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> View Document</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <br>
          <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
      <br>

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
                    <form action="{{ route('create investor posts') }}" method="POST">

                      @csrf

                        <legend>Investors Opportunity</legend>
                          <div class="col-12">
                            <label for="ref_code" class="form-label">Referrence Code</label>
                            <input type="number" class="form-control" name="ref_code" id="ref_code" aria-describedby="emailHelp">
                          </div>
                          <br>
                          <div class="col-12">
                            <label for="post_title" class="form-label">Post Title</label>
                            <input type="text" class="form-control" name="post_title" id="post_title">
                          </div>
                          <br>
                          <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea  type="summernote" class="form-control" name="description" id="description"></textarea>
                          </div><br>
                          <div class="col-md-6">
                            <label for="minimum_amount" class="form-label">Minimum Amount</label>
                            <input type="number" class="form-control" name="minimum_acount" id="minimum_amount">
                          </div>
                          <div class="col-md-6">
                            <label for="locked_in_return" class="form-label">Locked in Return (%)
                          </label>
                            <input type="text" class="form-control" name="locked_in_return" id="locked_in_return">
                          </div><br>
                          <div class="col-md-6">
                            <label for="term" class="form-label">Term</label>
                            <input type="text" class="form-control" name="term" id="term">
                          </div><br>
                          <div class="col-md-6">
                            <label for="liquidation_amount" class="form-label">Liquidation amount
                          </label>
                            <input type="number" class="form-control" name="liquidation_amouunt" id="liquidation_amount">
                          </div><br>
                          <div class="col-md-6">
                            <label for="offer_open_date" class="form-label">Offer Open Date
                          </label>
                            <input type="date" class="form-control" name="offer_open_date" id="offer_open_date">
                          </div><br>
                          <div class="col-md-6">
                            <label for="offer_end_date" class="form-label">Offer End Date
                          </label>
                            <input type="date" class="form-control" name="offer_end_date" id="offer_end_date">
                          </div><br><br>

                          <div class="col-12">
                            <label for="investment_ctivation_date" class="form-label">Investment Activation Date</label>
                            <input type="date" class="form-control" name="investment_activation_date" id="investment_ctivation_date">
                          </div><br>
                          <div class="col-12">
                            <label for="investment_document" class="form-label">Investment Document
                          </label>
                            <input type="file" class="form-control" name="investment_document" id="investment_document">
                          </div><br>
                          
                          <div class="col-md-4 ">
                            <input type="checkbox" class="form-check-input" id="activate_this_post">
                            <label class="form-check-label" for="activate_this_post">Activate This Post</label>
                          </div>
                          
                              <button type="submit" class="col-md-8 btn btn-primary">Submit</button> 
                        
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


