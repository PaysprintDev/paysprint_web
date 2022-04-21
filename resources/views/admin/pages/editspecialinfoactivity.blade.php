@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Special Information
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Special Information</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        
        <div class="box-body">
          
            {{-- Provide Form --}}
            <form role="form" action="{{ route('create special information') }}" method="POST">
                @csrf
                <div class="box-body">
                    <div class="form-group has-success">
                        <label class="control-label" for="inputSuccess"> Country</label>
                        <select name="country" id="country" class="form-control" required>
                            <option value="{{ $data['activity']->country }}" selected>{{ $data['activity']->country }}</option>
                        </select>
                        {{-- <input type="text" class="form-control" name="name" id="inputSuccess" placeholder="E.g Belt Work"> --}}
                    </div>
                    

                    <div class="form-group has-success">
                        <label class="control-label" for="inputSuccess"> Information</label>

                        <textarea name="information" id="information" cols="30" rows="10" class="form-control">{{ $data['activity']->information }}</textarea>

                    </div>


                </div>
                <!-- /.box-body -->
  
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary btn-block">Submit and Save</button>
                </div>
              </form>



              {{-- List Categories --}}
              <hr>

        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection