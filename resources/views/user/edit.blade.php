@extends('layouts.main')
@section('content')
    <div class="container ">
        <h1 class="text-center">Modifier Compte Utilisateur</h1>
        <div class="d-flex justify-content-center">
            <form action="{{ route('users.update', $user->id) }}" method="post" class="f shadow-lg rounded p-2 w-50">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="mb-1">
                    <label for="exampleFormControlInput1" class="form-label">nom </label>
                    <input type="text" class="form-control" value="{{ old('nom', $user->nom) }}" name="nom"
                        id="exampleFormControlInput1">
                </div>
                <div class="mb-1">
                    <label for="exampleFormControlInput1" class="form-label">prenom </label>
                    <input type="text" class="form-control" value="{{ old('prenom', $user->prenom) }}" name="prenom"
                        id="exampleFormControlInput1">
                </div>
                <div class="mb-1">
                    <label for="exampleFormControlInput1" class="form-label">telephone </label>
                    <input type="text" class="form-control" value="{{ old('telephone', $user->telephone) }}"
                        name="telephone" id="exampleFormControlInput1">
                </div>
                <div class="mb-1">
                    <label for="exampleFormControlInput1" class="form-label">Adresse(optional)</label>
                    <input type="text" class="form-control" value="{{ old('adresse', $user->adresse) }}" name="adresse"
                        id="exampleFormControlInput1" />
                </div>
                <div class="mb-1">
                    <label for="exampleFormControlInput1" class="form-label">Email </label>
                    <input type="email" class="form-control" value="{{ old('email', $user->email) }}" name="email"
                        id="exampleFormControlInput1" placeholder="name@example.com">
                </div>
                <div class="mb-1">
                    <label for="exampleFormControlTextarea1" class="form-label">mot de pass</label>
                    <input type="password" name="password"
                        value="{{ old('password', $user->password) }}"class="form-control" />
                </div>
                @if (auth()->user()->role == 'admin')
                    <div class="mb-1">
                        <label for="exampleFormControlTextarea1" class="form-label">role</label>
                        <select name="role" class="form-control" id="" >
                            <option value="user" >Utilisateur</option>
                            <option value="chargeclientele" >chargeclientele</option>
                        </select>

                    </div>
                @endif
                <input type="submit" value="modifier" class="btn btn-success mt-2" />
            </form>
        </div>
    </div>
@endsection
