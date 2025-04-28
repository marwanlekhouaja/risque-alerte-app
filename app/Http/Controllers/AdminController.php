<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Reclamation;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    public function showAdminPanel()
    {
        $users = User::all();
        $categories = \App\Models\Categorie::all();

        $query = Incident::with('category', 'user');

        // Appliquer le filtre par catégorie si sélectionnée
        if (request()->has('category') && request()->category != '') {
            $query->where('id_category', request()->category);
        }

        // Appliquer le filtre par préfecture (en minuscule)
        if (request()->has('prefecture') && request()->prefecture != '') {
            $query->whereRaw('LOWER(prefecture) = ?', [strtolower(request()->prefecture)]);
        }

        $incidents = $query->get();

        // Pour générer une liste unique de préfectures normalisées
        $prefectures = Incident::selectRaw('LOWER(prefecture) as prefecture')
            ->distinct()
            ->pluck('prefecture');

        $reclamations = Reclamation::with('incident', 'user')->get();

        return view('admin.panel', [
            'admin' => auth()->user(),
            'users' => $users,
            'incidents' => $incidents,
            'reclamations' => $reclamations,
            'categories' => $categories,
            'usersCount' => $users->count(),
            'incidentsCount' => $incidents->count(),
            'reclamationsCount' => $reclamations->count(),
            'prefectures' => $prefectures,
        ]);
    }


    public function editProfile()
    {
        $admin = Auth::user();  // Get the currently authenticated user (admin)
        return view('admin.profile', compact('admin'));  // Pass the admin data to the view
    }

    /**
     * Update the admin's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {

        $admin = Auth::user();

        $data = [
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return back()->with('success', 'Profil mis à jour avec succès');

    }
}
