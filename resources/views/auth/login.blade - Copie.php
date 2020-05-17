@extends('layouts.auth')

@section('style')
<link href="{{ asset('css/main/login.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow rounded-0 px-3 py-3">
                <div class="card-header border-bottom-0 text-uppercase">{{ __('Login') }}</div>

                <div class="card-body">

                    <form method="POST" class="mb-5" action="{{ route('login') }}">
                        @csrf
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input id="phone" type="text" class="mdl-textfield__input @error('phone') is-invalid @enderror" name="phone" required autocomplete="phone" value="+33 X XX XX XX XX">

                            <label class="mdl-textfield__label" for="phone">{{ __('Phone Number') }}</label>

                                @error('phone')
                                    <span class="mdl-textfield__error" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                          </div>
                          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <label class="mdl-textfield__label" for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="mdl-textfield__input @error('password') is-invalid @enderror" name="password" value="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="mdl-textfield__error" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                          </div>
                          <label class="mb-4 mdl-switch mdl-js-switch mdl-js-ripple-effect" for="remember">
                                <input type="checkbox" class="mdl-switch__input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="mdl-switch__label">{{ __('Remember me') }}</span>
                            </label>

                        <div class="form-group">
                                <button type="submit" class="btn btn-primary rounded-0">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                        </div>
                    </form>
                    <hr>
                    <div class="text-center">
                    <a href="{{ url('/login/facebook') }}" class="btn btn-light px-0 py-0 rounded-circle"><i class="fab fa-3x fa-facebook"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
