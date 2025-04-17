@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Tous les Incidents</h2>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Préfecture</th>
                <th>Date</th>
                <th>Voir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($incidents as $incident)
                <tr>
                    <td>{{ $incident->id }}</td>
                    <td>{{ $incident->incident_name }}</td>
                    <td>{{ $incident->prefecture }}</td>
                    <td>{{ $incident->date }}</td>
                    <td>
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#incidentModal{{ $incident->id }}">
                            Détail
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="incidentModal{{ $incident->id }}" tabindex="-1" aria-labelledby="incidentModalLabel{{ $incident->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="incidentModalLabel{{ $incident->id }}">
                                            Détails de l'incident #{{ $incident->id }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Nom:</strong> {{ $incident->incident_name }}</p>
                                        <p><strong>Catégorie:</strong> {{ $incident->category->nomCategorie ?? 'N/A' }}</p>
                                        <p><strong>Utilisateur:</strong> {{ $incident->user->nom ?? 'N/A' }}</p>
                                        <p><strong>Description:</strong> {{ $incident->detail }}</p>
                                        <p><strong>Autres Précisions:</strong> {{ $incident->autrePrecisions }}</p>
                                        <p><strong>Photo:</strong> 
                                            @if($incident->photo)
                                                <img src="{{ asset('storage/' . $incident->photo) }}" alt="Photo" style="max-width: 100%; height: auto;">
                                            @else
                                                Aucune photo
                                            @endif
                                        </p>
                                        <p><strong>Préfecture:</strong> {{ $incident->prefecture }}</p>
                                        <p><strong>Adresse:</strong> {{ $incident->adresse }}</p>
                                        <p><strong>Date:</strong> {{ $incident->date }}</p>
                                        <p><strong>Longitude:</strong> {{ $incident->longitude }}</p>
                                        <p><strong>Latitude:</strong> {{ $incident->latitude }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
