@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3">déclarer Incident</h2>

        @php
            $incidentData = [
                'Eau Potable' => [
                    'Réfection' => ['Non réalisée', 'A reprendre', 'Chantier non nettoyé'],
                    'Fuite d\'eau' => ['Fuite dans la Rue', 'Compteur Sauté'],
                    'Affaissement de la voie' => ['Avec présence d\'eau'],
                ],
                'Electricité' => [
                    'Problème de Poteau' => ['Poteau Accidenté', 'Poteau Tombé', 'Poteau risque de Tomber'],
                    'Problème de Ligne' => ['Ligne Tombée', 'Ligne Risque de Tomber', 'Ligne Brûlée'],
                    'Problème Coffret' => ['Brûlé', 'Cassé', 'Accidenté', 'Sans Porte'],
                    'Surtension' => ['Client Seul', 'Tout le Quartier'],
                    'Acte de vandalisme' => ['Poste Réseau', 'Coffret BT', 'Branchement', 'Compteur'],
                    'Manque Electricité' => ['Client Seul', 'Tout le Quartier'],
                    'Icendie' => ['Coffret BT', 'Poste', 'Branchement', 'Colonne Montante'],
                    'Compteur' => ['Compteur Brulé', 'Compteur Cassé'],
                ],
                'Assainissement' => [
                    'Réfection' => ['Non réalisée', 'A reprendre', 'Chantier non nettoyé'],
                    'Débordement' => ['Regard de Visite', 'Inondation Eaux Pluie', 'Station Pompage Relevage'],
                    'Problème d\'Ouvrage' => [
                        'Mise à Niveau',
                        'Tampon cassé',
                        'Tampon inexistant',
                        'Ouvrage Déterioré',
                    ],
                    'Problème d\'odeur' => [
                        'Bouche d\'Egout à Grille',
                        'Bouche d\'Egout Avaloir',
                        'Regard de Visite',
                        'Station de Pompage-Relevage',
                    ],
                    'Sacs à la décharge' => ['Avec présence d\'eau (odeurs)'],
                    'Affaissement de la voie' => ['Avec présence d\'eau (odeurs)'],
                    'Installation REDAL insalubre' => ['Avec présence d\'eau (odeurs)'],
                ],
                'Réuse' => [
                    'Réfection' => ['Non réalisée', 'A reprendre', 'Chantier non nettoyé'],
                    'Fuite' => ['Non réalisée', 'A reprendre', 'Chantier non nettoyé'],
                    'Rupture de canalisation' => ['Non réalisée', 'A reprendre', 'Chantier non nettoyé'],
                ],
            ];
        @endphp



        <form action="{{ route('incident.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_user" value="{{ auth()->user()->id }}" />

            <div class="mb-3">
                <label for="categorie" class="form-label">Catégorie</label>
                <select id="categorie" name="id_category" class="form-select">
                    <option value="">-- Choisir Catégorie --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" data-name="{{ $cat->nomCategorie }}">{{ $cat->nomCategorie }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="incident_name" class="form-label">Nom de l'Incident</label>
                <select id="incident_name" name="incident_name" class="form-select">
                    <option value="">-- Choisir Incident --</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="detail" class="form-label">Détails</label>
                <select id="detail" name="detail" class="form-select">
                    <option value="">-- Choisir Détail --</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="adresse" name="adresse" required >
            </div>

            {{-- <div id="map" style="height: 300px;" class="mb-3"></div> --}}
           


            <div class="mb-3">
                <x-prefecture-component />
            </div>

            {{-- <div class="mb-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control" id="longitude" name="longitude" readonly>
            </div>

            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" readonly>
            </div> --}}

            <div class="mb-3">
                <label for="photo" class="form-label">Photo </label>
                <input type="file" class="form-control" id="photo" name="photo">
            </div>

            <button type="submit" class="btn btn-dark">Créer Incident</button>
        </form>
    </div>

    {{-- Leaflet.js --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script>
        const incidentData = @json($incidentData);

        const selectCategorie = document.getElementById('categorie');
        const selectIncident = document.getElementById('incident_name');
        const selectDetail = document.getElementById('detail');

        selectCategorie.addEventListener('change', function() {
            const selectedCat = this.options[this.selectedIndex].getAttribute('data-name');
            selectIncident.innerHTML = '<option value="">-- Choisir Incident --</option>';
            selectDetail.innerHTML = '<option value="">-- Choisir Détail --</option>';

            if (selectedCat && incidentData[selectedCat]) {
                const incidents = Object.keys(incidentData[selectedCat]);
                incidents.forEach(incident => {
                    selectIncident.add(new Option(incident, incident));
                });
            }
        });

        selectIncident.addEventListener('change', function() {
            const selectedCat = selectCategorie.options[selectCategorie.selectedIndex].getAttribute('data-name');
            const selectedIncident = this.value;

            selectDetail.innerHTML = '<option value="">-- Choisir Détail --</option>';

            if (selectedCat && selectedIncident && incidentData[selectedCat][selectedIncident]) {
                incidentData[selectedCat][selectedIncident].forEach(detail => {
                    selectDetail.add(new Option(detail, detail));
                });
            }
        });

        
    </script>
@endsection
