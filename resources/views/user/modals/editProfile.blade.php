<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
 
</html>
    <!-- Modal Bootstrap -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Modifier Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.update', auth()->user()->id) }}" method="POST"
                        class="p-1">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ auth()->user()->id }}">

                        <div class="mb-2">
                            <label class="form-label">Nom</label>
                            <input type="text" class="form-control" name="nom"
                                value="{{ old('nom', auth()->user()->nom) }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Prénom</label>
                            <input type="text" class="form-control" name="prenom"
                                value="{{ old('prenom', auth()->user()->prenom) }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Téléphone</label>
                            <input type="text" class="form-control" name="telephone"
                                value="{{ old('telephone', auth()->user()->telephone) }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Adresse (optionnel)</label>
                            <input type="text" class="form-control" name="adresse"
                                value="{{ old('adresse', auth()->user()->adresse) }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"
                                value="{{ old('email', auth()->user()->email) }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" name="password">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-success">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>