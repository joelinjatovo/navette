<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="/favicon.png"/>
    @yield('stylesheet')

</head>

<body>
  <nav class="navbar navbar-expand-lg py-0 navbar-dark" style="background-color: #0bb783bd;">
      <div class="container">
        <a class="navbar-brand px-1 py-1 my-0 mx-0" href="#"><img src="/img/logo-white.png" class="header-logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07">
          <ul class="navbar-nav ml-auto mr-0">
            @auth
            <li class="nav-item dropdown">
              <p aria-haspopup="true" class="small text-white nav-link"><i class="far fa-user"></i>&nbsp;Mon compte</p>
              <ul class="dropdown" aria-label="submenu">
                <li><i class="fas fa-tachometer-alt"></i>&nbsp;<a class="text-white small mb-2" href="/customer">Panel</a></li>
                <li><i class="fas fa-sign-out-alt"></i>&nbsp;<a class="text-white small mb-2" href="{{ route('logout') }}">Déconnexion</a></li>
              </ul>
            </li>
            @endauth
            <li class="nav-item">
              <a class="nav-link small text-white" href="#"><i class="fas fa-envelope"></i>&nbsp;contact@navetteclub.com</a>
            </li>
            <li class="nav-item">
              <a class="nav-link small text-white" href="#"><i class="fa fa-phone"></i>&nbsp;+33 1 23 45 67 89</a>
            </li>
            <li class="nav-item">
              <a class="nav-link small text-white" href="#"><i class="fas fa-clock"></i>&nbsp;07h30 - 20h30</a>
            </li>
            
          </ul>
        </div>
      </div>
    </nav>

<div class="main" style="background-image: url('{{ asset('img') }}/video_bg.jpg')">
        <video id="video_background" preload="auto" autoplay="true" loop="loop" muted="muted" volume="0"> 
            <source src="{{ asset('img') }}/video-bg.webm" type="video/webm"> 
            <source src="{{ asset('img') }}/video-bg.mp4" type="video/mp4"> 
            Video not supported 
        </video>
    
    <div class="cover black" data-color="black"></div>

    @yield('content')

    <div class="footer" style="text-align:center;">
      <div class="container">
      <div class="row">
        <div class="col-md-6">
          <small>Suivez-nous sur notre <a href="#">page&nbsp;<i class="fab fa-facebook-f"></i>acebook</a></small>
        </div>
        <div class="col-md-6">
          <small>Création de L&M - tous droits réservés &copy; {{ date('Y') }}</small>
        </div>
      </div>
             
      </div>
    </div>
 </div>
</body>
</html>
