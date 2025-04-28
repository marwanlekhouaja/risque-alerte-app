@extends('layouts.main')

@section('content')
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #f7f7f7, #e2e2e2, #ffffff);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            display: flex;
            align-items: center;
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

        /* Points animés */
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
            /* Points noirs */
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

        .dot:nth-child(1) {
            width: 12px;
            height: 12px;
            animation-duration: 10s;
            animation-delay: 0s;
        }

        .dot:nth-child(2) {
            width: 12px;
            height: 12px;
            animation-duration: 12s;
            animation-delay: 2s;
        }

        .dot:nth-child(3) {
            width: 12px;
            height: 12px;
            animation-duration: 14s;
            animation-delay: 4s;
        }

        .dot:nth-child(4) {
            width: 12px;
            height: 12px;
            animation-duration: 16s;
            animation-delay: 6s;
        }

        .dot:nth-child(5) {
            width: 12px;
            height: 12px;
            animation-duration: 18s;
            animation-delay: 8s;
        }

        .dot:nth-child(6) {
            width: 12px;
            height: 12px;
            animation-duration: 20s;
            animation-delay: 10s;
        }

        .dot:nth-child(7) {
            width: 12px;
            height: 12px;
            animation-duration: 22s;
            animation-delay: 12s;
        }

        .dot:nth-child(8) {
            width: 12px;
            height: 12px;
            animation-duration: 24s;
            animation-delay: 14s;
        }

        /* Carte de connexion */
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            /* Réduction du padding */
            width: 100%;
            max-width: 400px;
            z-index: 10;
        }

        #togglePassword {
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Message de bienvenue */
        .alert-info {
            background-color: rgba(0, 123, 255, 0.1);
            border-color: rgba(0, 123, 255, 0.2);
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

    <div class="login-card">
        {{-- Message de Bienvenue --}}
        <div class="alert alert-info text-center" role="alert">
            Bienvenue sur <strong>Risque Alerte</strong> ! Connectez-vous pour accéder à votre espace personnel.
        </div>

        <h2 class="text-center mb-4">Connexion</h2>

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        @error('email')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @enderror

        <form action="{{ route('auth.login') }}" method="POST">
            @csrf

            <div class="form-floating mb-3">
                <input type="email" name="email" value="{{old('email')}}" class="form-control" id="floatingEmail" placeholder="name@example.com"
                    required>
                <label for="floatingEmail">Adresse Email</label>
            </div>

            <div class="form-floating mb-3 position-relative">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Mot de passe"
                    required>
                <label for="floatingPassword">Mot de passe</label>
                <button type="button" id="togglePassword" class="position-absolute top-50 end-0 translate-middle-y me-3">
                    👁️
                </button>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-dark btn-lg">Se connecter</button>
                <div class="d-flex aling-items-center">
                    <p>vous n'avez pas un compte deja ?</p> <a href="{{ route('auth.register_page') }}">creer compte ici
                    </a>
                </div>
            </div>
        </form>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('floatingPassword');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    </script>
@endsection
