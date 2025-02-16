<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Registra un nuevo usuario y genera un token JWT.
     *
     * @param RegisterUserRequest $request Datos validados del registro.
     * @return JsonResponse Retorna mensaje de éxito y el token JWT.
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        $token = auth()->login($user);

        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'token'   => $token
        ], 201);
    }

    /**
     * Autentica al usuario y retorna un token JWT.
     *
     * @param LoginUserRequest $request Datos validados de login.
     * @return JsonResponse Retorna mensaje de éxito y el token JWT o error 401 si las credenciales son inválidas.
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        return response()->json([
            'message' => 'Login exitoso',
            'token'   => $token
        ]);
    }
}
