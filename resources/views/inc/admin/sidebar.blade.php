<!--
Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

Tip 2: you can also add an image using data-image tag
-->
<div class="logo"><a href="http://www.creative-tim.com" class="simple-text logo-mini">
    CT
  </a>
  <a href="http://www.creative-tim.com" class="simple-text logo-normal">
    Creative Tim
  </a>
</div>
<div class="sidebar-wrapper">
  @auth
  <div class="user">
    <div class="photo">
      <img src="{{ auth()->user()->image ? url(auth()->user()->image->url) : asset('/img/faces/avatar.jpg') }}" />
    </div>
    <div class="user-info">
      <a data-toggle="collapse" href="#collapseExample" class="username">
        <span>
          {{ auth()->user()->name }}
          <b class="caret"></b>
        </span>
      </a>
      <div class="collapse" id="collapseExample">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span class="sidebar-mini"> MP </span>
              <span class="sidebar-normal"> My Profile </span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span class="sidebar-mini"> EP </span>
              <span class="sidebar-normal"> Edit Profile </span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span class="sidebar-mini"> S </span>
              <span class="sidebar-normal"> Settings </span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  @endauth
  <ul class="nav">
    <li class="nav-item {{ Route::is('admin.dashboard') ? 'active' : '' }} ">
      <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="material-icons">dashboard</i>
        <p>{{ __('messages.dashboard') }}</p>
      </a>
    </li>
    <li class="nav-item {{ Route::is('admin.user*') ? 'active' : '' }} ">
      <a class="nav-link" data-toggle="collapse" href="#users" {{ Route::is('admin.user*') ? 'aria-expanded="true"' : '' }}>
        <i class="material-icons"></i>
        <p>{{ __('messages.users') }}<b class="caret"></b></p>
      </a>
      <div class="collapse {{ Route::is('admin.user*') ? 'show' : '' }}" id="users">
        <ul class="nav">
          <li class="nav-item {{ Route::is('admin.users') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.users') }}">
              <span class="sidebar-mini"> P </span>
              <span class="sidebar-normal">{{ __('messages.list') }}</span>
            </a>
          </li>
          <li class="nav-item {{ Route::is('admin.user.create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.user.create') }}">
              <span class="sidebar-mini"> A </span>
              <span class="sidebar-normal">{{ __('messages.user.create') }}</span>
            </a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item {{ Route::is('admin.club*') ? 'active' : '' }} ">
      <a class="nav-link" data-toggle="collapse" href="#clubs" {{ Route::is('admin.club*') ? 'aria-expanded="true"' : '' }}>
        <i class="material-icons"></i>
        <p>{{ __('messages.clubs') }}<b class="caret"></b></p>
      </a>
      <div class="collapse {{ Route::is('admin.club*') ? 'show' : '' }}" id="clubs">
        <ul class="nav">
          <li class="nav-item {{ Route::is('admin.clubs') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.clubs') }}">
              <span class="sidebar-mini"> P </span>
              <span class="sidebar-normal">{{ __('messages.list') }}</span>
            </a>
          </li>
          <li class="nav-item {{ Route::is('admin.club.create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.club.create') }}">
              <span class="sidebar-mini"> A </span>
              <span class="sidebar-normal">{{ __('messages.club.create') }}</span>
            </a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item {{ Route::is('admin.car*') ? 'active' : '' }} ">
      <a class="nav-link" data-toggle="collapse" href="#cars" {{ Route::is('admin.car*') ? 'aria-expanded="true"' : '' }}>
        <i class="material-icons"></i>
        <p>{{ __('messages.cars') }}<b class="caret"></b></p>
      </a>
      <div class="collapse {{ Route::is('admin.car*') ? 'show' : '' }}" id="cars">
        <ul class="nav">
          <li class="nav-item {{ Route::is('admin.cars') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.cars') }}">
              <span class="sidebar-mini"> P </span>
              <span class="sidebar-normal">{{ __('messages.list') }}</span>
            </a>
          </li>
          <li class="nav-item {{ Route::is('admin.car.create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.car.create') }}">
              <span class="sidebar-mini"> A </span>
              <span class="sidebar-normal">{{ __('messages.car.create') }}</span>
            </a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item {{ Route::is('admin.order*') ? 'active' : '' }} ">
      <a class="nav-link" data-toggle="collapse" href="#orders" {{ Route::is('admin.order*') ? 'aria-expanded="true"' : '' }}>
        <i class="material-icons"></i>
        <p>{{ __('messages.orders') }}<b class="caret"></b></p>
      </a>
      <div class="collapse {{ Route::is('admin.order*') ? 'show' : '' }}" id="orders">
        <ul class="nav">
          <li class="nav-item {{ Route::is('admin.orders') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.orders') }}">
              <span class="sidebar-mini"> P </span>
              <span class="sidebar-normal">{{ __('messages.list') }}</span>
            </a>
          </li>
          <li class="nav-item {{ Route::is('admin.order.create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.order.create') }}">
              <span class="sidebar-mini"> A </span>
              <span class="sidebar-normal">{{ __('messages.order.create') }}</span>
            </a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item {{ Route::is('admin.ride*') ? 'active' : '' }} ">
      <a class="nav-link" data-toggle="collapse" href="#rides" {{ Route::is('admin.ride*') ? 'aria-expanded="true"' : '' }}>
        <i class="material-icons"></i>
        <p>{{ __('messages.rides') }}<b class="caret"></b></p>
      </a>
      <div class="collapse {{ Route::is('admin.ride*') ? 'show' : '' }}" id="rides">
        <ul class="nav">
          <li class="nav-item {{ Route::is('admin.rides') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.rides') }}">
              <span class="sidebar-mini"> P </span>
              <span class="sidebar-normal">{{ __('messages.list') }}</span>
            </a>
          </li>
          <li class="nav-item {{ Route::is('admin.ride.create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.ride.create') }}">
              <span class="sidebar-mini"> A </span>
              <span class="sidebar-normal">{{ __('messages.ride.create') }}</span>
            </a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item {{ Route::is('admin.setting*') ? 'active' : '' }} ">
      <a class="nav-link" data-toggle="collapse" href="#settings" {{ Route::is('admin.setting*') ? 'aria-expanded="true"' : '' }}>
        <i class="material-icons"></i>
        <p>{{ __('messages.settings') }}<b class="caret"></b></p>
      </a>
      <div class="collapse {{ Route::is('admin.setting*') ? 'show' : '' }}" id="settings">
        <ul class="nav">
          <li class="nav-item {{ Route::is('admin.apikeys') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.apikeys') }}">
              <span class="sidebar-mini"> P </span>
              <span class="sidebar-normal">{{ __('messages.apikeys') }}</span>
            </a>
          </li>
        </ul>
      </div>
    </li>
  </ul>
</div>