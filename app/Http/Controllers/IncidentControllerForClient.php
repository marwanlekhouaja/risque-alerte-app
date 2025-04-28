<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentControllerForClient extends Controller
{
    public function create()
    {
        $categories = Categorie::all();
        return view('user.createIncident', compact( 'categories'));
    }
    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'incident_name' => 'required|string|max:255',
        //     'detail' => 'nullable|string',
        //     'adresse' => 'nullable|string|max:255',
        //     'longitude' => 'nullable',
        //     'latitude' => 'nullable',
        //     'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        //     'id_user' => 'required',
        //     'id_category' => 'required',
        //     'prefecture' => 'required',
        //     'date' => ''
        // ]);
        $validatedData=$request->post();

        $validatedData['date'] = now();

        // Gérer le fichier photo si uploadé
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($request->photo && file_exists(public_path('storage/' . $request->photo))) {
                unlink(public_path('storage/' . $request->photo));
            }

            // Stocker la nouvelle photo
            $path = $request->file('photo')->store('incidents', 'public');
            $validatedData['photo'] = $path;
        }

        $validatedData['id_user']=auth()->user()->id;

        // dd($validatedData);


        // Mettre à jour l'incident
        Incident::create($validatedData);

        // // Rediriger avec un message
        return to_route('incidents.index')->with('success', 'Incident creer avec succès.');
    }
}
