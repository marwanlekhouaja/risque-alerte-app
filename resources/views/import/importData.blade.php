<!-- resources/views/import.blade.php -->

@extends('layouts.main')

@section('content')
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif



<div class="container">
    <div style="height: 90vh" class="row justify-content-center align-items-center">
        <div class="col-md-9">
            <h2 style="font-family:monospace" class="text-center">Bienvenue Admin sur la page d'importation des donnees</h2>
            <div class="card">
                <div class="card-header">Import Excel Data</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data" id="import-form">
                        @csrf
                        <div class="form-group">
                            <label for="file">Choose Excel File</label>
                            <input type="file" name="excel_file" id="file" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Import</button>
                    </form>
                    <form action="{{ route('import.auto') }}" method="POST" style="display:inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-success mt-3">Mettre à jour automatiquement</button>
                    </form>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection