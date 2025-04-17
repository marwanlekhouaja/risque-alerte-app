@extends('layouts.main')

@section('content')
<div class="container text-center mt-5">
    <h1 class="display-4 mb-4">Bienvenue sur le Portail de Gestion des Incidents</h1>
    <p class="lead">Choisissez une action ci-dessous pour commencer :</p>

    <div class="d-flex justify-content-center gap-4 mt-5">
        <a href="{{ route('auth.show') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-comment-dots"></i> Réclamer un incident
        </a>

        <a href="{{ route('incidents.liste') }}" class="btn btn-outline-secondary btn-lg">
            <i class="fas fa-list"></i> Voir la liste des incidents
        </a>
    </div>
</div>
@endsection
