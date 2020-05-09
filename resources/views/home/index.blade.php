@extends('home/base')
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
            <button class="btn btn-fill btn-info btn-lg rounded-0 animated infinite pulse 2s">Où allez-vous?</button>
            <div class="subscribe">
                <h5 class="info-text">
                    Contactez-nous ou Inscrivez-vous <b>GRATUITEMENT</b> et téléchargez l'application 
                </h5>
                <div class="row">
                    <div class="col-md-12 text-center">
                      <button class="btn btn-info text-uppercase">inscription</button>
                      <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <button type="button" class="btn btn-success"><i class="fab fa-android"></i>&nbsp;Download APK</button>
                        <button type="button" class="btn btn-success"><i class="fas fa-download"></i></button>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  @endsection