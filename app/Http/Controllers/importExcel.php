<?php

namespace App\Http\Controllers;

use App\Imports\IncidentsImport;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
    
}
