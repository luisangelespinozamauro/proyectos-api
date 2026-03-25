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
                'email' => $user->email,
            ]
        ], 200);
    }
}
