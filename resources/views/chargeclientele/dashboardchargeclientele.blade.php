@extends('layouts.main')

@section('content')
    <nav class="shadow-lg p-2 justify-content-between align-items-center d-flex">
        <div class="d-flex align-items-center">
            <img src="{{ asset('/storage/logo.png') }}" width="60" height="60" alt="">
            <h4 style="font-family:'Courier New', Courier, monospace" class="mt-2 ms-1">Risque Alerte</h4>
        </div>
        <x-logout-component />
    </nav>
    <div class="container mt-5">
        <h2 class="text-center mb-4" style="font-family: monospace;">Tableau de bord - Chargé de Clientèle</h2>
        @if (session()->has('success'))
            <div class="alert alert-success p-3 container fade show d-flex justify-content-between" role="alert">
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('danger'))
            <div class="alert alert-danger p-3 container fade show d-flex justify-content-between" role="alert">
                <div>{{ session('danger') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- Filtres -->
        <form method="GET" action="{{ route('client_service.dashboard') }}" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <select name="category_id" class="form-select">
                        <option value="">-- Toutes les catégories --</option>
                        @foreach ($categories as $categorie)
                            <option value="{{ $categorie->id }}"
                                {{ request('category_id') == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->nomCategorie }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-primary" type="submit">Filtrer</button>
                </div>
            </div>
        </form>

        <!-- Liste des réclamations -->
        <div class="card mb-5">
            <div class="card-header">Réclamations</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Nom Client</th>
                            <th>Incident</th>
                            <th>Catégorie</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reclamations as $reclamation)
                            <tr>
                                <td>{{ $reclamation->user->nom }} {{ $reclamation->user->prenom }}</td>
                                <td>{{ $reclamation->incident->incident_name }}</td>
                                <td>{{ optional($reclamation->incident->category)->nomCategorie ?? 'Inconnu' }}</td>
                                <td>{{ \Carbon\Carbon::parse($reclamation->dateReclamation)->format('d/m/Y') }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $reclamation->statut == 'validé' ? 'success' : ($reclamation->statut == 'rejeté' ? 'danger' : 'secondary') }}">
                                        {{ ucfirst($reclamation->statut) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($reclamation->statut == 'en attente')
                                        <form method="POST"
                                            action="{{ route('reclamations.update', $reclamation->id) }}"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm">Valider</button>
                                        </form>
                                        {{-- <form method="POST"
                                            action="{{ route('client_service.reject', $reclamation->id) }}"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Rejeter</button>
                                        </form> --}}
                                    @else
                                        <em>Action terminée</em>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                {{ $reclamations->links() }}
            </div>
        </div>

        <!-- Graphique -->
        <div class="card">
            <div class="card-header">Statistiques des réclamations par catégorie</div>
            <div class="card-body d-flex justify-content-center">
                <div style="width: 300px; height: 300px;">
                    <canvas id="pieChart" width="300" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Réclamations par catégorie',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: [
                        '#007bff', '#28a745', '#dc3545', '#ffc107', '#17a2b8', '#6f42c1', '#fd7e14',
                        '#20c997', '#6c757d', '#e83e8c'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                return label + ' : ' + value + ' réclamations';
                            }
                        }
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endsection
