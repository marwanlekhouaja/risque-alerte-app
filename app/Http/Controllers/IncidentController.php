<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function  __construct(){
        $this->middleware('auth')->only('index');
    }
    public function index()
    {
        $incidents = Incident::all();
        return view('incident.index',compact('incidents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients=User::all();
        $categories=Categorie::all();
        return view('incident.create',compact('clients','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'incident_name' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'adresse' => 'nullable|string|max:255',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
            'id_user'=>'required',
            'id_category'=>'required',
            'prefecture'=>'required',
            'date'=>''
        ]);

        $validatedData['date']=now();
    
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
    
        // Mettre à jour l'incident
        Incident::create($validatedData);
    
        // Rediriger avec un message
        return redirect()->route('admin.panel')->with('success', 'Incident creer avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Incident $incident)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incident $incident)
    {
        return view('incident.edit', compact('incident'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incident $incident)
{
    // Valider les données
    $validatedData = $request->validate([
        'incident_name' => 'required|string|max:255',
        'detail' => 'nullable|string',
        'adresse' => 'nullable|string|max:255',
        'longitude' => 'nullable|numeric',
        'latitude' => 'nullable|numeric',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2MB max
    ]);

    // Gérer le fichier photo si uploadé
    if ($request->hasFile('photo')) {
        // Supprimer l'ancienne photo si elle existe
        if ($incident->photo && file_exists(public_path('storage/' . $incident->photo))) {
            unlink(public_path('storage/' . $incident->photo));
        }

        // Stocker la nouvelle photo
        $path = $request->file('photo')->store('incidents', 'public');
        $validatedData['photo'] = $path;
    }

    // Mettre à jour l'incident
    $incident->update($validatedData);

    // Rediriger avec un message
    return redirect()->route('admin.panel')->with('success', 'Incident mis à jour avec succès.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incident $incident)
    {
        $incident->delete();
        return redirect()->route('admin.panel')->with('danger', 'Incident deleted successfully.');
    }
    

    public function liste()
{
    $incidents = Incident::with(['category', 'user'])->get();
    return view('incident.liste', compact('incidents'));
}
}
