@extends('home.base')

@section('title')
Accueil
@endsection

@section('stylesheet')
    <link href="{{ asset('css/custom-home.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
	<h1 class="logo cursive">
		Navette Club
	</h1>
	<div class="content text-center">
		<h4 class="text-white">Simplement ponctuel et organisé</h4>
		<a href="/order" class="btn btn-fill btn-green btn-lg rounded-0 animated infinite pulse 2s">Où allez-vous?</a>
		<div class="subscribe">
			<h5 class="info-text">
				Contactez-nous ou Inscrivez-vous <b>GRATUITEMENT</b> et téléchargez l'application
			</h5>
			<div class="row">
				<div class="col-md-12 text-center">
				  <a href="{{ route('register') }}" class="btn btn-white text-uppercase">inscription</a>
				  <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
<<<<<<< HEAD
					<a href="{{ asset('apps/com.navetteclub.android.beta-1.0.1-2021-03-20BETA.apk') }}" type="button" class="btn btn-green"><i class="fab fa-android"></i>&nbsp;Download APK</a>
					<a href="{{ asset('apps/com.navetteclub.android.beta-1.0.1-2021-03-20BETA.apk') }}" type="button" class="btn btn-green"><i class="fas fa-download"></i></a>
=======
					<a href="{{ asset('apps/com.navetteclub.android-1.0.1-2021-02-09.apk') }}" type="button" class="btn btn-green"><i class="fab fa-android"></i>&nbsp;Download APK</a>
					<a href="{{ asset('apps/com.navetteclub.android-1.0.1-2021-02-09.apk') }}" type="button" class="btn btn-green"><i class="fas fa-download"></i></a>
>>>>>>> master
				  </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
