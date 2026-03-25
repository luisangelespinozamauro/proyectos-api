<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::select(
            'id',
            'nr',
            'brand',
            'model',
            'product_family',
            'estimated_volume',
            'questionnaire_completion',
            'nda_status',
            'mou_status',
            'tca_status',
            'contract_status',
            'bom_status',
            'price_agreement',
            'project_status',
            'assembly_approach',
            'assembly_line',
            'layout',
            'production_2026',
            'potential_volume',
            'comments',
            'next_steps',
            'created_at',
            'estado',
        )
            ->where('estado', '!=', 0)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($projects, 200);
    }

    public function store(Request $request)
    {
        $validated = $this->validateProject($request);

        $project = Project::create($validated);

        return response()->json([
            'message' => 'Proyecto creado correctamente',
            'data'    => $project
        ], 201);
    }

    public function show($id)
    {
        $project = Project::select(
            'id',
            'nr',
            'brand',
            'model',
            'product_family',
            'estimated_volume',
            'questionnaire_completion',
            'nda_status',
            'mou_status',
            'tca_status',
            'contract_status',
            'bom_status',
            'price_agreement',
            'project_status',
            'assembly_approach',
            'assembly_line',
            'layout',
            'production_2026',
            'potential_volume',
            'comments',
            'next_steps',
            'created_at',
            'estado',
        )
            ->where('id', $id)
            ->where('estado', '!=', 0)
            ->firstOrFail();

        return response()->json($project, 200);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $validated = $this->validateProject($request, $id);

        $project->update($validated);

        return response()->json([
            'message' => 'Proyecto actualizado correctamente',
            'data'    => $project
        ]);
    }

    public function destroy($id)
    {
        $project = Project::where('id', $id)
            ->where('estado', '!=', 0)
            ->firstOrFail();

        $project->update(['estado' => 0]);

        return response()->json([
            'message' => 'Proyecto eliminado correctamente'
        ], 200);
    }

    private function validateProject(Request $request, $id = null)
    {
        return $request->validate([
            'nr' => 'nullable|integer',

            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'product_family' => 'nullable|string|max:255',

            'estimated_volume' => 'nullable|integer',
            'questionnaire_completion' => 'nullable|string|max:255',

            'nda_status' => 'nullable|string|max:100',

            'mou_status' => 'nullable|string|max:100',
            'tca_status' => 'nullable|string|max:100',
            'contract_status' => 'nullable|string|max:100',
            'bom_status' => 'nullable|string|max:100',

            'price_agreement' => 'nullable|string|max:255',
            'project_status' => 'nullable|string|max:100',

            'assembly_approach' => 'nullable|string|max:100',
            'assembly_line' => 'nullable|string|max:100',
            'layout' => 'nullable|string|max:100',

            'production_2026' => 'nullable|integer',
            'potential_volume' => 'nullable|integer',

            'comments' => 'nullable|string',
            'next_steps' => 'nullable|string',
        ]);
    }
}
