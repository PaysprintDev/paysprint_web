@extends('layouts.dashboard')

@section('dashContent')

<?php use \App\Http\Controllers\ConversionCountry; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Currency Conversion Rate
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Currency Conversion Rate</li>
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
                  <th>Currency</th>
                  <th>Rate/USD</th>
                  
                </tr>
                </thead>
                <tbody>

                    @if (isset($data['currencyrate']))
                    @php
                        $i = 1;
                        $mycountry = [];
                    @endphp
                        @foreach ($data['currencyrate']['quotes'] as $amount)


                            {{--  @foreach ($data['currencyrate']['currency'] as $currency)

                                
                                @php
                                    $mycountry []= "<tr><td>".$currency."</td></tr>";
                                @endphp
                                
                            @endforeach  --}}


                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>&nbsp;</td>
                                <td>{{ $amount }}</td>
                            </tr>

                        @endforeach

                            {{--  @for ($j = 1; $j <= count($mycountry); $j++)
                                @if (isset($mycountry[$j]))
                                    {!! $mycountry[$j] !!}
                                @endif
                            @endfor  --}}
                    @else
                        <tr>
                            <td colspan="3" align="center">No record</td>
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