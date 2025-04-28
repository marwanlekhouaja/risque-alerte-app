@extends('layouts.main')

@section('content')
    <style>
        .spinner-border {
            animation: spin 2s linear infinite;
            /* Rotation 360 degrés */
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <div class="">
        <div class="nav p-1 shadow-lg">
            <div class="container mt-2 ">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Bouton Notification -->
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('/storage/logo.png') }}" width="60" height="60" alt="">
                        <h4 style="font-family:'Courier New', Courier, monospace" class="mt-2 ms-1">Risque Alerte</h4>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="dropdown">
                            <button class="btn position-relative" id="notificationsDropdown" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-bell" style="font-size: 17px;"></i>
                                @if (auth()->user()->unreadNotifications->count() > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle p-1  bg-danger border border-light rounded-circle"></span>
                                @endif

                            </button>
                            <ul class="dropdown-menu">
                                @forelse (auth()->user()->notifications as $notification)
                                    <li>
                                        <a class="dropdown-item" href="{{ $notification->data['url'] ?? '#' }}"
                                            onclick="markAsRead('{{ $notification->id }}')">
                                            {{ $notification->data['message'] ?? 'Notification' }}
                                        </a>
                                    </li>
                                @empty
                                    <li><span class="dropdown-item">Pas de notifications</span></li>
                                @endforelse
                            </ul>


                        </div>
                        <!-- Bouton Logout -->
                        <x-logout-component />
                    </div>
                </div>
            </div>



        </div>

        <div>
            <h2 class="text-center mt-2" style="font-family: monospace">Bienvenue {{ auth()->user()->prenom }}
                {{ auth()->user()->nom }}</h2>
        </div>
        <div class="container mt-4 d-flex justify-content-between align-items-center">
            <h1>Liste des Incidents</h1>
            <form action="{{ route('incident.create') }}" method="get">
                @csrf
                <input type="submit" class="btn btn-dark" value="Ajouter un incident">
            </form>

        </div>
        <hr class="container">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
        </div>

        {{-- ... Le reste de ta page d'incidents --}}
        <div class="container mt-2">
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
                                @if ($incident->reclamation && $incident->reclamation->statut == 'validee')
                                    <!-- Logo de traitement en cours -->
                                    <div class="d-flex align-items-center">
                                        {{-- <div class="spinner-border text-info" role="status"
                                            style="width: 3rem; height: 3rem;">
                                            <span class="visually-hidden">Chargement...</span>
                                        </div> --}}
                                        <i class="bi bi-hourglass-split"></i>
                                        <p class="ms-3">Incident en cours de traitement</p>
                                    </div>
                                @else
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#reclamationModal" data-incident="{{ $incident->id }}">
                                        Valider
                                    </button>
                                @endif
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
                        <button type="submit" class="btn btn-success">Oui, Valider</button>
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

        // Marquer une notification comme lue (quand on clique sur un lien individuel)
        function markAsRead(notificationId) {
            fetch(`/notifications/mark-as-read/${notificationId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                if (response.ok) {
                    console.log('Notification marquée comme lue');
                }
            });
        }

        document.getElementById('notificationsDropdown').addEventListener('click', function() {
            fetch('/notifications/mark-all-as-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                if (response.ok) {
                    document.querySelector('.position-absolute.top-0.start-100')?.remove();
                }
            });
        });
    </script>
@endsection
