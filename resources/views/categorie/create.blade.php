@extends('layouts.main')
@section('content')
    <div class="container d-flex justify-content-center flex-column">
        <h2 class="mb-3">Creer une Categorie</h2>
        <form action="{{route('categories.store')}}" method="post">
            @csrf
            <input type="text" name="nomCategorie" class="form-control" id=""> 
            <input type="submit" value="Creer" class="btn btn-dark mt-2" />
        </form>
    </div>
@endsection
