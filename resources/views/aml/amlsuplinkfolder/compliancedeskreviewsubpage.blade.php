@extends('layouts.dashboard')

@section('dashContent')


<?php use \App\Http\Controllers\User; ?>
<?php use \App\Http\Controllers\client_info; ?>
<?php use \App\Http\Controllers\AddCard; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Compliance Desk Review
      </h1>
      <ol class="breadcrumb">
      <li><a href="{{ route('Admin') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Compliance Desk Review</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <br>
          <button class="btn btn-secondary btn-block bg-red" onclick="goBack()"><i class="fas fa-chevron-left"></i> Go back</button>
      <br>

      <div class="row">
        @if(isset($data['users']->ref_code))
        
        <div class="col-xs-12">
          <div class="box">

            <div class="box-body">
                  <div class="col-md-6">
                    <label for="inputEmail4"  class="form-label">Name:</label> {{ $data['users']->name }}
                    
                  </div>
                  <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Phone:</label> {{ $data['users']->telephone }}
                    
                  </div>
                  <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Email:</label> {{ $data['users']->email }}
                    
                  </div>
                  <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Acount Type:</label> {{ $data['users']->accountType }}
                    
                  </div>

                  <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>&nbsp;</h3>
                
                
                            <p>Profile Information</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('user more detail', $data['users']->id)}}" class="small-box-footer">View details <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-aqua">
                      <div class="inner">
                        <h3>&nbsp;</h3>
                          
              
              
                          <p> View Document</p>
                      </div>
                      <div class="icon">
                          <i class="ion ion-stats-bars"></i>
                      </div>
                      <a href="{{ route('viewdocument',  'search='.$data['users']->ref_code) }}" class="small-box-footer">View details <i
                              class="fa fa-arrow-circle-right"></i></a>
                  </div>
              </div>

              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>&nbsp;</h3>
            
            
                        <p>View KYC/KYB Report</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('viewkyckybreport', 'search='.$data['users']->ref_code) }}" class="small-box-footer">View details <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                  <div class="inner">
                      <h3>&nbsp;</h3>
          
          
                      <p>View Compliance Information</p>
                  </div>
                  <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="{{ route('viewcomplianceinformation', 'search='.$data['users']->ref_code) }}" method="GET" class="small-box-footer">View details <i
                          class="fa fa-arrow-circle-right"></i></a>
              </div>
          </div>
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>&nbsp;</h3>
        
        
                    <p>View Industry</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('viewindustry', 'search='.$data['users']->ref_code) }}"  class="small-box-footer">View details <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
              <div class="inner">
                  <h3>&nbsp;</h3>
      
      
                  <p>Linked Account</p>
              </div>
              <div class="icon">
                  <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{ route('linkedaccount', 'search='.$data['users']->ref_code) }}" class="small-box-footer">View details <i
                      class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>&nbsp;</h3>
            
            
                        <p>Connected Accounts</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('connectedaccounts', 'search='.$data['users']->name) }}" class="small-box-footer">View details <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
             
            @else
            <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <td colspan="9" text-align="center">
                    No record available
                  </td>
                </div>
              </div>
            </div>
            @endif

           

                                                     
                   

                   
           
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


