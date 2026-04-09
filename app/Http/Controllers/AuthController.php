<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login($collaborator_number)
    {
        try {
            $user = User::where('collaborator_number', $collaborator_number)->first();

            if (!$user) {
                return response()->json([
                    'error' => 'Empleado no encontrado.'
                ], 404);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Autenticación exitosa',
                'user' => $user,
                'token' => $token
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al autenticar empleado',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function user(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'message' => 'Usuario autenticado',
            'user' => [
                'id' => $user->id,
                'role_id' => $user->role_id,
                'collaborator_number' => $user->collaborator_number,
                'name' => $user->name,
                'last_name' => $user->last_name,
                'phone' => $user->phone,
                'email' => $user->email,
            ]
        ], 200);
    }

    public function verManual($tipo)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        $roles = [
            1 => 'super-admin',
            2 => 'admin',
            3 => 'consultor'
        ];

        if (!isset($roles[$user->role_id]) || $roles[$user->role_id] !== $tipo) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $path = storage_path("app/manuales/{$tipo}.pdf");

        if (!file_exists($path)) {
            return response()->json(['message' => 'Archivo no encontrado'], 404);
        }

        return response()->file($path);
    }
}
