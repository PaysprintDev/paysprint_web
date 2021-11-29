@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\AnonUsers; ?>
<?php use \App\Http\Controllers\Statement; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Text-To-Transfer
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Text-To-Transfer</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="row">
                <div class="col-md-2 col-md-offset-0">
                <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
            </div>
            </div>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table table-responsive">

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
                <tr>
                  <th>S/N</th>
                  <th>Sender Details</th>
                  <th>Amount Sent</th>
                  <th>Receiver Details</th>
                  <th>Transfer Date</th>
                </tr>
                </thead>
                <tbody>

                  @if($affected = \App\Statement::where('status', 'Pending')->where('credit', '>', 0)->where('country', Request::get('country'))->get())


                      @php
                        $anonname = "-";
                        $anonref_code = "-";
                        $anontelephone = "-";
                        $anonid = "-";


                        $username = "-";
                        $ref_code = "-";
                        $city = "-";
                        $state = "-";
                        $id = "-";

                    @endphp

                      @if (count($affected) > 0)
                        @php
                            $i = 1;
                        @endphp
                        @foreach($affected as $data)
                            <tr>
                                <td>{{ $i++ }}</td>

                                @if($currency = \App\User::where('country', $data->country)->first())
                                    @php
                                        $currencyCode = $currency->currencyCode;
                                        $currencySymbol = $currency->currencySymbol;
                                    @endphp
                                @endif

                                @if($user = \App\User::where('email', $data->user_id)->first())

                                    @if (isset($user))
                                        @php
                                            $username = $user->name;
                                            $ref_code = $user->ref_code;
                                            $city = $user->city;
                                            $state = $user->state;
                                            $id = $user->id;
                                        @endphp
                                        
                                    @endif

                                    

                                @endif

                                @if($anon = \App\AnonUsers::where('email', $data->user_id)->first())
                                        @php
                                            $anonname = $anon->name;
                                            $anonref_code = $anon->ref_code;
                                            $anontelephone = $anon->telephone;
                                            $anonid = $anon->id;
                                        @endphp
                                @endif

                                <td>
                                  Account Number: {{ $ref_code }} <br>
                                  Name: {{ $username }} <br>
                                  City: {{ $city }} <br>
                                  State: {{ $state }} <br>
                                  <a href="{{ route('user more detail', $id) }}" target="_blank" class="btn btn-primary">View more</a>
                                </td>

                                <td>{{ ($data->credit > 0) ? $currencySymbol.' '.number_format($data->credit, 2) : $currencySymbol.' '.number_format($data->debit, 2) }}</td>


                                <td>
                                  Account Number: {{ $anonref_code }} <br>
                                  Name: {{ $anonname }} <br>
                                  Telephone: {{ $anontelephone }} <br>
                                </td>


                                <td>
                                    {{ date('d/M/Y', strtotime($data->trans_date)) }}
                                </td>

                                
                            </tr>
                        @endforeach

                      @else
                        <tr>
                            <td colspan="5" align="center">No record available</td>
                        </tr>
                      @endif


                  @endif

                    
                </tbody>
              </table>
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


