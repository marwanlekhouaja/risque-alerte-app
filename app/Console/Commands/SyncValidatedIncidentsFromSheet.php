<?php

namespace App\Console\Commands;

use App\Models\Categorie;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Category;
use App\Models\Incident;
use Str;
use App\Notifications\ReclamationValidee;

class SyncValidatedIncidentsFromSheet extends Command
{
    protected $signature = 'sync:validated-incidents';
    protected $description = 'Synchroniser uniquement les incidents validés depuis Google Sheets';

    public function handle()
    {
        $csvUrl = 'https://docs.google.com/spreadsheets/d/1ySmZE4e6EvgSaJfaO291nMSLVas0bC_eHgGlwifM4rM/export?format=csv&gid=1015649646';


        $response = Http::get($csvUrl);

        if (!$response->ok()) {
            $this->error('Erreur lors de la récupération du fichier CSV.');
            return Command::FAILURE;
        }

        $rows = array_map('str_getcsv', explode("\n", $response->body()));
        $header = array_map('trim', array_shift($rows)); // première ligne = entêtes

        $newCount = 0;

        foreach ($rows as $row) {
            if (count($row) !== count($header)) {
                continue; // ignorer les lignes mal formées
            }

            $data = array_combine($header, $row);
            if (!isset($data['ID']) || strtolower(trim($data['statut'])) !== 'valide') {
                continue;
            }

            // Ignorer si l’incident existe déjà
            if (Incident::where('sheet_id', $data['ID'])->exists()) {
                continue;
            }

            $email = $data['Envoyé par'] ?? '';
            $localPart = Str::before($email, '@');

            // Création ou récupération de l'utilisateur
            $user = User::where('email', $email)->first();
            if (!$user) {
                // S'il n'existe pas, le créer
                $user = User::create([
                    'nom' => explode(' ', $data['Nom et Prénom'])[0] ?? 'Inconnu',
                    'prenom' => explode(' ', $data['Nom et Prénom'])[1] ?? '',
                    'email' => $email,
                    'telephone' => $data['Téléphone'],
                    'password' => bcrypt($localPart ?: 'password'),
                    'role' => 'user',
                    'adresse' => $data['Adresse'] ?? '',
                ]);
            } else {
                // Sinon, s'assurer que le téléphone est à jour
                $user->update([
                    'telephone' => $data['Téléphone'],
                ]);
            }

            // Création ou récupération de la catégorie
            $category = Categorie::firstOrCreate([
                'nomCategorie' => $data['Catégorie'] ?? 'Autre',
            ]);

            if (Incident::where('sheet_id', $data['ID'])->exists()) {
                continue;
            }

            // Création de l’incident
            Incident::create([
                'sheet_id' => $data['ID'],
                'incident_name' => $data['Incident'] ?? '',
                'id_category' => $category->id,
                'id_user' => $user->id,
                'detail' => $data['Détail'] ?? '',
                'autrePrecisions' => $data['Autres précisionPsh'] ?? '',
                'prefecture' => $data['Préfecture'] ?? '',
                'adresse' => $data['Adresse'] ?? null,
                'longitude' => $data['Long'] ?? null,
                'latitude' => $data['Lat'] ?? null,
                'statut' => 'validé',
                'date' => now(),
            ]);

            $incident = Incident::findOrFail($data['ID']);
            // // Notification à l'utilisateur
            $user = $incident->user;
            if ($user) {
                $user->notify(new ReclamationValidee($incident));
            }

            $newCount++;
        }

        $this->info("Incidents ajoutés : $newCount");
        return Command::SUCCESS;
    }
}
