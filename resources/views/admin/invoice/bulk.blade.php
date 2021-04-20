@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Create and Send Invoice
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create and Send Invoice</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        
        <div class="box-body">
          
            {{-- Provide Form --}}
            <form action="#" method="POST" id="formElem" enctype="multipart/form-data">
                @csrf
                    <h1>STEP 1:</h1>
                    <!-- /.box-header -->
            <div class="box-body">
              <div class="alert alert-danger responseMessage disp-0"></div>
            <div class="row">
                <div class="col-md-12">
                    <p style="color: red; font-weight:bold; text-transform:uppercase">Click on Image to download and view sample</p>
                    <a href="{{ asset('downloadsample/testsample.xlsx') }}" target="_blank" download=""><img src="{{ asset('images/testformat.png') }}" alt="" style="width: 100%"/></a>
                </div>
            </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="service">Type of Service</label>
                            <select name="service" class="form-control" id="service">
                                @if (count($data['getServiceType']) > 0)
                                    @foreach ($data['getServiceType'] as $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                @else
                                <option value="">Create Service Type</option>
                                    
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="service">Accept Installmental Payment</label>
                            <select name="installpay" class="form-control" id="installpay">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row instlim disp-0">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="single_service">Kindly Set Installmental Limt</label>
                            <select name="installlimit" class="form-control" id="installlimit">
                                <option value="0">Select limit</option>
                                  @for($i=1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                  @endfor
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="event_file">Upload File</label>
                            <input type="file" id="excel_file" name="excel_file" class="form-control">

                            <small class="help-block text-primary" style="color: darkblue;">We recommend uploading excel (xls or xlsx) format.</small>
                        </div>
                        </div>
                    </div>
            <!-- /.row -->
            </div>

                           <h1>STEP 2:</h1>
<div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="service">Recurring</label>
                            <select name="recurring_service" class="form-control" id="recurring_service">
                                <option value="One Time">One Time</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Bi-Monthly">Bi-Monthly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Quaterly">Quaterly</option>
                                <option value="Half Yearly"> Half Yearly</option>
                                <option value="Yearly"> Yearly</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row recuring_time_2 disp-0">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="service">Reminder</label>
                            <select name="reminder_service" class="form-control" id="reminder_service">
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}">{{ $i }} Day(s)</option>
                                @endfor

                            </select>
                        </div>
                    </div>
                </div>
                <br>

                </form>
            <!-- /.row -->
            </div>


  
                <div class="box-footer">
                  <button type="button" class="btn btn-primary btn-block" onclick="handShake('bulkinvoice')" id="cardSubmit">Submit</button>
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