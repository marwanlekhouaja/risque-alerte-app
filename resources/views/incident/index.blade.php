@extends('layouts.main')

@section('content')
@include('user.modals.editProfile')
    <style>
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .rotate {
            display: inline-block;
            animation: spin 2s linear infinite;
        }
    </style>

    <div>
        <div class="nav p-1 shadow-lg">
            <div class="container mt-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('/storage/logo.png') }}" width="60" height="60" alt="">
                        <h4 style="font-family:'Courier New', Courier, monospace" class="mt-2 ms-1">Risque Alerte</h4>
                    </div>
                    <div class="d-flex align-items-center">
                        {{-- <x-logout-component /> --}}
                        @php
                            $notifications = auth()->user()->unreadNotifications;
                        @endphp

                        <div class="position-relative me-3 ms-2">
                            <a href="#" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell fs-4"></i>
                                @if ($notifications->count() > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                        <span class="visually-hidden">Nouvelles notifications</span>
                                    </span>
                                @endif
                            </a>
                            @php
                                $notifications = auth()->user()->notifications;
                            @endphp
                            <ul class="dropdown-menu" aria-labelledby="notificationsDropdown">
                                @forelse ($notifications as $notification)
                                    <li class="dropdown-item small {{ $notification->read_at ? 'text-muted' : 'fw-bold' }}">
                                        {{ $notification->data['message'] }}
                                        <div class="text-muted small">Reçu le
                                            {{ $notification->created_at->format('d/m/Y H:i') }}</div>
                                    </li>
                                @empty
                                    <li class="dropdown-item text-muted">Aucune notification</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="dropdown ms-3">

                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                                id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                @if (auth()->user()->photo)
                                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Photo de profil"
                                        class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                @else
                                    <div class="bg-secondary text-white rounded-circle d-flex justify-content-center align-items-center"
                                        style="width: 40px; height: 40px;">
                                        <i class="bi bi-person fs-5"></i>
                                    </div>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="userDropdown">
                                <li class="dropdown-item"><strong>Nom :</strong>
                                    {{ auth()->user()->nom . ' ' . auth()->user()->prenom }}</li>
                                <li class="dropdown-item"><strong>Email :</strong> {{ auth()->user()->email }}</li>
                                <li class="dropdown-item"><strong>Téléphone :</strong> {{ auth()->user()->telephone }}</li>
                                <li class="dropdown-item"><strong>Nombre des réclamations :</strong>
                                    {{ auth()->user()->incidents()->count() }}</li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <!-- Bouton pour ouvrir le modal -->
                                <li>
                                    <a class="dropdown-item text-primary" href="#" data-bs-toggle="modal"
                                        data-bs-target="#editProfileModal">
                                        Modifier Profil
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item text-danger" href="{{ route('auth.logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Se déconnecter
                                    </a>
                                </li>
                                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <form method="GET" class="row g-3 align-items-end">
                <!-- Select catégorie -->
                <div class="col-md-4 mb-4">
                    <label for="categorie" class="form-label">Catégorie</label>
                    <select name="categorie" id="categorie" class="form-select">
                        <option value="">-- Toutes les catégories --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('categorie') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nomCategorie }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Select préfecture via composant -->
                <div class="col-md-4 mb-4">
                    @include('components.prefecture-component')
                </div>

                <div class="col-md-4 mb-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                    <a href="{{ route('incidents.index') }}" class="btn btn-secondary">Réinitialiser</a>
                </div>
            </form>
        </div>

        <div class="container mt-4 d-flex align-items-center justify-content-between">
            <h1>Liste des Incidents déclarés</h1>
            <a href="{{ route('incident.create') }}" class="btn btn-dark">Ajouter un incident</a>
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

        <div class="container mt-2">
            <div class="row">
                @forelse ($incidents as $incident)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title text-secondary">#{{ $incident->sheet_id }}</h5>
                                <p><strong>Nom de l'incident :</strong> {{ $incident->incident_name }}</p>
                                <p><strong>Catégorie :</strong> {{ $incident->category->nomCategorie ?? 'Non spécifiée' }}
                                </p>
                                <p><strong>Détails :</strong> {{ $incident->detail ?? 'Aucun détail' }}</p>
                                <p><strong>Préfecture :</strong> {{ $incident->prefecture ?? 'Inconnue' }}</p>
                                <p><strong>Adresse :</strong> {{ $incident->adresse ?? 'Inconnue' }}</p>
                                <p><strong>Date de déclaration :</strong>
                                    {{ \Carbon\Carbon::parse($incident->date)->format('d/m/Y H:i') }}</p>

                                @if ($incident->statut === 'en cours')
                                    <div class="alert alert-info d-flex align-items-center" role="alert">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        <div>Votre demande est en cours de traitement.</div>
                                    </div>
                                @else
                                    <div class="alert alert-success d-flex align-items-center" role="alert">
                                        <i class="bi bi-check-circle-fill me-2"></i>
                                        <div>Votre demande a été validée.</div>
                                    </div>
                                @endif

                                <div class="d-flex align-items-center mb-2">
                                    <button class="btn btn-outline-info ms-2" data-bs-toggle="modal"
                                        data-bs-target="#incidentDetailModal-{{ $incident->id }}">
                                        Détails
                                    </button>
                                </div>

                                @include('components.incident-detail-modal', ['incident' => $incident])
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 mt-4">
                        <div class="alert alert-warning">Aucun incident trouvé pour ces critères.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const notifDropdown = document.getElementById('notificationsDropdown');
        if (notifDropdown) {
            notifDropdown.addEventListener('click', function() {
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
        }
    </script>
@endsection
