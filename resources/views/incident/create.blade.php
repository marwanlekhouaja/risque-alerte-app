@extends('layouts.main')
@section('content')
    <div class="container mt-4">
        <h2 class="mb-3">Modifier l'Incident</h2>
        <form action="{{ route('incidents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="incident_name" class="form-label">Nom de l'Incident</label>
                <input type="text" class="form-control" id="incident_name" name="incident_name" value="{{ old('incident_name') }}" required>
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">Détails</label>
                <textarea class="form-control" id="detail" name="detail" rows="3">{{ old('detail') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">Adresse</label>
                <input class="form-control" id="detail" name="adresse" value="{{ old('adresse') }}" />
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">Prefecture</label>
                <input class="form-control" id="detail" name="prefecture" value="{{ old('prefecture') }}" />
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">Longitude</label>
                <input class="form-control" id="detail" name="longitude" value="{{ old('longitude') }}" />
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">latitude</label>
                <input class="form-control" id="detail" value="{{ old('latitude') }}" name="latitude" value="{{ old('latitude') }}"/>
            </div>
            <label for="">Choisir Client disponible</label>
            <select name="id_user" id="">
                <option value="">--Choisir Client--</option>
                @foreach ($clients as $client)
                    @if($client->role!='admin')
                        <option value="{{ $client->id }}">{{ $client->nom }} {{ $client->prenom }}</option>
                    @endif    
                @endforeach
            </select>
            <label for="">Choisir Categorie disponible</label>
            <select name="id_category" id="">
                <option value="">--Choisir Categorie--</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->nomCategorie }}</option>
                @endforeach
            </select>
            
            <div class="mb-3">
                <label for="photo" class="form-label">Photo (optionnelle)</label>
                <input type="file" class="form-control" id="photo" name="photo">
            </div>
            <button type="submit" class="btn btn-dark">Creer Incident</button>
        </form>
    </div>
@endsection