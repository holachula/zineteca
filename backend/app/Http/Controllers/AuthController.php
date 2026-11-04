<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * LOGIN
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        /** @var User $user */
        $user = Auth::user()->load('autor');

        // Nombre del token según rol
        $tokenName = $user->role === 'admin'
            ? 'admin-token'
            : 'author-token';

        $token = $user->createToken($tokenName)->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * USUARIO AUTENTICADO (/me)
     */
    public function me(Request $request)
    {
        return response()->json(
            $request->user()->load('autor')
        );
    }

    /**
     * LOGOUT (revoca token actual)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ]);
    }
}
