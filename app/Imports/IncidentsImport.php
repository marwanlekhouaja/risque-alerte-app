<?php

namespace App\Imports;

use App\Models\Categorie;
use App\Models\Incident;
use App\Models\User;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use Illuminate\Support\Str;

class IncidentsImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        $data = $row->toArray();

        // Skip if required fields are missing
        if (empty($data['nom_et_prenom']) || empty($data['telephone']) || empty($data['categorie']) || empty($data['incident'])) {
            return;
        }

        // 1. Séparer nom et prénom (with fallback)
        $nameParts = explode(' ', trim($data['nom_et_prenom']), 2);
        $nom = $nameParts[0] ?? 'Nom';
        $prenom = $nameParts[1] ?? 'Prénom';

        // 2. Rechercher l'utilisateur par téléphone
        $user = User::where('telephone', $data['telephone'])->first();

        // 2.1. S'il n'existe pas, on le crée
        if (!$user) {
            $email = strtolower(Str::slug($nom . '.' . $prenom)) . '@example.com';

            // Vérifier si l'email existe déjà, et si oui, le rendre unique
            $originalEmail = $email;
            $i = 1;
            while (User::where('email', $email)->exists()) {
                $email = strtolower(Str::slug($nom . '.' . $prenom)) . $i . '@example.com';
                $i++;
            }

            $user = User::create([
                'nom' => $nom,
                'prenom' => $prenom,
                'telephone' => $data['telephone'],
                'email' => $email,
                'password' => bcrypt('password'),
                'role' => 'client',
                'adresse' => $data['adresse'] ?? '',
            ]);
        }

        // 3. Créer ou retrouver la catégorie
        $categorie = Categorie::firstOrCreate([
            'nomCategorie' => $data['categorie']
        ]);

        // 4. Créer l'incident
        Incident::create([
            'incident_name' => $data['incident'],
            'id_category' => $categorie->id,
            'id_user' => $user->id,
            'detail' => $data['detail'] ?? null,
            'autrePrecisions' => $data['autres_precisions'] ?? null,
            'prefecture' => $data['prefecture'] ?? null,
            'adresse' => $data['adresse'] ?? 'Adresse inconnue',
            'longitude' => $data['long'] ?? null,
            'latitude' => $data['lat'] ?? null,
            'date' => now(),
            'photo' => null
        ]);
    }
}
