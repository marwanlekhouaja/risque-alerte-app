<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\IncidentsImport;

class AutoImportIncidents extends Command
{
    protected $signature = 'incidents:auto-import';
    protected $description = 'Importe automatiquement le fichier incidents.xlsx dans la base de données.';

    public function handle()
    {
        $path = storage_path('app/public/incidents.xlsx');

        if (!file_exists($path)) {
            $this->error('Fichier incidents.xlsx introuvable.');
            return 1; // erreur
        }

        try {
            Excel::import(new IncidentsImport, $path);
            $this->info('Importation automatique réussie.');
            return 0; // succès
        } catch (\Exception $e) {
            $this->error('Erreur lors de l\'importation : ' . $e->getMessage());
            return 1; // erreur
        }
    }
}
