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

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('images/payca.png') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ session('firstname').' '.session('lastname') }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('images/payca.png') }}" class="img-circle" alt="User Image">

                <p>
                  {{ session('firstname').' '.session('lastname') }}
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div>
                  <a href="#" class="btn btn-danger btn-flat" style="width: 100%" onclick="logout('{{ session('username') }}')">Sign out</a>
                </div>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </nav>
  </header>