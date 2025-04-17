@extends('layouts.main')
@section('content')
    <div class="container d-flex justify-content-center flex-column">
        <h2 class="text-center">Modifier un Categorie</h2>
        <form action="{{route('categories.update',$category->id)}}" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $category->id }}" />
            <input type="text" name="nomCategorie" class="form-control" value="{{old('nomCategorie',$category->nomCategorie)}}" id="">
            <input type="submit" value="Modifier" class="btn btn-success mt-2" />
        </form>
    </div>
@endsection
