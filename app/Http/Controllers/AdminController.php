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
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin');
    }
    public function showAdminPanel()
{
    return view('admin.panel', [
        'users' => User::all(),
        'admin'=>auth()->user(),
        'incidents' => Incident::with('category', 'user')->get(),
        'reclamations' => Reclamation::with('incident', 'user')->get(),
        'categories' => \App\Models\Categorie::all(),
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
