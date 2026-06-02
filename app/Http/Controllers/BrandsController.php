<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BrandsController extends Controller
{

    public function index()
    {
        $brands = Brand::select(
            'id',
            'name',
            'estado',
            'created_at'
        )
            ->where('estado', '!=', 0)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($brands, 200);
    }

    public function store(Request $request)
    {
        $validated = $this->validateBrand($request);

        $validated['estado'] = $validated['estado'] ?? 2;

        $brand = Brand::create($validated);

        return response()->json([
            'message' => 'Marca creada correctamente',
            'data'    => $brand
        ], 201);
    }

    public function show($id)
    {
        $brand = Brand::select(
            'id',
            'name',
            'estado',
            'created_at'
        )
            ->where('id', $id)
            ->where('estado', '!=', 0)
            ->firstOrFail();

        return response()->json($brand, 200);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::where('id', $id)
            ->where('estado', '!=', 0)
            ->firstOrFail();

        $validated = $this->validateBrand($request, $id);

        $brand->update($validated);

        if (isset($validated['estado'])) {
            Project::where('brand_id', $brand->id)
                ->update([
                    'estado' => $validated['estado']
                ]);
        }

        return response()->json([
            'message' => 'Marca actualizada correctamente',
            'data'    => $brand
        ], 200);
    }

    private function validateBrand(Request $request, $id = null)
    {
        return $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('brands', 'name')
                        ->ignore($id)
                        ->where(function ($query) {
                            return $query->where('estado', '!=', 0);
                        }),
                ],

                // En update sí puede modificarse
                'estado' => 'sometimes|in:1,2',
            ],
            // [
            //     'name.required' => 'El nombre es obligatorio.',
            //     'name.string'   => 'El nombre debe ser una cadena de texto.',
            //     'name.max'      => 'El nombre no debe exceder los 255 caracteres.',
            //     'name.unique'   => 'El nombre ya existe. Por favor, elige otro.',

            //     'estado.in' => 'El estado debe ser 1 (Inactivo) o 2 (Activo).',
            // ]
        );
    }
}
