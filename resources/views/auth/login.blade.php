@extends('layouts.main')
@section('content')
<div style="height: 90vh" class="container flex-column d-flex align-items-center justify-content-center">
    <h1 class="text-center">Login</h1>
    <form action="{{route('auth.login')}}" method="post" class="flex-col shadow-lg rounded p-2 col-10 col-md-7">
       @csrf
       @error('email')
         <div class="alert alert-danger" role="alert">
                {{ $message }}
          </div>
          
       @enderror
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email </label>
            <input type="email" class="form-control" name="email" id="exampleFormControlInput1" placeholder="name@example.com">
          </div>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">mot de pass</label>
            <input type="password" name="password" class="form-control" />
          </div>
          <input type="submit" value="Login" class="btn btn-dark mt-2" />
    </form>
</div>
@endsection