@extends('layouts.auth')

@section('title'){{ __('Verify') }}@endsection

@section('style')
<link href="{{ asset('css/main/login.css') }}" rel="stylesheet">
@endsection

@section('content')
<!--begin::Login-->
<div class="login login-3 login-forgot-on d-flex flex-row-fluid" id="kt_login">
	<div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid" style="background-image: url(/img/bg-auth.jpg);">
		<div class="login-form text-center text-white p-7 position-relative overflow-hidden">
			<!--begin::Login Header-->
			<div class="d-flex flex-center mb-5">
				<a href="/">
					<img src="/img/logo-white.png" class="max-h-75px" alt=""/>
				</a>
			</div>
			<!--end::Login Header-->
			
			<!--begin::Login forgot password form-->
			<div class="login-forgot">
				<div class="mb-20">
					<h3 class="opacity-40 font-weight-normal">{{ __('Verification de votre numero?') }}</h3>
					<p class="opacity-40">{{ __('Entrez le code que vous aurez du recevoir par SMS au ...') }}</p>
				</div>
                
                @if (session('info'))
                    <div class="alert alert-info" role="alert">
                        {{ session('info') }}
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                
				<form class="form" id="kt_login_forgot_form" method="post">
                    @csrf
					<div class="form-group mb-10">
						<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8 @error('code') is-invalid @enderror" type="text" placeholder="{{ __('Code de vérification') }}" name="code" autocomplete="off" value="{{ old('code') }}"/>
                        @error('code')
                            <div class="fv-plugins-message-container"><div class="fv-help-block">{{ $message }}</div></div>
                        @enderror
					</div>
					<div class="form-group">
						<button type="submit" name="action" value="verify" class="btn btn-pill btn-primary opacity-90 px-15 py-3 m-2">{{ __('Verifier') }}</button>
						<button type="submit" name="action" value="resend" class="btn btn-pill btn-outline-white opacity-70 px-15 py-3 m-2">{{ __('Renvoyer le code?') }}</button>
					</div>
				</form>
			</div>
			<!--end::Login forgot password form-->
		</div>
	</div>
</div>
<!--end::Login-->
@endsection

@section('javascript')
@endsection
