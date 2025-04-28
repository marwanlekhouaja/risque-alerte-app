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

        // Ignore empty or incomplete rows
        if (empty($data['nom_et_prenom']) || empty($data['telephone']) || empty($data['categorie']) || empty($data['incident'])) {
            return;
        }

        $nameParts = explode(' ', trim($data['nom_et_prenom']), 2);
        $nom = $nameParts[0] ?? 'Nom';
        $prenom = $nameParts[1] ?? 'Prénom';

        // Generate email
        $baseEmail = strtolower(Str::slug($nom . '.' . $prenom)) . '@example.com';
        $email = $baseEmail;

        // Check if email already exists
        if (User::where('email', $baseEmail)->exists()) {
            // If yes, add unique ID
            $email = strtolower(Str::slug($nom . '.' . $prenom)) . '-' . uniqid() . '@example.com';
        }

        // Gestion de l'utilisateur
        $user = User::firstOrCreate(
            ['telephone' => $data['telephone']], // You match by telephone
            [
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'password' => bcrypt('password'),
                'role' => 'client',
                'adresse' => $data['adresse'] ?? '',
            ]
        );

        // Gestion de la catégorie
        $categorie = Categorie::firstOrCreate([
            'nomCategorie' => $data['categorie']
        ]);

        // 🔥 Mise à jour ou création de l'incident
        Incident::updateOrCreate(
            ['id' => $data['id']], // If you have 'id' in your excel
            [
                'incident_name' => $data['incident'],
                'id_category' => $categorie->id,
                'id_user' => $user->id,
                'detail' => $data['detail'] ?? null,
                'autrePrecisions' => $data['autres_precisions'] ?? null,
                'prefecture' => strtolower($data['prefecture']) ?? null,
                'adresse' => $data['adresse'] ?? 'Adresse inconnue',
                'longitude' => $data['long'] ?? null,
                'latitude' => $data['lat'] ?? null,
                'date' => now(),
                'photo' => null,
            ]
        );
    }
}
