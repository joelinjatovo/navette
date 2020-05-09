<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('user_panel/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('user_panel/img/favicon.png') }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Navette Club | Tableau de bord Utilisateur
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <link rel="stylesheet" type="text/css" href="{{ asset('user_panel/css/css.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('user_panel/lib/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('user_panel/css/jpreloader.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('user_panel/css/all.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('user_panel/css/material-dashboard.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/material-demo.css') }}" />
</head>

<body class="dark-edition">
  <!-- This section is for Splash Screen -->
<section id="jSplash">
  <section class="selected">
    <img class="img" src="{{ asset('user_panel/img/preload.jpg') }}" />
    <h3>Bienvenue sur votre Panel</h3>
  </section>
</section>
<!-- End of Splash Screen -->
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="black" data-image="{{ asset('user_panel/img/sidebar-2.jpg') }}">

      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          Navette Club
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item {{ Route::is('customer.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('customer.dashboard') }}">
              <i class="material-icons">{{ __('messages.dashboard') }}</i>
              <p>{{ __('messages.dashboard') }}</p>
            </a>
          </li>
          <li class="nav-item {{ Route::is('customer.order*') ? 'active' : '' }} ">
              <a class="nav-link" data-toggle="collapse" href="#orders" {{ Route::is('customer.order*') ? 'aria-expanded="true"' : '' }}>
                <i class="material-icons"></i>
                <p>{{ __('messages.orders') }}<b class="caret"></b></p>
              </a>
              <div class="collapse {{ Route::is('customer.order*') ? 'show' : '' }}" id="orders">
                <ul class="nav">
                  <li class="nav-item {{ Route::is('customer.orders') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('customer.orders') }}">
                      <span class="sidebar-mini"> P </span>
                      <span class="sidebar-normal">{{ __('messages.list') }}</span>
                    </a>
                  </li>
                  <li class="nav-item {{ Route::is('customer.order.create') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('customer.order.create') }}">
                      <span class="sidebar-mini"> A </span>
                      <span class="sidebar-normal">{{ __('messages.order.create') }}</span>
                    </a>
                  </li>
                </ul>
              </div>
          </li>
          <li class="nav-item  @if(isset($active_profile)) {{ _('active') }} @endif">
            <a class="nav-link" href="/user/mon-profil">
              <i class="material-icons">person</i>
              <p>Mon profil</p>
            </a>
          </li>
          <li class="nav-item  @if(isset($active_my_rides)) {{ _('active') }} @endif">
            <a class="nav-link" href="/user/historiques">
              <i class="material-icons">access_time</i>
              <p>Historiques</p>
            </a>
          </li>
          <li class="nav-item  @if(isset($active_new_ride)) {{ _('active') }} @endif">
            <a class="nav-link" href="/user/reservation">
              <i class="material-icons">add_to_photos</i>
              <p>Réservation</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="/logout">
              <i class="material-icons">power_settings_new</i>
              <p>Déconnexion</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top " id="navigation-example">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation" data-target="#navigation-example">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link" href="javscript:void(0)" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">notifications</i>
                  <span class="notification">5</span>
                  <p class="d-lg-none d-md-block">
                    notification(s)
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="javascript:void(0)">Mike John responded to your email</a>
                  <a class="dropdown-item" href="javascript:void(0)">You have 5 new tasks</a>
                  <a class="dropdown-item" href="javascript:void(0)">You're now friend with Andrew</a>
                  <a class="dropdown-item" href="javascript:void(0)">Another Notification</a>
                  <a class="dropdown-item" href="javascript:void(0)">Another One</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->

      <div class="content">
        <div class="container-fluid">
          @yield('content')
        </div>
      </div>

      <footer class="footer">
        <div class="container-fluid">
          <nav class="float-left">
            <ul>
              <li>
                <a href="https://www.creative-tim.com">
                  Creative Tim
                </a>
              </li>
              <li>
                <a href="https://creative-tim.com/presentation">
                  About Us
                </a>
              </li>
              <li>
                <a href="http://blog.creative-tim.com">
                  Blog
                </a>
              </li>
              <li>
                <a href="https://www.creative-tim.com/license">
                  Licenses
                </a>
              </li>
            </ul>
          </nav>
          <div class="copyright float-right" id="date">
            , made with <i class="material-icons">favorite</i> by
            <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a> for a better web.
          </div>
        </div>
      </footer>
      <script>
        const x = new Date().getFullYear();
        let date = document.getElementById('date');
        date.innerHTML = '&copy; ' + x + date.innerHTML;
      </script>
    </div>
  </div>
  
  @section('javascript')
  <script src="{{ asset('user_panel/js/jquery-2.2.0.js') }}"></script>
  <script src="{{ asset('user_panel/lib/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('user_panel/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('user_panel/js/core/bootstrap-material-design.min.js') }}"></script>
  <script src="{{ asset('/js/plugins/bootstrap-selectpicker.js') }}"></script>
  <script src="{{ asset('user_panel/js/material-dashboard.js?v=2.1.0') }}"></script>
  <script src="{{ asset('user_panel/js/jpreloader.min.js') }}"></script>
  <script src="{{ asset('user_panel/js/loader.js') }}"></script>
  @show
</body>

</html>