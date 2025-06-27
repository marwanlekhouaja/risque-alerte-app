@extends('layouts.main')

@section('content')
    <style>
        /* Même style que login */
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #f7f7f7, #e2e2e2, #ffffff);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .animated-dots {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .animated-dots .dot {
            position: absolute;
            border-radius: 50%;
            background: cornflowerblue;
            animation: moveDots 10s infinite linear;
        }

        @keyframes moveDots {
            0% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(100px, 100px);
            }

            100% {
                transform: translate(0, 0);
            }
        }

        .dot:nth-child(1),
        .dot:nth-child(2),
        .dot:nth-child(3),
        .dot:nth-child(4),
        .dot:nth-child(5),
        .dot:nth-child(6),
        .dot:nth-child(7),
        .dot:nth-child(8) {
            width: 12px;
            height: 12px;
        }

        /* Carte d'inscription */
        .register-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            padding: 7px;
            width: 100%;
            max-width: 450px;
            z-index: 10;
        }
    </style>

    <div class="animated-dots">
        <div class="dot" style="top: 10%; left: 15%;"></div>
        <div class="dot" style="top: 30%; left: 50%;"></div>
        <div class="dot" style="top: 60%; left: 70%;"></div>
        <div class="dot" style="top: 80%; left: 30%;"></div>
        <div class="dot" style="top: 20%; left: 80%;"></div>
        <div class="dot" style="top: 50%; left: 10%;"></div>
        <div class="dot" style="top: 70%; left: 40%;"></div>
        <div class="dot" style="top: 40%; left: 60%;"></div>
    </div>
    <h2 style="font-family: 'Courier New', Courier, monospace" class="text-center">Bienvenue cher client sur risque alerte
    </h2>
    <div class="register-card">
        <h2 class="text-center mb-4">Créer un compte</h2>

        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <form action="{{ route('auth.register') }}" method="POST">
            @csrf

            <div class="form-floating m-2">
                <input type="text" class="form-control" name="nom" id="floatingNom" value="{{ old('nom') }}"
                    >
                    @error('nom')
                    <span class="text-danger mt-2">
                                           {{ $message }}
                    </span>
                    @enderror
                <label for="floatingNom">Nom</label>
            </div>

            <div class="form-floating m-2">
                <input type="text" class="form-control" name="prenom" id="floatingPrenom" value="{{ old('prenom') }}"
                    >
                    @error('prenom')
                    <span class="text-danger mt-2">
                                           {{ $message }}
                    </span>
                    @enderror
                <label for="floatingPrenom">Prénom</label>
            </div>

            <div class="form-floating m-2">
                <input type="text" class="form-control" name="telephone" id="floatingTelephone"
                    value="{{ old('telephone') }}" >
                <label for="floatingTelephone">Téléphone</label>
            </div>

            <div class="form-floating m-2">
                <input type="email" class="form-control" name="email" id="floatingEmail" value="{{ old('email') }}"
                    >
                    @error('email')
                    <span class="text-danger mt-2">
                                           {{ $message }}
                    </span>
                    @enderror
                <label for="floatingEmail">Email</label>
            </div>

            <div class="form-floating m-2">
                <input type="password" class="form-control" name="password" id="floatingPassword" >
                @error('password')
                    <span class="text-danger mt-2">
                                           {{ $message }}
                    </span>
                    @enderror
                <label for="floatingPassword">Mot de passe</label>
            </div>
            <input type="hidden" name="role" value="user">

            <div class="d-grid">
                <button type="submit" class="btn btn-dark btn-lg">Créer le compte</button>
            </div>

            <div class="text-center">
                <p>Déjà inscrit ? <a href="{{ route('auth.show') }}">Connectez-vous ici</a></p>
            </div>
        </form>
    </div>
@endsection
