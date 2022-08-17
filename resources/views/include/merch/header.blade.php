      <!-- Page Header Start-->
      <div class="page-main-header">
          <div class="main-header-right row m-0">
              <div class="main-header-left">
                  {{-- <div class="logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt=""></a>
              </div> --}}
              <div class="logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid" src="https://res.cloudinary.com/paysprint/image/upload/v1650628016/assets/pay_sprint_black_horizotal_fwqo6q_ekpq1g.png" alt=""></a></div>
              <div class="dark-logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid" src=" https://res.cloudinary.com/paysprint/image/upload/v1650628016/assets/pay_sprint_black_horizotal_fwqo6q_ekpq1g.png" alt=""></a></div>
              <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle"> </i></div>
          </div>
          <div class="left-menu-header col">
              <ul>
                  <li>
                      <div class="row">
                          <div class="col-md-12">
                              <button class="btn btn-success " type="button"><i data-feather="bar-chart"></i> Total
                                  Referral: {{ isset($data['referral']) ? $data['referral'] : 0 }}
                              </button>
                          </div>
                          <div class="col-md-6">
                              <small>
                                  <a style="font-weight: 700; font-size: 10px; color: navy;" href="{{ route('referred details') }}">
                                      View More
                                  </a>
                              </small>
                          </div>
                      </div>

                  </li>


              </ul>

          </div>



          <div class="nav-right col pull-right right-menu p-0">
              <ul class="nav-menus">
                  <li class="onhover-dropdown p-0">
                      <div class="row">
                          <div class="col-md-12">
                              <button class="btn btn-success " type="button"><i data-feather="bar-chart"></i> Total
                                  Points: {{ isset($data['mypoints']) ? $data['mypoints']->points_acquired : 0 }}
                              </button>
                          </div>

                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <small>
                                  <a style="font-weight: 700; font-size: 10px; color: navy;" href="{{ route('consumer points') }}">
                                      Earned Points
                                  </a>
                              </small>
                          </div>
                          <div class="col-md-6">
                              <form action="{{ route('claim point') }}" method="POST" id="claimmypoint">
                                  @csrf
                                  <small><a type='button' href="javascript:void()" onclick="$('#claimmypoint').submit()" style="font-weight: 700; font-size: 10px; color: navy;">Redeem
                                          Points</a></small>

                              </form>
                          </div>
                      </div>

                  </li>

                  <!-- Refer and Earn -->


                  <!-- end of refer and earn -->




                  <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>

                  <li class="onhover-dropdown">
                      <div class="notification-box"><i data-feather="bell"></i><span class="dot-animated"></span>
                      </div>
                      <ul class="notification-dropdown onhover-show-div">
                          <li>
                              <p class="f-w-700 mb-0">Recent 5 Notifications<span class="pull-right badge badge-primary badge-pill">5</span></p>
                          </li>

                          @if (count($data['getfiveNotifications']) > 0)

                          @foreach ($data['getfiveNotifications'] as $notifications)
                          <li class="noti-primary" onclick="location.href='{{ route('notifications') }}'">
                              <div class="media">
                                  <span class="notification-bg bg-light-primary"><i data-feather="activity">
                                      </i></span>
                                  <div class="media-body">
                                      <p> {{ $notifications->activity }} </p>
                                      <span>{{ $notifications->created_at->diffForHumans() }}</span>
                                  </div>
                              </div>
                          </li>
                          @endforeach
                          @else
                          <li class="noti-primary">
                              <div class="media">
                                  <span class="notification-bg bg-light-primary"><i data-feather="activity">
                                      </i></span>
                                  <div class="media-body">
                                      <p>No new notification </p>
                                      <span>now</span>
                                  </div>
                              </div>
                          </li>
                          @endif




                      </ul>
                  </li>
                  {{-- <li>
                          <div class="mode"><i class="fa fa-moon-o"></i></div>
                      </li> --}}
                  {{-- <li class="onhover-dropdown">
          <i data-feather="message-square"></i>
          <ul class="chat-dropdown onhover-show-div">
            <li>
              <div class="media">
                <img class="img-fluid rounded-circle me-3" src=" {{ asset('assets/images/user/4.jpg') }}" alt="">
                  <div class="media-body">
                      <span>Ain Chavez</span>
                      <p class="f-12 light-font">Lorem Ipsum is simply dummy...</p>
                  </div>
                  <p class="f-12">32 mins ago</p>
          </div>
          </li>
          <li>
              <div class="media">
                  <img class="img-fluid rounded-circle me-3" src=" {{ asset('assets/images/user/1.jpg') }}" alt="">
                  <div class="media-body">
                      <span>Erica Hughes</span>
                      <p class="f-12 light-font">Lorem Ipsum is simply dummy...</p>
                  </div>
                  <p class="f-12">58 mins ago</p>
              </div>
          </li>
          <li>
              <div class="media">
                  <img class="img-fluid rounded-circle me-3" src=" {{ asset('assets/images/user/2.jpg') }}" alt="">
                  <div class="media-body">
                      <span>Kori Thomas</span>
                      <p class="f-12 light-font">Lorem Ipsum is simply dummy...</p>
                  </div>
                  <p class="f-12">1 hr ago</p>
              </div>
          </li>
          <li class="text-center"> <a class="f-w-700" href="javascript:void(0)">See All </a></li>
          </ul>
          </li> --}}
          <li class="onhover-dropdown p-0">

              <a type="button" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-primary-light"><i data-feather="log-out"></i> {{ __('Logout') }}</a>
          </li>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>

          </ul>
      </div>
      <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
      </div>
      </div>
      <!-- Page Header Ends -->

      <!-- Page Body Start-->
      <div class="page-body-wrapper sidebar-icon">