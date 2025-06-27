@extends('layouts.main')

@section('content')
    @include('incident.models.delete_model')
    @include('incident.models.edit_model')

    <nav class="shadow-lg p-2 justify-content-between align-items-center d-flex">
        <div class="d-flex align-items-center">
            <img src="{{ asset('/storage/logo.png') }}" width="60" height="60" alt="">
            <h4 style="font-family:'Courier New', Courier, monospace" class="mt-2 ms-1">Risque Alerte</h4>
        </div>
        <x-logout-component />
    </nav>
    <div class="">


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



            <h4>Incidents en cours</h4>
            @if ($incidents->isEmpty())
                <div class="alert alert-info mt-3" role="alert">
                    Aucun incident en cours pour le moment.
                </div>
            @else
                <table class="table table-light text-center shadow-lg rounded table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th colspan="2">Nom utilisateur</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Catégorie</th>
                            <th>Préfecture</th>
                            <th>Adresse</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($incidents as $incident)
                            <tr>
                                <td>{{ $incident->sheet_id ?? $incident->id }}</td>
                                <td colspan="2">{{ $incident->user->nom }} {{ $incident->user->prenom }}</td>
                                <td>{{ $incident->user->email }}</td>
                                <td>{{ $incident->user->telephone }}</td>
                                <td>{{ $incident->category->nomCategorie ?? 'N/A' }}</td>
                                <td>{{ $incident->prefecture }}</td>
                                <td>{{ $incident->adresse }}</td>
                                <td>{{ $incident->date }}</td>
                                <td><span class="badge bg-warning text-dark">{{ $incident->statut }}</span></td>
                                <td>
                                    <form method="POST" class=""
                                        action="{{ route('incident.valider', $incident->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-success">Valider</button>

                                    </form>

                                </td>
                                <td>
                                    <form method="POST" class=""
                                        action="{{ route('incidents.destroy', $incident->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-delete"
                                            data-url="{{ route('incidents.destroy', $incident->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                            </svg>
                                        </button>

                                    </form>

                                </td>
                                <td>
                                    <form method="GET" class=""
                                        action="{{ route('incidents.edit', $incident->id) }}">
                                        @csrf
                                        <button class="btn btn-success"
                                            data-url="{{ route('incidents.edit', $incident->id) }}"
                                            data-statut="{{ $incident->statut }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                            </svg>
                                        </button>

                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <!-- Users Section -->
            {{-- <div id="users" class="card mb-4 shadow-lg">
                    <div class="card-header bg-dark d-flex justify-content-between">
                        <span class="text-light">Users</span>
                        <a href="{{ route('users.create') }}" class="btn btn-sm btn-light float-end">Add User</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $u)
                                    @if ($u->role != 'admin')
                                        <tr>
                                            <td>{{ $u->id }}</td>
                                            <td>{{ $u->nom }} {{ $u->prenom }}</td>
                                            <td>{{ $u->email }}</td>
                                            <td>{{ $u->role }}</td>
                                            <td>
                                                <a href="{{ route('users.edit', $u->id) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('users.destroy', $u->id) }}" method="POST"
                                                    style="display:inline-block">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Delete this user?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> --}}

            {{-- Statistiques en bas --}}
            <div class="mt-5">
                <h4 class="text-center">Statistiques des Incidents</h4>
                <div class="row mt-4 mb-4">
                    <div class="col-md-6 text-center">
                        <h5>Incidents par Préfecture</h5>
                        <canvas id="prefectureChart"></canvas>
                    </div>
                    <div class="col-md-6 text-center">
                        <h5>Incidents par Catégorie</h5>
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart.js --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const prefectureChart = new Chart(document.getElementById('prefectureChart'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($prefecturesStats->pluck('prefecture')) !!},
                    datasets: [{
                        label: 'Incidents par Préfecture',
                        data: {!! json_encode($prefecturesStats->pluck('total')) !!},
                        backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6c757d']
                    }]
                }
            });

            const categoryChart = new Chart(document.getElementById('categoryChart'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($categoriesStats->pluck('category.nomCategorie')) !!},
                    datasets: [{
                        label: 'Incidents par Catégorie',
                        data: {!! json_encode($categoriesStats->pluck('total')) !!},
                        backgroundColor: ['#ff6384', '#36a2eb', '#ffcd56', '#4bc0c0', '#9966ff']
                    }]
                }
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                const deleteForm = document.getElementById('deleteForm');

                const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                const editForm = document.getElementById('editForm');
                const statutSelect = document.getElementById('statut');

                // Suppression : 
                document.querySelectorAll('.btn-delete').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = this.getAttribute('data-url');
                        deleteForm.action = url;
                        deleteModal.show();
                    });
                });

                // Edition : 
                document.querySelectorAll('.btn-edit').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();

                        const modal = new bootstrap.Modal(document.getElementById('editModal'));
                        const form = document.getElementById('editForm');

                        form.action = this.getAttribute('data-url');
                        document.getElementById('edit_id').value = this.getAttribute('data-id');
                        document.getElementById('incident_name').value = this.getAttribute('data-name');
                        document.getElementById('detail').value = this.getAttribute('data-detail');
                        document.getElementById('adresse').value = this.getAttribute('data-adresse');
                        document.getElementById('longitude').value = this.getAttribute(
                        'data-longitude');
                        document.getElementById('latitude').value = this.getAttribute('data-latitude');

                        modal.show();
                    });
                });

            });
        </script>
    @endsection
