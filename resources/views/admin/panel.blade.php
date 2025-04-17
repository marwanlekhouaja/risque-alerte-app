@extends('layouts.main')

@section('content')
    <style>
        #sidebar,
        #main-content {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar with Anchor Links -->
            <div class="col-md-2 bg-dark text-white p-3" style="height: 200rem100vh;">
                <h4 class="text-center mb-4">Admin Panel</h4>
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
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#reclamations">
                            <i class="fas fa-comments"></i> Manage Reclamations
                        </a>
                    </li>
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
            <div class="col-md-10 p-4">
                <!-- Top Header (Admin Info and Logout) -->
                <div class="d-flex justify-content-between align-items-center mb-4" id="dashboard">
                    <div>
                        <h1>Welcome, {{ auth()->user()->nom }} {{ auth()->user()->prenom }}</h1>
                        <p>Role: <strong>{{ auth()->user()->role }}</strong></p>
                        <!-- Edit Admin Data Button -->
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editAdminModal">
                            Edit Profile
                        </button>
                    </div>
                    <div>
                        <form action="{{ route('auth.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </div>
                </div>

                <!-- Dashboard Stats -->
                <div class="row mb-4 shadow-lg">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">Total Users</h5>
                                <p class="card-text fs-3">{{ $users->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">Total Incidents</h5>
                                <p class="card-text fs-3">{{ $incidents->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">Total Reclamations</h5>
                                <p class="card-text fs-3">{{ $reclamations->count() }}</p>
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
                </div>

                <!-- Incidents Section -->
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
                                    <th>latitude</th>
                                    <th>longitude</th>
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
                                        <td>{{ $i->user->nom ?? 'N/A' }}</td>
                                        <td>{{ $i->latitude }}</td>
                                        <td>{{ $i->longitude }}</td>
                                        <td>{{ $i->adresse }}</td>
                                        <td>
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
                <div id="reclamations" class="card mb-4">
                    <div class="card-header bg-dark text-white">Reclamations</div>
                    <div class="card-body">
                        <table class="table text-center table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Commentaire</th>
                                    <th>Incident</th>
                                    <th>Client</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reclamations as $r)
                                    <tr>
                                        <td>{{ $r->id }}</td>
                                        <td>{{ $r->commentraire ?? 'no message existe' }}</td>
                                        <td>{{ $r->incident->incident_name ?? 'N/A' }}</td>
                                        <td>{{ $r->user->nom ?? 'N/A' }}{{ $r->user->prenom }}</td>
                                        {{-- <td>
                                            <a href="{{ route('reclamations.edit', $r->id) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('reclamations.destroy', $r->id) }}" method="POST"
                                                style="display:inline-block">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete this reclamation?')">Delete</button>
                                            </form>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Categorie liste  --}}
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
            </div>


        </div>
    </div>

    <!-- Include the Modal Partial -->
    @include('admin.edit-modal')
@endsection
