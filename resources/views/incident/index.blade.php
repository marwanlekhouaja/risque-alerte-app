@extends('layouts.main')

@section('content')
    <div class="">
        {{-- @auth --}}
            <div class="nav d-flex justify-content-end mb-3 p-3 shadow-lg">
                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
                
            </div>
        {{-- @endauth --}}
        @if (session()->has('success'))
            <div class="alert alert-success p-3 container fade show d-flex justify-content-between" role="alert">
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger p-3 container fade show d-flex justify-content-between" role="alert">
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <div class="container">
            <div class="row">
                @foreach ($incidents as $incident)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100">
                            @if ($incident->photo)
                                <img src="{{ asset('storage/' . $incident->photo) }}" class="card-img-top"
                                    alt="Photo Incident">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $incident->incident_name }}</h5>
                                <p class="card-text"><strong>Catégorie:</strong>
                                    {{ $incident->category->nomCategorie ?? 'Non spécifiée' }}</p>
                                <p class="card-text"><strong>Détails:</strong> {{ $incident->detail }}</p>
                                <p class="card-text"><strong>Adresse:</strong> {{ $incident->adresse }}</p>
                                <p class="card-text"><strong>Date:</strong> {{ $incident->date }}</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reclamationModal"
                                    data-incident="{{ $incident->id }}">
                                    Réclamer
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal Bootstrap pour confirmation de réclamation -->
    <div class="modal fade" id="reclamationModal" tabindex="-1" aria-labelledby="reclamationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('reclamations.store') }}">
                @csrf
                <input type="hidden" name="incident_id" id="modal-incident-id">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation de réclamation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Voulez-vous vraiment soumettre une réclamation pour cet incident ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                        <button type="submit" class="btn btn-success">Oui, Réclamer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const modal = document.getElementById('reclamationModal');
        modal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const incidentId = button.getAttribute('data-incident');
            document.getElementById('modal-incident-id').value = incidentId;
        });
    </script>
@endsection
