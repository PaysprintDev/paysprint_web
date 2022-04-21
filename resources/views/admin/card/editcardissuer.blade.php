@extends('layouts.dashboard')

@section('dashContent')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Card Issuer
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Card Issuer</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <br>
          <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
      <br>

      <!-- Default box -->
      <div class="box">
        
        <div class="box-body">

            @isset($data['getCardIssuer'])

            {{-- Provide Form --}}
            <form role="form" action="{{ route('edit card issuer', $data['getCardIssuer']->id) }}" method="POST">
                @csrf
                <div class="box-body">
                    
                    <div class="form-group has-success">
                        <label class="control-label" for="inputSuccess"> Issuer Name</label>
                        <input name="issuer_name" id="issuer_name" value="{{ $data['getCardIssuer']->issuer_name }}" class="form-control">
                    </div>
                    <div class="form-group has-success">
                        <label class="control-label" for="inputSuccess"> Issuer Card</label>
                        <input name="issuer_card" id="issuer_card" value="{{ $data['getCardIssuer']->issuer_card }}" class="form-control">
                    </div>

                </div>
                <!-- /.box-body -->
  
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary btn-block">Update</button>
                </div>
              </form>
                
            @endisset
          
            



              <hr>

              <div class="table-responsive">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S/N</th>
                  <th>Issuer Name</th>
                  <th>Issuer Card</th>
                  <th>Date Added</th>
                  <th>Last Updated</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                    @if (count($data['allIssuer']) > 0)
                    @php
                        $i = 1;
                    @endphp
                        @foreach ($data['allIssuer'] as $item)

                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->issuer_name }}</td>
                                <td>{{ $item->issuer_card }}</td>
                                <td>{{ date('d/M/Y', strtotime($item->created_at)) }}</td>
                                <td>{{ date('d/M/Y', strtotime($item->updated_at)) }}</td>
                                <td><a href="{{ route('editcardissuer', $item->id) }}" style="color: navy; font-weight: bold;">Edit</a> | <form action="{{ route('deletecardissuer', $item->id) }}" method="POST" id="deletecardissuer" class="disp-0">@csrf</form> <a href="#" style="color: red; font-weight: bold;" onclick="del('deletecardissuer')">Delete</a></td>
                            </tr>
                            
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" align="center">No record</td>
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