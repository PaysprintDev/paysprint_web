@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Invoice Comment
        <small>Invoice Comment</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Invoice Comment</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        
        <div class="box-body">
          
            {{-- Provide Form --}}
            <form role="form" action="{{ route('my invoice comment', $invoiceImport->id) }}" method="POST">
                @csrf
                <div class="box-body">
                    
                    <div class="form-group has-success">
                        <label class="control-label" for="payment_method"> Payment Platform</label>
                        <input type="text" name="payment_method" id="payment_method" class="form-control" placeholder="E.g Zoho" required>

                    </div>
                    <div class="form-group has-success">
                        <label class="control-label" for="comment"> Comment</label>
                        
                        <textarea name="comment" id="comment" cols="30" rows="10" class="form-control" placeholder="Please provide your comment here" required></textarea>

                    </div>


                </div>
                <!-- /.box-body -->
  
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </div>
              </form>

        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection