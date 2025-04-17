@extends('layouts.main')
@section('content')
    <div class="container mt-4">
        <h2 class="mb-3">Modifier l'Incident</h2>
        <form action="{{ route('incidents.update', $incident->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $incident->id }}">
            <div class="mb-3">
                <label for="incident_name" class="form-label">Nom de l'Incident</label>
                <input type="text" class="form-control" id="incident_name" name="incident_name" value="{{ old('incident_name', $incident->incident_name) }}" required>
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">Détails</label>
                <textarea class="form-control" id="detail" name="detail" rows="3">{{ old('detail', $incident->detail) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">Adresse</label>
                <input class="form-control" id="detail" name="adresse" value="{{ old('adresse', $incident->adresse) }}" />
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">Longitude</label>
                <input class="form-control" id="detail" name="longitude" value="{{ old('longitude', $incident->longitude) }}" />
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">latitude</label>
                <input class="form-control" id="detail" value="{{ old('latitude', $incident->latitude) }}" name="latitude" value="{{ old('latitude', $incident->latitude) }}"/>
            </div>
            
            <div class="mb-3">
                <label for="photo" class="form-label">Photo (optionnelle)</label>
                <input type="file" class="form-control" id="photo" name="photo">
            </div>
            <button type="submit" class="btn btn-success">Mettre à jour l'Incident</button>
        </form>
    </div>
@endsection