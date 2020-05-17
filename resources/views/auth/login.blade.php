@extends('layouts.auth')

@section('title'){{ __('Login') }}@endsection

@section('style')
<link href="{{ asset('css/main/login.css') }}" rel="stylesheet">
@endsection

@section('content')
<!--begin::Login-->
<div class="login login-3 {{ Route::is('login') ? 'login-signin-on' : ( Route::is('register') ? 'login-signup-on' : 'login-forgot-on' ) }} d-flex flex-row-fluid" id="kt_login">
	<div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid" style="background-image: url(/img/bg-auth.jpg);">
		<div class="login-form text-center text-white p-7 position-relative overflow-hidden">
			<!--begin::Login Header-->
			<div class="d-flex flex-center mb-15">
				<a href="#">
					<img src="/img/logo-letter-9.png" class="max-h-75px" alt=""/>
				</a>
			</div>
			<!--end::Login Header-->

			<!--begin::Login Sign in form-->
			<div class="login-signin">
				<div class="mb-10">
					<h3 class="opacity-40 font-weight-normal">Bienvenue!</h3>
					<p class="opacity-40">Entrer les détails pour se connecter sur votre compte:</p>
				</div>
				<form class="form" id="kt_login_signin_form" method="post">
                    @csrf
					<div class="form-group">
						<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8 @error('phone') is-invalid @enderror" type="text" placeholder="{{ __('Téléphone') }}" name="phone" autocomplete="phone"  value="{{ old('phone') }}"/>
                        @error('phone')
                            <div class="fv-plugins-message-container"><div class="fv-help-block">{{ $message }}</div></div>
                        @enderror
					</div>
					<div class="form-group">
						<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8 @error('password') is-invalid @enderror" type="password" placeholder="{{ __('Mot de passe') }}" name="password"/>
                        @error('password')
                            <div class="fv-plugins-message-container"><div class="fv-help-block">{{ $message }}</div></div>
                        @enderror
					</div>
					<div class="form-group d-flex flex-wrap justify-content-between align-items-center px-8 opacity-60">
						<label class="checkbox checkbox-outline checkbox-white text-white m-0">
							<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}/> {{ __('Souvennez de moi?') }}
							<span></span>
						</label>
						<a href="javascript:;" id="kt_login_forgot" class="text-white font-weight-bold">{{ __('Mot de passe oublié?') }}</a>
					</div>
					<div class="form-group text-center mt-10">
						<button id="kt_login_signin_submit" class="btn btn-pill btn-primary opacity-90 px-15 py-3">{{ __('Se connecter') }}</button>
					</div>
				</form>
				<div class="mt-10">
					<span class="opacity-40 mr-4">
						{{ __('Vous n\'êtes pas encore inscrit?') }}
					</span>
					<a href="javascript:;" id="kt_login_signup" class="text-white opacity-30 font-weight-normal">{{ __('S\'inscrire') }}</a>
				</div>
			</div>
			<!--end::Login Sign in form-->

			<!--begin::Login Sign up form-->
			<div class="login-signup">
				<div class="mb-20">
					<h3 class="opacity-40 font-weight-normal">{{ __('Inscription') }}</h3>
					<p class="opacity-40">{{ __('Entrez les détails de votre compte pour s\'inscrire') }}</p>
				</div>
				<form class="form text-center" id="kt_login_signup_form" method="post">
                    @csrf
					<div class="form-group ">
						<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8 @error('name') is-invalid @enderror" type="text" placeholder="{{ __('Nom complet') }}" name="name" value="{{ old('name') }}"/>
                        @error('name')
                            <div class="fv-plugins-message-container"><div class="fv-help-block">{{ $message }}</div></div>
                        @enderror
					</div>
					<div class="form-group">
						<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8 @error('phone') is-invalid @enderror" type="text" placeholder="{{ __('Téléphone') }}" name="phone" autocomplete="phone" value="{{ old('phone') }}"/>
                        @error('phone')
                            <div class="fv-plugins-message-container"><div class="fv-help-block">{{ $message }}</div></div>
                        @enderror
					</div>
					<div class="form-group">
						<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8 @error('password') is-invalid @enderror" type="password" placeholder="{{ __('Mot de passe') }}" name="password"/>
                        @error('password')
                            <div class="fv-plugins-message-container"><div class="fv-help-block">{{ $message }}</div></div>
                        @enderror
					</div>
					<div class="form-group">
						<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8 @error('password') is-invalid @enderror" type="password" placeholder="{{ __('Confirmation du mot de passe') }}" name="password_confirmation"/>
                        @error('password')
                            <div class="fv-plugins-message-container"><div class="fv-help-block">{{ $message }}</div></div>
                        @enderror
					</div>
					<div class="form-group text-left px-8">
						<label class="checkbox checkbox-outline checkbox-white opacity-60 text-white m-0">
							<input type="checkbox" name="agree"/>J'ai lu et j'accepte <a href="#" class="text-white font-weight-bold">les termes et les conditions</a>.
							<span></span>
						</label>
						<div class="form-text text-muted text-center"></div>
					</div>
					<div class="form-group">
						<button id="kt_login_signup_submit" class="btn btn-pill btn-primary opacity-90 px-15 py-3 m-2">{{ __('S\'inscrire') }}</button>
						<button id="kt_login_signup_cancel" class="btn btn-pill btn-outline-white opacity-70 px-15 py-3 m-2">{{ __('Annuler') }}</button>
					</div>
				</form>
			</div>
			<!--end::Login Sign up form-->

			<!--begin::Login forgot password form-->
			<div class="login-forgot">
				<div class="mb-20">
					<h3 class="opacity-40 font-weight-normal">{{ __('Mot de passe oublié?') }}</h3>
					<p class="opacity-40">{{ __('Entrez votre numéro de téléphone pour récupérer votre mot de passe') }}</p>
				</div>
                
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                
				<form class="form" id="kt_login_forgot_form" method="post">
                    @csrf
					<div class="form-group mb-10">
						<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8 @error('phone') is-invalid @enderror" type="text" placeholder="{{ __('Téléphone') }}" name="phone" autocomplete="off" value="{{ old('phone') }}"/>
                        @error('phone')
                            <div class="fv-plugins-message-container"><div class="fv-help-block">{{ $message }}</div></div>
                        @enderror
					</div>
					<div class="form-group">
						<button id="kt_login_forgot_submit" class="btn btn-pill btn-primary opacity-90 px-15 py-3 m-2">{{ __('Demander') }}</button>
						<button id="kt_login_forgot_cancel" class="btn btn-pill btn-outline-white opacity-70 px-15 py-3 m-2">{{ __('Annuler') }}</button>
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
<script type="text/javascript">
var KTLoginGeneral=function(){
    var t,
    i=function(i){
        var o="login-"+i+"-on";
        i="kt_login_"+i+"_form";
        t.removeClass("login-forgot-on"),
        t.removeClass("login-signin-on"),
        t.removeClass("login-signup-on"),
        t.addClass(o),
        KTUtil.animateClass(KTUtil.getById(i),"animate__animated animate__backInUp")
    };
    return{
        init:function(){
            var o;
            t=$("#kt_login"),
            o=FormValidation.formValidation(KTUtil.getById("kt_login_signin_form"),{
                fields:{
                    username:{validators:{notEmpty:{message:"Username is required"}}},
                    password:{validators:{notEmpty:{message:"Password is required"}}}
                },
                plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap}
            }),
            $("#kt_login_signin_submit").on("click",function(t){
                t.preventDefault(),
                o.validate().then(function(t){
                    if("Valid"==t){
                        /*
                        swal.fire({text:"All is cool! Now you submit this form",icon:"success",buttonsStyling:!1,confirmButtonText:"Ok, got it!",confirmButtonClass:"btn font-weight-bold btn-light-primary"})
                            .then(function(){KTUtil.scrollTop()})
                        */
                        KTUtil.getById("kt_login_signin_form").submit()
                    }else{
                        swal.fire({text:"Sorry, looks like there are some errors detected, please try again.",icon:"error",buttonsStyling:!1,confirmButtonText:"Ok, got it!",confirmButtonClass:"btn font-weight-bold btn-light"})
                        .then(function(){KTUtil.scrollTop()})
                    }
                })
            }),
            $("#kt_login_forgot").on("click",function(t){t.preventDefault(),history.replaceState({}, null, '/password/reset'),i("forgot")}),
            $("#kt_login_signup").on("click",function(t){t.preventDefault(),history.replaceState({}, null, '/register'),i("signup")}),
            function(t){
                var o,
                n=KTUtil.getById("kt_login_signup_form");
                o=FormValidation.formValidation(n,{
                    fields:{
                        fullname:{validators:{notEmpty:{message:"Votre nom est obligatoire."}}},
                        phone:{validators:{notEmpty:{message:"Votre numéro de téléphone est obligatoire."}}},
                        password:{validators:{notEmpty:{message:"Le mot de passe est obligatoire."}}},
                        password_confirmation:{validators:{notEmpty:{message:"La confirmation du mot de passe est obligatoire."},
                        identical:{compare:function(){return n.querySelector('[name="password"]').value},
                        message:"Le mot de passe et sa confirmation doivent correspondre."}}},
                        agree:{validators:{notEmpty:{message:"Vous devez accepter les termes et conditions."}}}
                    },
                    plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap}
                }),
                $("#kt_login_signup_submit").on("click",function(t){
                    t.preventDefault(),
                    o.validate().then(function(t){
                        if("Valid"==t){
                            n.submit();
                        }else{
                            swal.fire({text:"Sorry, looks like there are some errors detected, please try again.",icon:"error",buttonsStyling:!1,confirmButtonText:"Ok, got it!",confirmButtonClass:"btn font-weight-bold btn-light"})
                            .then(function(){KTUtil.scrollTop()})
                        }
                    })
                }),
                $("#kt_login_signup_cancel").on("click",function(t){t.preventDefault(),history.replaceState({}, null, '/login'),i("signin")})
            }(),
            function(t){
                var o;
                o=FormValidation.formValidation(KTUtil.getById("kt_login_forgot_form"),{
                    fields:{
                        phone:{validators:{notEmpty:{message:"Le numéro de téléphone est obligatoire."}}}
                    },
                    plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap}
                }),
                $("#kt_login_forgot_submit").on("click",function(t){
                    t.preventDefault(),
                    o.validate().then(function(t){
                        if("Valid"==t){
                            KTUtil.getById("kt_login_forgot_form").submit()
                        }else{
                            swal.fire({text:"Sorry, looks like there are some errors detected, please try again.",icon:"error",buttonsStyling:!1,confirmButtonText:"Ok, got it!",confirmButtonClass:"btn font-weight-bold btn-light"})
                            .then(function(){KTUtil.scrollTop()})
                        }
                    })
                }),
                $("#kt_login_forgot_cancel").on("click",function(t){t.preventDefault(),history.replaceState({}, null, '/login'),i("signin")})
            }()
        }
    }
}();
jQuery(document).ready(function(){KTLoginGeneral.init()});
</script>
@endsection
