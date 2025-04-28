@extends('layouts.main')
@section('content')
<div  class="container flex-column d-flex align-items-center justify-content-center">
    <h1 class="text-center">creer compte utilisateur</h1>
    <form action="{{route('auth.register')}}" method="post" class="flex-col shadow-lg rounded p-2 col-10 col-md-6">
        @csrf
        <div class="mb-1">
            <label for="exampleFormControlInput1" class="form-label">nom </label>
            <input type="text" class="form-control" value="{{old('nom')}}" name="nom" id="exampleFormControlInput1" >
          </div>
          <div class="mb-1">
            <label for="exampleFormControlInput1" class="form-label">prenom </label>
            <input type="text" class="form-control" value="{{old('prenom')}}" name="prenom" id="exampleFormControlInput1" >
          </div>
          <div class="mb-1">
            <label for="exampleFormControlInput1" class="form-label">telephone </label>
            <input type="text" class="form-control" value="{{old('telephone')}}" name="telephone" id="exampleFormControlInput1" >
          </div>
          {{-- <div class="mb-1">
            <label for="exampleFormControlInput1" class="form-label">Adresse(optional)</label>
            <input type="text" class="form-control" value="{{old('adresse')}}" name="adresse" id="exampleFormControlInput1" />
          </div> --}}
        <div class="mb-1">
            <label for="exampleFormControlInput1" class="form-label">Email </label>
            <input type="email" class="form-control" value="{{old('email')}}" name="email" id="exampleFormControlInput1" placeholder="name@example.com">
          </div>
          <div class="mb-1">
            <label for="exampleFormControlTextarea1" class="form-label">mot de pass</label>
            <input type="password" name="password"  value="{{old('password')}}"class="form-control" />
          </div>
          <input type="submit" value="creer" class="btn btn-dark mt-2" />
    </form>
</div>
@endsection