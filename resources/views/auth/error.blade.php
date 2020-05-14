@extends('layouts.app')

@section('stylesheet')
<link href="{{ asset('css/login.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row mt-2 justify-content-center">
        <div class="col-md-4">
            <div class="card mt-5 text-center shadow rounded-0 px-3 py-3">
                
                <div class="card-body">

                    <i class="far fa-3x fa-frown"></i>
                    <h4 class="mt-2 mb-0">Une erreur s'est produit lors de l'inscription.</h4>
                    <p>Recommencez plus tard.</p>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
