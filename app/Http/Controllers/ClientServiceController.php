<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Reclamation;
use Illuminate\Http\Request;

class ClientServiceController extends Controller
{
    public function dashboard(Request $request)
    {
        $categories = Categorie::all();

        $reclamationsQuery = Reclamation::with(['user', 'incident.category']);

        if ($request->filled('category_id')) {
            $reclamationsQuery->whereHas('incident', function ($q) use ($request) {
                $q->where('id_category', $request->category_id);
            });
        }

        $reclamations = $reclamationsQuery->paginate(10);

        // Préparer les statistiques
        $categoryData = Categorie::with(['incidents.reclamations'])->get();

        $chartLabels = [];
        $chartData = [];

        foreach ($categoryData as $categorie) {
            $count = 0;
            foreach ($categorie->incidents as $incident) {
                $count += $incident->reclamations->count();
            }

            if ($count > 0) {
                $chartLabels[] = $categorie->nomCategorie . " ($count)"; // << ici on ajoute aussi le nombre
                $chartData[] = $count;
            }
        }

        return view('chargeclientele.dashboardchargeclientele', compact('categories', 'reclamations', 'chartLabels', 'chartData'));
    }



    // Validation d'une réclamation (mise à jour du statut)
    public function validateReclamation($id)
    {
        $reclamation = Reclamation::findOrFail($id);
        $reclamation->update(['statut' => 'validé']);

        return redirect()->back()->with('success', 'Réclamation validée.');
        
    }

    // Rejet d'une réclamation (mise à jour du statut)
    public function reject($id)
    {
        $reclamation = Reclamation::findOrFail($id);
        $reclamation->update(['statut' => 'rejeté']);

        return redirect()->back()->with('success', 'Réclamation rejetée.');
    }
}
