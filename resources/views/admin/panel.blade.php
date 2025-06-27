@extends('layouts.main')

@section('content')
    <style>
        #sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            height: 120vh;
            overflow-y: auto;
            z-index: 1000;

        }

        #main-content {
            margin-left: 16.6%;
            /* Correspond à col-md-2 */
            padding: 2rem;
        }

        [id] {
            scroll-margin-top: 100px;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar with Anchor Links -->
            <div class="col-md-2 bg-dark text-white p-3" style="height: 200rem100vh;">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('/storage/logo.png') }}" width="60" height="60" alt="">
                    <h4 style="font-family:'Courier New', Courier, monospace" class="mt-2 ms-1">Risque Alerte</h4>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#dashboard">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#users">
                            <i class="fas fa-users"></i> Manage Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#incidents">
                            <i class="fas fa-exclamation-circle"></i> Manage Incidents
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link text-white" href="#reclamations">
                            <i class="fas fa-comments"></i> Manage Reclamations
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#categroies">
                            <i class="fas fa-comments"></i> Manage Categroies
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/import">
                            <i class="fas fa-comments"></i> Import Data
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content Area -->
            <div class="col-md-10 ">
                <!-- Top Header (Admin Info and Logout) -->
                <div class="d-flex justify-content-between align-items-center mb-4" id="dashboard">
                    <div>
                        <h1>Welcome, {{ auth()->user()->nom }} {{ auth()->user()->prenom }}</h1>
                        <p>Role: <strong>{{ auth()->user()->role }}</strong></p>
                        <!-- Edit Admin Data Button -->
                        <div class="d-flex align-items-center">
                            <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                Edit Profile
                            </button>
                            <x-logout-component />
                        </div>
                    </div>

                </div>

                <!-- Dashboard Stats -->
                <div class="row mb-4 shadow-lg">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">Total Clients</h5>
                                <p class="card-text fs-3">{{ $users->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">Total Incidents non validés</h5>
                                <p class="card-text fs-3">{{ $incidentsValides }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-info mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">Total Incidents validés</h5>
                                <p class="card-text fs-3">{{ $incidentsNonValides }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">Total Categories</h5>
                                <p class="card-text fs-3">{{ $categoriesCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

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
                <div id="categroies" class="card mb-4">
                    <div class="card-header bg-dark d-flex justify-content-between">
                        <span class="text-light">Categories</span>
                        <a href="{{ route('categories.create') }}" class="btn btn-sm btn-light float-end">Add
                            Categorie</a>
                    </div>
                    <div class="card-body">
                        <table class="table text-center table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>nom Categorie</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $c)
                                    <tr>
                                        <td>{{ $c->id }}</td>
                                        <td>{{ $c->nomCategorie }}</td>
                                        <td>
                                            <a href="{{ route('categories.edit', $c) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('categories.destroy', $c) }}" method="POST"
                                                style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete this category?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Users Section -->
                <div id="users" class="card mb-4 shadow-lg">
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
                                                    style="display:inline-block" onsubmit="return confirmDelete();">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger">Supprimer</button>
                                                </form>

                                                <script>
                                                    function confirmDelete() {
                                                        return confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?");
                                                    }
                                                </script>

                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Incidents Section -->
                <form method="GET" class="p-3 bg-light rounded mb-3 d-flex gap-3 align-items-center">
                    <div>
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">All</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nomCategorie }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <x-prefecture-component :selected="request('prefecture')" />

                    {{-- <div>
                        <label for="prefecture">Prefecture</label>
                        <select name="prefecture" id="prefecture" class="form-control text-capitalize">
                            <option value="">All</option>
                            @foreach ($prefectures as $pref)
                                <option value="{{ $pref }}"
                                    {{ request('prefecture') == $pref ? 'selected' : '' }}>
                                    {{ ucfirst($pref) }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div>
                        <button type="submit" class="btn btn-primary mt-4">Filter</button>
                        <a href="{{ route('admin.panel') }}" class="btn mt-4 btn-secondary">Reset</a>
                    </div>
                </form>

                <div id="incidents" class="card mb-4 shadow-lg">
                    <div class="card-header bg-dark d-flex justify-content-between">
                        <span class="text-light">Incidents</span>
                        <a href="{{ route('incidents.create') }}" class="btn btn-sm btn-light float-end">Add Incident</a>
                    </div>
                    <div class="card-body">
                        <table class="table text-center table-bordered table-hover ">
                            <thead>
                                <tr>
                                    <th>Nom Incident</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>client</th>
                                    {{-- <th>latitude</th>
                                    <th>longitude</th> --}}
                                    <th>Adresse</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($incidents as $i)
                                    <tr>
                                        <td>{{ $i->incident_name }}</td>
                                        <td>{{ Str::limit($i->detail, 20) }} ...</td>
                                        <td>{{ $i->category->nomCategorie ?? 'N/A' }}</td>
                                        <td>{{ $i->user->nom . ' ' . $i->user->prenom ?? 'N/A' }}</td>
                                        {{-- <td>{{ $i->latitude }}</td>
                                        <td>{{ $i->longitude }}</td> --}}
                                        <td>{{ $i->adresse }}</td>
                                        <td>
                                            {{-- <form method="POST" class=""
                                                action="{{ route('incident.valider', $i->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-success">Valider</button>

                                            </form> --}}

                                            <a href="{{ route('incidents.edit', $i->id) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('incidents.destroy', $i->id) }}" method="POST"
                                                style="display:inline-block">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete this incident?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Reclamations Section -->
                {{-- <div id="reclamations" class="card mb-4">
                    <div class="card-header bg-dark text-white">Reclamations</div>
                    <div class="card-body">
                        <table class="table text-center table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Commentaire</th>
                                    <th>Incident</th>
                                    <th>Client</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reclamations as $r)
                                    @if ($r->statut == 'en attente')
                                        <tr>
                                            <td>{{ $r->id }}</td>
                                            <td>{{ $r->commentraire ?? 'Pas de message' }}</td>
                                            <td>{{ $r->incident->incident_name ?? 'N/A' }}</td>
                                            <td>{{ $r->user ? $r->user->nom . ' ' . $r->user->prenom : 'N/A' }}</td>
                                            <td>{{ $r->statut }}</td>
                                            <td>
                                                <form action="{{ route('reclamations.update', $r->id) }}" method="POST"
                                                    style="display:inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="submit" value="Valider"
                                                        class="btn btn-sm btn-success" />
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div> --}}
            </div>
            {{-- Categorie liste  --}}

        </div>



    </div>

    </div>

    <!-- Include the Modal Partial -->
    @include('admin.edit-modal')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('.nav-link');
            links.forEach(link => {
                link.addEventListener('click', function() {
                    links.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>

    <style>
        .nav-link.active {
            background-color: #198754;
            border-radius: 5px;
        }
    </style>
@endsection
