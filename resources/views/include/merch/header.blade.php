      <!-- Page Header Start-->
      <div class="page-main-header">
          <div class="main-header-right row m-0">
              <div class="main-header-left">
                  {{-- <div class="logo-wrapper"><a href="dashboard.html"><img class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt=""></a></div> --}}
                  <div class="logo-wrapper"><a href="dashboard.html"><img class="img-fluid"
                              src="https://res.cloudinary.com/pilstech/image/upload/v1603726392/pay_sprint_black_horizotal_fwqo6q.png"
                              alt=""></a></div>
                  <div class="dark-logo-wrapper"><a href="dashboard.html"><img class="img-fluid"
                              src=" https://res.cloudinary.com/pilstech/image/upload/v1603726392/pay_sprint_black_horizotal_fwqo6q.png"
                              alt=""></a></div>
                  <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center"
                          id="sidebar-toggle"> </i></div>
              </div>
              <div class="left-menu-header col">
                  <ul>
                      <li>
                          <form class="form-inline search-form">
                              <div class="search-bg"><i class="fa fa-search"></i>
                                  <input class="form-control-plaintext" placeholder="Search here.....">
                              </div>
                          </form>
                          <span class="d-sm-none mobile-search search-bg"><i class="fa fa-search"></i></span>
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
                                      <a style="font-weight: 700; font-size: 10px; color: navy;"
                                          href="{{ route('consumer points') }}">
                                          Earned Points
                                      </a>
                                  </small>
                              </div>
                              <div class="col-md-6">
                                  <form action="{{ route('claim point') }}" method="POST" id="claimmypoint">
                                      @csrf
                                      <small><a type='button' href="javascript:void()"
                                              onclick="$('#claimmypoint').submit()"
                                              style="font-weight: 700; font-size: 10px; color: navy;">Redeem
                                              Points</a></small>

                                  </form>
                              </div>
                          </div>
                      </li>




                      <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i
                                  data-feather="maximize"></i></a></li>

                      <li class="onhover-dropdown">
                          <div class="notification-box"><i data-feather="bell"></i><span class="dot-animated"></span>
                          </div>
                          <ul class="notification-dropdown onhover-show-div">
                              <li>
                                  <p class="f-w-700 mb-0">You have 3 Notifications<span
                                          class="pull-right badge badge-primary badge-pill">4</span></p>
                              </li>
                              <li class="noti-primary">
                                  <div class="media">
                                      <span class="notification-bg bg-light-primary"><i data-feather="activity">
                                          </i></span>
                                      <div class="media-body">
                                          <p>Delivery processing </p>
                                          <span>10 minutes ago</span>
                                      </div>
                                  </div>
                              </li>
                              <li class="noti-secondary">
                                  <div class="media">
                                      <span class="notification-bg bg-light-secondary"><i data-feather="check-circle">
                                          </i></span>
                                      <div class="media-body">
                                          <p>Order Complete</p>
                                          <span>1 hour ago</span>
                                      </div>
                                  </div>
                              </li>
                              <li class="noti-success">
                                  <div class="media">
                                      <span class="notification-bg bg-light-success"><i data-feather="file-text">
                                          </i></span>
                                      <div class="media-body">
                                          <p>Tickets Generated</p>
                                          <span>3 hour ago</span>
                                      </div>
                                  </div>
                              </li>
                              <li class="noti-danger">
                                  <div class="media">
                                      <span class="notification-bg bg-light-danger"><i data-feather="user-check">
                                          </i></span>
                                      <div class="media-body">
                                          <p>Delivery Complete</p>
                                          <span>6 hour ago</span>
                                      </div>
                                  </div>
                              </li>
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
            <li class="text-center"> <a class="f-w-700" href="javascript:void(0)">See All     </a></li>
          </ul>
        </li> --}}
                      <li class="onhover-dropdown p-0">
                          <button class="btn btn-primary-light" type="button"><i data-feather="log-out"></i>Log
                              out</button>
                      </li>
                  </ul>
              </div>
              <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
          </div>
      </div>
      <!-- Page Header Ends -->

      <!-- Page Body Start-->
      <div class="page-body-wrapper sidebar-icon">