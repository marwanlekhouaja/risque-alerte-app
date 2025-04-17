@extends('layouts.main')
@section('content')
    <div class="container d-flex justify-content-center">
        <h1 class="text-center">Modifier Une Reclamation</h1>
        <form action="{{route('reclamations.update',$reclamation->id)}}" method="post">
            
        </form>
    </div>
@endsection
