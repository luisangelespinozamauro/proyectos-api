<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    public function index()
    {
        $permissions = Permission::select(
            'id',
            'name',
            'slug',
            'estado',
            'created_at',
        )
            ->where('estado', '!=', 0)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($permissions, 200);
    }

    public function store(Request $request)
    {
        $validated = $this->validatePermissions($request);

        $permission = Permission::create($validated);

        return response()->json([
            'message' => 'Permiso creado correctamente',
            'data'    => $permission
        ], 201);
    }

    public function show($id)
    {
        $permission = Permission::select(
            'id',
            'name',
            'slug',
            'estado',
            'created_at',
        )
            ->where('id', $id)
            ->where('estado', '!=', 0)
            ->firstOrFail();

        return response()->json($permission, 200);
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::where('id', $id)
            ->where('estado', '!=', 0)
            ->firstOrFail();

        $validated = $this->validatePermissions($request, $id);

        $permission->update($validated);

        return response()->json([
            'message' => 'Permiso actualizado correctamente',
            'data'    => $permission
        ], 200);
    }

    public function validatePermissions(Request $request, $id = null)
    {
        return $request->validate(
            [
                'name' => 'required|string|max:255|unique:permissions,name,' . $id,
                'slug' => 'required|string|max:255|unique:permissions,slug,' . $id,
                'estado' => 'nullable|in:0,1,2',
            ],
            [
                // 'name.required' => 'El nombre es obligatorio',
                // 'name.max'      => 'El nombre no puede tener más de 255 caracteres',
                // 'name.unique'   => 'El nombre ya existe',
                // 'slug.required' => 'El slug es obligatorio',
                // 'slug.max'      => 'El slug no puede tener más de 255 caracteres',
                // 'slug.unique'   => 'El slug ya existe',
                // 'estado.in'     => 'El estado debe ser 1 (Inactivo) o 2 (Activo).',
            ]
        );
    }
}
