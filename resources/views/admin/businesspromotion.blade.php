@extends('layouts.dashboard')

@section('dashContent')

<?php use \App\Http\Controllers\ConversionCountry; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Business Promotion
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Business Promotion</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        
        <div class="box-body">
          
              <div class="table-responsive">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S/N</th>
                  <th>Industry</th>
                  <th>Contact Info</th>
                  <th>Nature of Business</th>
                  <th>Description</th>
                  <th>Name of Firm</th>
                  <th>Location</th>
                  <th>Website</th>
                  <th>Action</th>
                  <th>&nbsp;</th>
                  
                </tr>
                </thead>
                <tbody>

                    @if (isset($data['businesspromote']))
                    @php
                        $i = 1;
                    @endphp

                        @foreach ($data['businesspromote'] as $result)


                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $result->industry }}</td>
                                <td>{!! "<b>Email:</b> ".$result->email." <br><br> <b>Tel:</b> ".$result->telephone !!}</td>
                                <td>{{ $result->nature_of_business }}</td>
                                <td>{!! $result->description !!}</td>
                                <td>{{ $result->business_name }}</td>
                                <td>{{ $result->country }}</td>
                                <td>{!! ($result->website != null) ? '<a href="http://'.$result->website.'" target="_blank">Visit website</a>' : '-' !!}</td>
                                <td>
                                    <button class="btn btn-danger" id="Remove{{ $result->id }}" onclick="promotionAction('Remove', {{ $result->id }})">Remove</button>
                                </td>
                                <td>
                                    @if ($result->push_notification == 1)
                                        <button class="btn btn-primary" id="Broadcast{{ $result->id }}" onclick="promotionAction('Broadcast', {{ $result->id }})">Broadcast</button>
                                    @else
                                        <button class="btn btn-primary" disabled>Broadcast</button>
                                    @endif
                                    
                                </td>
                            </tr>

                        @endforeach
                           
                    @else
                        <tr>
                            <td colspan="10" align="center">No record</td>
                        </tr>
                    @endif
                  
                  
                      
                  
                </tbody>
              </table>

            </div>

        </div>
        <!-- /.box-body -->
        
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection