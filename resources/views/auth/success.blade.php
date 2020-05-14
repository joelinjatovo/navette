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

                    <i class="fas fa-3x fa-user-check"></i>
                    <p class="mt-2 mb-0">Merci pour votre inscription</p>
                    <h3 class="text-uppercase my-1">bienvenue!</h3>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
