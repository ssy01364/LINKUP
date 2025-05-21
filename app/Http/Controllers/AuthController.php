<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Role;
use App\Models\Empresa;            // ← Importa Empresa
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
        // Pasamos los roles "cliente" y "empresa" al formulario
        $roles = Role::whereIn('nombre', ['cliente', 'empresa'])->get();
        return view('auth.register', compact('roles'));
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
            'nombre'     => 'required|string|max:100',
            'email'      => 'required|string|email|unique:usuarios,email',
            'password'   => 'required|string|min:6|confirmed',
            'role_id'    => 'required|exists:roles,id',
        ]);

        // 1) Creamos el usuario
        $user = Usuario::create([
            'nombre'        => $data['nombre'],
            'email'         => $data['email'],
            'password_hash' => Hash::make($data['password']),
            'role_id'       => $data['role_id'],
        ]);

        // 2) Si es empresa, creamos automáticamente su perfil en empresas
        if ($user->role->nombre === 'empresa') {
            $user->empresa()->create([
                // Laravel rellenará usuario_id por la relación
                'sector_id'   => 1,              // sector por defecto (ajusta si lo necesitas)
                'nombre'      => $user->nombre,
                'descripcion' => '',
                'direccion'   => '',
                'telefono'    => '',
            ]);
        }

        // 3) Loguear y regenerar sesión
        auth()->login($user);
        $request->session()->regenerate();

        // 4) Redirigir según rol
        if ($user->role->nombre === 'empresa') {
            return redirect()->route('empresa.dashboard');
        }

        return redirect()->route('cliente.search.form');
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

        // Redirige según rol
        $role = auth()->user()->role->nombre;
        if ($role === 'empresa') {
            return redirect()->route('empresa.dashboard');
        }

        return redirect()->route('cliente.search.form');
    }

    /**
     * Logout (API y web).
     */
    public function logout(Request $request)
    {
        if ($request->is('api/*')) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logout completado'], 200);
        }

        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
