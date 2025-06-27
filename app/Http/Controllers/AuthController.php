<?php
namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function show()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            // Check the user's role
            if (auth()->user()->role === 'admin') {
                return to_route('admin.panel');
            } elseif (auth()->user()->role == "chargeclientele") {
                return to_route('chargeclientele.dashboard');

            } else {
                return to_route('incidents.index');
            }
        }

        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


    public function logout(Request $request)
    {

        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
       
        return redirect()->route('auth.show')->with('success', 'Logged out successfully.');
    }
    public function show_register_page()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nom'=>'required|string|max:255',
            'prenom'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:4'
        ]);

        User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'adresse' => $request->adresse ? $request->adresse : null,
            'telephone' => $request->telephone,
            'role' => $request->role ? $request->role : null
        ]);

        return redirect()->route('auth.show')->with('success', 'User created successfully.');
    }
}
