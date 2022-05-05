  <header class="main-header">
      <!-- Logo -->
      <a href="{{ route('Admin') }}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>P</b>S</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Pay</b>Sprint</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
              <span class="sr-only">Toggle navigation</span>
          </a>

          @php
              $usersName = strlen(session('firstname') . ' ' . session('lastname')) < 15 ? session('firstname') . ' ' . session('lastname') : substr(session('firstname') . ' ' . session('lastname'), 0, 15) . '***';
              $usersBusiness = strlen(session('businessname')) < 15 ? session('businessname') : substr(session('businessname'), 0, 15) . '***';
          @endphp

          <div class="navbar-custom-menu">



              <ul class="nav navbar-nav">
                  <!-- User Account: style can be found in dropdown.less -->
                  <li class="dropdown user user-menu">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg"
                              class="user-image" alt="User Image">
                          <span
                              class="hidden-xs">{{ session('businessname') != null ? $usersBusiness : $usersName }}</span>
                      </a>
                      <ul class="dropdown-menu">
                          <!-- User image -->
                          <li class="user-header">
                              <img src="https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg"
                                  class="img-circle" alt="User Image">

                              <p>
                                  {{ session('businessname') != null ? $usersBusiness : $usersName }}
                              </p>
                          </li>
                          <!-- Menu Footer-->
                          <li class="user-footer">
                              <div>
                                  <a href="#" class="btn btn-danger btn-flat" style="width: 100%"
                                      onclick="logout('{{ session('username') }}')">Sign out</a>
                              </div>
                          </li>
                      </ul>
                  </li>

              </ul>
          </div>
      </nav>
  </header>
