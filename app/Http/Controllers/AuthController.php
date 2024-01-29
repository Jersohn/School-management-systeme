<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // L'utilisateur est authentifié
            return redirect()->intended('dashboard');
        }

        // Authentification échouée, afficher un message d'erreur
        return view('login')->with(['error' => 'Identifiants invalides']);
    }
}
