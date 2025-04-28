<?php

namespace App\Http\Controllers;

use App\Imports\IncidentsImport;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class importExcel extends Controller
{
   
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,csv',
        ]);

        try {
            Excel::import(new IncidentsImport, $request->file('excel_file'));
            return back()->with('success', 'Importation réussie.');
        } catch (Exception $e) {
            return back()->with('error', 'Erreur lors de l\'importation : ' . $e->getMessage());
        }
    }

    public function syncLocal()
    {
        $filePath = storage_path('app/incidents.xlsx');

        if (file_exists($filePath)) {
            Excel::import(new IncidentsImport, $filePath);
            return back()->with('success', 'Fichier local synchronisé avec succès.');
        } else {
            return back()->with('error', 'Fichier local non trouvé.');
        }
    }



    public function autoImport()
    {
        try {
            // Charger le fichier interne
            $path = storage_path('app/public/incidents.xlsx');

            if (!file_exists($path)) {
                return back()->with('error', 'Fichier interne non trouvé.');
            }

            Excel::import(new IncidentsImport, $path);

            return back()->with('success', 'Mise à jour automatique réussie.');
        } catch (Exception $e) {
            return back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }


}
