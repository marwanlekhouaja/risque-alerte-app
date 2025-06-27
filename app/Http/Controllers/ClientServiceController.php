<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Incident;
use App\Models\Reclamation;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class ClientServiceController extends Controller
{
    public function index()
{
    $incidents = Incident::with('user', 'category')
        ->where('statut', 'en cours') // ⬅ Affiche uniquement les incidents à valider
        ->orderBy('created_at', 'desc')
        ->get();

    $categoriesStats = Incident::select('id_category', DB::raw('count(*) as total'))
        ->groupBy('id_category')
        ->with('category')
        ->get();

    $prefecturesStats = Incident::select('prefecture', DB::raw('count(*) as total'))
        ->groupBy('prefecture')
        ->get();

    $users = User::with('incidents')->get();
            

    return view('chargeclientele.dashboardchargeclientele', compact('incidents', 'categoriesStats', 'prefecturesStats','users'));
}


    // Valider un incident
    public function valider($id)
    {
        $incident = Incident::findOrFail($id);
        $incident->statut = 'validé';
        $incident->save();

        return redirect()->back()->with('success', 'Incident validé avec succès.');
    }
}
