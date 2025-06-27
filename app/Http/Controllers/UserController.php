<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users',
        ]);

        User::create(attributes: [
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'adresse' => $request->adresse??null,
            'telephone' => $request->telephone,
            'role' => $request->role ?? 'user', // Default to 'client' if not provided
        ]);

        return redirect()->route('admin.panel')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->only(['nom', 'prenom', 'email']);

        // Check if a new password is provided and not empty
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if($request->has('role')) {
            $data['role'] = $request->role;
        }

        $user->update($data);

        if(auth()->user()->role=="admin"){
            return redirect()->route('admin.panel')->with('success', 'Profile est bien modifié.');
        }
        else if(auth()->user()->role=="chargeclientele"){
            return redirect()->route('chargeclientele.dashboard')->with('success', 'User updated successfully.');
        }
        return redirect()->route('incidents.index')->with('success', 'User updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.panel')->with('danger', 'User deleted successfully.');
    }
}
