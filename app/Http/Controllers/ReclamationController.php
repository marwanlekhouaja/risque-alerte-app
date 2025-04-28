<?php

namespace App\Http\Controllers;

use App\Models\Reclamation;
use App\Notifications\ReclamationValidee;
use Illuminate\Http\Request;

class ReclamationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation simple

        // Vérifier si la réclamation existe déjà (facultatif pour éviter les doublons)
        $existing = Reclamation::where('user_id', $request->user_id)
            ->where('incident_id', $request->incident_id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Vous avez déjà soumis une réclamation pour cet incident.');
        }

        // Création de la réclamation
        Reclamation::create([
            'user_id' => auth()->user()->id,
            'incident_id' => $request->incident_id,
            'dateReclamation' => now()->format('Y-m-d H:i:s'),
            'commentaire' => null, // ou tu peux l'ajouter dans le modal si besoin
        ]);

        return to_route('incidents.index')->with('success', 'Réclamation soumise avec succès.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Reclamation $reclamation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reclamation $reclamation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reclamation $reclamation)
    {
        // Mise à jour du statut
        $reclamation->update([
            'statut' => 'validee',
        ]);

        // $reclamation est ta réclamation validée
        $incident = $reclamation->incident; // Récupère l'incident lié
        $user = $reclamation->user; // L'utilisateur qui a fait la réclamation

        $user->notify(new ReclamationValidee($incident));

        return redirect()->back()->with('success', 'Réclamation traitée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reclamation $reclamation)
    {
        //
    }
}
