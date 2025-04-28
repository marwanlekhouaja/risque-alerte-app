<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Localisation exacte</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"/>
    <style>
        #map { height: 300px; margin-bottom: 20px; }
    </style>
</head>
<body>

<h2>Ma localisation exacte</h2>

<div id="map"></div>

<form method="POST" action="{{ route('save.location') }}">
    @csrf
    <label>Adresse détectée :</label><br>
    <input type="text" name="adresse" id="adresse" class="form-control" required><br>

    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">

    <button type="submit">Valider</button>
</form>

<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(async position => {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            // Afficher la carte
            const map = L.map('map').setView([lat, lon], 17);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(map);

            const marker = L.marker([lat, lon], { draggable: true }).addTo(map);

            // Fonction reverse geocoding avec Nominatim
            async function getAddress(lat, lon) {
                const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&accept-language=fr`;
                const response = await fetch(url);
                const data = await response.json();
                return data.display_name || "";
            }

            // Remplir les champs
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lon;
            document.getElementById('adresse').value = await getAddress(lat, lon);

            // Quand l'utilisateur déplace le marqueur
            marker.on('moveend', async function (e) {
                const newLat = e.target.getLatLng().lat;
                const newLon = e.target.getLatLng().lng;

                document.getElementById('latitude').value = newLat;
                document.getElementById('longitude').value = newLon;
                document.getElementById('adresse').value = await getAddress(newLat, newLon);
            });

        }, error => {
            alert("Impossible de détecter votre position. Activez le GPS.");
        });
    } else {
        alert("La géolocalisation n'est pas supportée par ce navigateur.");
    }
</script>

</body>
</html>
