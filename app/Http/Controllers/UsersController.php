<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function roles()
    {
        $roles = Role::all();

        return response()->json($roles, 200);
    }
    
    public function index()
    {
        $users = User::select(
            'id',
            'role_id',
            'collaborator_number',
            'name',
            'last_name',
            'phone',
            'email',
            'password',
            'estado',
            'created_at',
        )
            ->where('estado', '!=', 0)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($users, 200);
    }

    public function store(Request $request)
    {
        $validated = $this->validateUsuario($request);

        $validated['password'] = Hash::make('password');

        $user = User::create($validated);

        return response()->json([
            'message' => 'Usuario creado correctamente',
            'data'    => $user
        ], 201);
    }

    public function show($id)
    {
        $user = User::select(
            'id',
            'role_id',
            'collaborator_number',
            'name',
            'last_name',
            'phone',
            'email',
            'password',
            'estado',
            'created_at',
        )
            ->where('id', $id)
            ->where('estado', '!=', 0)
            ->firstOrFail();

        return response()->json($user, 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)
            ->where('estado', '!=', 0)
            ->firstOrFail();

        $validated = $this->validateUsuario($request, $id);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'data'    => $user
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::where('id', $id)
            ->where('estado', '!=', 0)
            ->firstOrFail();

        $user->update(['estado' => 0]);

        return response()->json([
            'message' => 'Usuario eliminado correctamente'
        ], 200);
    }

    private function validateUsuario(Request $request, $id = null)
    {
        return $request->validate(
            [
                'role_id' => 'required|exists:roles,id',
                'collaborator_number' => 'required|unique:users,collaborator_number,' . $id,
                'name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'phone' => 'nullable|integer|digits:10',
                'email' => 'nullable|email|unique:users,email,' . $id,
            ],
            [
                'role_id.required' => 'El rol es requerido',
                'role_id.exists' => 'El rol no existe',
                'collaborator_number.required' => 'El número de colaborador es requerido',
                'collaborator_number.unique' => 'El número de colaborador ya existe',
                'name.required' => 'El nombre es requerido',
                'last_name.required' => 'El apellido es requerido',
                'phone.integer' => 'El teléfono debe ser un número',
                'phone.digits' => 'El teléfono debe tener 10 dígitos',
                'email.email' => 'El correo electrónico no es válido',
                'email.unique' => 'El correo electrónico ya existe',

            ]
        );
    }
}
