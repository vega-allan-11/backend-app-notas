<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // 🟦 Registro de usuario
    public function register(Request $request)
{
    if (!$request->expectsJson()) {
        return response()->json(['message' => 'Solo se aceptan solicitudes JSON'], 406);
    }

    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|string|email|unique:users,email',
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
        ],
    ], [
        // Mensajes personalizados
        'password.regex'     => 'La contraseña debe tener al menos 8 caracteres, incluir una mayúscula, una minúscula, un número y un símbolo.',
        'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        'email.unique' => 'Este email ya existe.'
    ]);

    $user = User::create([
        'name'     => $validated['name'],
        'email'    => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    return response()->json([
        'message' => 'Usuario registrado correctamente'
    ], 201);
}


    // 🟨 Login de usuario
    public function login(Request $request)
    {
        if (!$request->expectsJson()) {
            return response()->json(['message' => 'Solo se aceptan solicitudes JSON'], 406);
        }

        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales son incorrectas.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ]);
    }

public function updateProfile(Request $request)
{
    $user = auth()->user();

    // Elimina campos vacíos del request
    $request->merge(array_filter($request->only([
        'name', 'email', 'password', 'current_password', 'password_confirmation'
    ])));

    // Validación condicional
    $validated = $request->validate([
        'name'                  => 'sometimes|string|max:255',
        'email'                 => 'sometimes|string|email|unique:users,email,' . $user->id,
        'current_password'      => 'required_with:password|string',
        'password'              => 'nullable|string|min:6|confirmed',
        'password_confirmation' => 'nullable|string'
    ]);

    // Cambio de contraseña si fue solicitada
    if (!empty($validated['password'])) {
        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json(['message' => 'La contraseña actual no es válida'], 403);
        }
        $user->password = bcrypt($validated['password']);
    }

    if (isset($validated['name'])) {
        $user->name = $validated['name'];
    }

    if (isset($validated['email'])) {
        $user->email = $validated['email'];
    }

    $user->save();

    return response()->json(['message' => 'Perfil actualizado correctamente']);
}



public function getProfile(Request $request)
{
    return response()->json($request->user());
}


}
