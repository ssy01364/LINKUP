<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de login (web).
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Mostrar formulario de registro (web).
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Registrar usuario (API y web).
     */
    public function register(Request $request)
    {
        if ($request->is('api/*')) {
            // ——— Lógica API ———
            $data = $request->validate([
                'nombre'   => 'required|string|max:100',
                'email'    => 'required|string|email|unique:usuarios,email',
                'password' => 'required|string|min:6|confirmed',
                'role_id'  => 'required|exists:roles,id',
            ]);

            $user = Usuario::create([
                'nombre'        => $data['nombre'],
                'email'         => $data['email'],
                'password_hash' => Hash::make($data['password']),
                'role_id'       => $data['role_id'],
            ]);

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'user'  => $user,
                'token' => $token,
            ], 201);
        }

        // ——— Lógica Web ———
        $data = $request->validate([
            'nombre'                => 'required|string|max:100',
            'email'                 => 'required|string|email|unique:usuarios,email',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        // Creación como cliente (role_id = 1)
        $user = Usuario::create([
            'nombre'        => $data['nombre'],
            'email'         => $data['email'],
            'password_hash' => Hash::make($data['password']),
            'role_id'       => 1,
        ]);

        auth()->login($user);
        $request->session()->regenerate();

        return redirect()->intended('/cliente/buscar');
    }

    /**
     * Login (API y web).
     */
    public function login(Request $request)
    {
        if ($request->is('api/*')) {
            // ——— Lógica API ———
            $data = $request->validate([
                'email'    => 'required|string|email',
                'password' => 'required|string',
            ]);

            $user = Usuario::where('email', $data['email'])->first();
            if (! $user || ! Hash::check($data['password'], $user->password_hash)) {
                throw ValidationException::withMessages([
                    'email' => ['Las credenciales no son correctas.'],
                ]);
            }

            // opcional: $user->tokens()->delete();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'user'  => $user,
                'token' => $token,
            ]);
        }

        // ——— Lógica Web ———
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (! auth()->attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Credenciales incorrectas.'])
                ->withInput(['email' => $request->email]);
        }

        $request->session()->regenerate();
        return redirect()->intended('/cliente/buscar');
    }

    /**
     * Logout (API y web).
     */
    public function logout(Request $request)
    {
        if ($request->is('api/*')) {
            // ——— Lógica API ———
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logout completado'], 200);
        }

        // ——— Lógica Web ———
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
