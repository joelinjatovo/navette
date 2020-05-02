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
      <img src="{{ auth()->user()->image ? auth()->user()->image->url : '/img/faces/avatar.jpg' }}" />
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
    <li class="nav-item ">
      <a class="nav-link" href="../examples/charts.html">
        <i class="material-icons">timeline</i>
        <p> Charts </p>
      </a>
    </li>
  </ul>
</div>