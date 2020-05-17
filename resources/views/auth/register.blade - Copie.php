@extends('layouts.app')

@section('stylesheet')
<link href="{{ asset('css/login.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card rounded-0 shadow px-3 py-3">
                <div class="card-header border-bottom-0 text-uppercase">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">

                            <label class="mdl-textfield__label" for="name">{{ __('Name') }}</label>

                            <input id="name" type="text" class="mdl-textfield__input @error('name') is-invalid @enderror" name="name"  value="{{ __('Jean Pierre') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                          </div>
                          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">

                            <label class="mdl-textfield__label" for="phone">{{ __('Phone Number') }}</label>

                            <input id="phone" type="text" class="mdl-textfield__input @error('phone') is-invalid @enderror" name="phone"  value="{{ __('+33 x xx xx xx xx') }}" required autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                          </div>
                          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">

                            <label class="mdl-textfield__label" for="password">{{ __('Password') }}</label>

                            <input id="password" type="password" class="mdl-textfield__input @error('password') is-invalid @enderror" name="password"  value="{{ __('password') }}" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                          </div>
                          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">

                            <label class="mdl-textfield__label" for="password-confirm">{{ __('Confirm Password') }}</label>

                            <input id="password-confirm" type="password" class="mdl-textfield__input @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" value="{{ __('password') }}">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                          </div>

                        <div class="form-group">
                                <button type="submit" class="btn btn-primary rounded-0">
                                    {{ __('Register') }}
                                </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
