<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Incident;
use Illuminate\Support\Str;
use App\Models\User;
use App\Notifications\ReclamationValidee;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function index()web.
    // {
    //     // if (auth()->user()->role == "user") {
    //         $incidents = Incident::with(['category', 'user'])->get();

    //     //     $notifications = auth()->user()->unreadNotifications;
    //     //     ;
    //         return view('incident.index', compact('incidents', ));

    //     // return abort(4message: 03,'Acces interdit');
    // }
    public function index(Request $request)
    {
        $user = auth()->user(); // Récupère l'utilisateur connecté

        $categories = Categorie::all();

        // Préfectures distinctes basées sur les incidents de l'utilisateur connecté
        $prefectures = Incident::where('id_user', $user->id)
            ->selectRaw('DISTINCT LOWER(prefecture) as prefecture')
            ->whereNotNull('prefecture')
            ->pluck('prefecture')
            ->map(fn($p) => ucfirst($p))
            ->sort()
            ->unique()
            ->values();

        // Préparation de la requête incidents de l'utilisateur connecté
        $query = Incident::with(['category', 'user'])
            ->where('id_user', $user->id);

        if ($request->filled('categorie')) {
            $query->where('id_category', $request->categorie);
        }

        if ($request->filled('prefecture')) {
            $query->whereRaw('LOWER(prefecture) = ?', [strtolower($request->prefecture)]);
        }

        $incidents = $query->get();

        return view('incident.index', compact('incidents', 'categories', 'prefectures'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = User::all();
        $categories = Categorie::all();
        return view('incident.create', compact('clients', 'categories'));
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
            'id_user' => 'required',
            'id_category' => 'required',
            'prefecture' => 'required',
            'date' => ''
        ]);

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

        // Mettre à jour l'incident
        Incident::create($validatedData);

        // Rediriger avec un message
        return to_route('admin.panel')->with('success', 'Incident creer avec succès.');
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
        if(auth()->user()->role!="admin"){
            return redirect()->route('chargeclientele.dashboard')->with('success', value: 'Incident mis à jour avec succès.');
        }
        return redirect()->route('admin.panel')->with('success', 'Incident mis à jour avec succès.');
        // return redirect()->back()->with('success', value: 'Incident mis à jour avec succès.');

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incident $incident)
    {
        $incident->delete();
        // return redirect()->route('admin.panel')->with('danger', 'Incident deleted successfully.');
        return redirect()->back()->with('danger', 'Incident deleted successfully.');

    }


    public function liste()
    {
        $incidents = Incident::with(['category', 'user'])->get();
        return view('incident.liste', compact('incidents'));
    }

    public function valider($id)
    {
        $incident = Incident::findOrFail($id);
        $incident->statut = 'validé';
        $incident->save();

        // // Notification à l'utilisateur
        $user = $incident->user;
        if ($user) {
            $user->notify(new ReclamationValidee($incident));
        }

        return redirect()->back()->with('success', value: 'Incident validé avec succès.');
    }
}
